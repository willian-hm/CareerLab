<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/DesafioDAO.php";
require_once "../assets/src/InscricaoDesafioDAO.php";

$filtro = $_GET['filtro'] ?? 'disponiveis'; // padrão

if ($filtro === 'meus') {
    $desafios = InscricaoDesafioDAO::listarPorUsuario($id);
} else {
    $desafios = DesafioDAO::listarNaoInscritos($id);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Desafios</title>
    <link rel="stylesheet" href="area-empresa.css">
    <style>
        .botao-filtro { 
            background: #eee; padding: 10px 20px; border-radius: 10px; margin: 5px; 
            border: none; cursor: pointer; font-weight: bold;
        }
        .botao-filtro.ativo { background: #1f3b6e; color: white; }
        .card-desafio {
            background: #fafafa; border: 1px solid #ccc; border-radius: 10px;
            padding: 20px; margin: 15px auto; max-width: 700px;
        }
        .botao-inscrever, .botao-cancelar {
            background: #1f3b6e; color: white; border: none; padding: 10px 20px;
            border-radius: 8px; cursor: pointer; margin-top: 10px;
        }
        .botao-cancelar { background: #dc3545; }
        .orientacao {
            background: #f7f9ff; padding: 20px; border-radius: 12px; margin: 20px auto; 
            max-width: 700px; border: 1px solid #cce;
        }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <h1>Desafios</h1>

        <div class="orientacao">
            <p><strong>Orientação:</strong> As submissões devem ser feitas por meio de um repositório público no GitHub contendo os arquivos do projeto ou o que for requisitado no desafio. 
            Inclua um README explicando o funcionamento do projeto e quaisquer instruções necessárias para a avaliação.</p>
        </div>

        <div style="text-align:center;">
            <a href="?filtro=disponiveis">
                <button class="botao-filtro <?= $filtro==='disponiveis'?'ativo':'' ?>">Disponíveis</button>
            </a>
            <a href="?filtro=meus">
                <button class="botao-filtro <?= $filtro==='meus'?'ativo':'' ?>">Minhas Inscrições</button>
            </a>
        </div>

        <?php if (empty($desafios)): ?>
            <p style="text-align:center; margin-top:30px;">Nenhum desafio encontrado.</p>
        <?php else: ?>
            <?php foreach ($desafios as $d): ?>
                <div class="card-desafio">
                    <h2><?= htmlspecialchars($d['nomedesafio']) ?></h2>
                    <p><?= nl2br(htmlspecialchars($d['orientacaodesafio'])) ?></p>

                    <?php if ($filtro === 'meus'): ?>
                        <p><strong>Link enviado:</strong> 
                            <a href="<?= htmlspecialchars($d['linkgit']) ?>" target="_blank"><?= htmlspecialchars($d['linkgit']) ?></a>
                        </p>
                        <form action="cancelar-inscricao.php" method="POST">
                            <input type="hidden" name="iddesafio" value="<?= $d['iddesafio'] ?>">
                            <button class="botao-cancelar" type="submit">Cancelar Inscrição</button>
                        </form>
                    <?php else: ?>
                        <a href="inscrever-desafio.php?id=<?= $d['iddesafio'] ?>">
                            <button class="botao-inscrever">Inscrever-se</button>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
