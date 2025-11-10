<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/ConexaoBD.php";

$conexao = ConexaoBD::conectar();

$iddesafio = $_GET['id'] ?? null;

if (!$iddesafio) {
  die("ID do desafio não fornecido.");
}

// Busca informações do desafio
$stmt = $conexao->prepare("SELECT * FROM desafio WHERE iddesafio = ?");
$stmt->execute([$iddesafio]);
$desafio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$desafio) {
  die("Desafio não encontrado.");
}

// Lista usuários inscritos e verifica se foram selecionados
$sql = "
SELECT u.idusuario, u.nome_u, u.email_u,
       CASE WHEN ps.idusuario IS NOT NULL THEN 1 ELSE 0 END AS selecionado
FROM inscricaodesafio i
JOIN usuario u ON i.idusuario = u.idusuario
LEFT JOIN projetoselecionado ps 
       ON ps.idusuario = u.idusuario AND ps.iddesafio = i.iddesafio
WHERE i.iddesafio = ?
ORDER BY u.nome_u;
";
$stmt = $conexao->prepare($sql);
$stmt->execute([$iddesafio]);
$inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel de Seleção</title>
  <link rel="stylesheet" href="area-empresa.css">
  <style>
    main {
      max-width: 900px;
      margin: 80px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      color: var(--azul-escuro);
      margin-bottom: 20px;
    }

    .inscrito {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 16px;
      border-bottom: 1px solid #eee;
    }

    .info {
      flex: 1;
    }

    button {
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }

    .btn-selecionar {
      background: var(--azul);
      color: #fff;
    }

    .btn-desmarcar {
      background: var(--vermelho);
      color: #fff;
    }

    .status {
      margin-left: 10px;
      font-size: 14px;
      color: var(--turquesa);
    }
  </style>
</head>
<body>
  <?php include "../assets/Components/NavLogada.php"; ?>

  <main>
    <h1>Seleção de Projeto: <?= htmlspecialchars($desafio['nomedesafio']) ?></h1>

    <?php if (empty($inscritos)): ?>
      <p>Nenhum inscrito neste desafio.</p>
    <?php else: ?>
      <?php foreach ($inscritos as $a): ?>
        <div class="inscrito" data-id="<?= $a['idusuario'] ?>">
          <div class="info">
            <strong><?= htmlspecialchars($a['nome_u']) ?></strong><br>
            <small><?= htmlspecialchars($a['email_u']) ?></small>
          </div>
          <div class="acoes">
            <?php if ($a['selecionado']): ?>
              <button class="btn-desmarcar">Desmarcar</button>
            <?php else: ?>
              <button class="btn-selecionar">Selecionar Projeto</button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </main>

  <script>
    document.querySelectorAll('.btn-selecionar, .btn-desmarcar').forEach(btn => {
      btn.addEventListener('click', async () => {
        const linha = btn.closest('.inscrito');
        const idusuario = linha.dataset.id;
        const acao = btn.classList.contains('btn-desmarcar') ? 'desmarcar' : 'selecionar';

        const formData = new FormData();
        formData.append('iddesafio', <?= $iddesafio ?>);
        formData.append('idusuario', idusuario);
        formData.append('acao', acao);

        const resp = await fetch('selecionar-projeto.php', {
          method: 'POST',
          body: formData
        });

        const data = await resp.json();

        if (data.status === 'ok') {
          if (acao === 'selecionar') {
            btn.textContent = 'Desmarcar';
            btn.classList.remove('btn-selecionar');
            btn.classList.add('btn-desmarcar');
          } else {
            btn.textContent = 'Selecionar Projeto';
            btn.classList.remove('btn-desmarcar');
            btn.classList.add('btn-selecionar');
          }
        } else {
          alert(data.mensagem || 'Erro ao atualizar seleção.');
        }
      });
    });
  </script>
</body>
</html>
