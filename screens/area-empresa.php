<?php
include_once "../assets/incs/valida-sessao-empresa.php";
require_once "../assets/src/DesafioDAO.php";

$desafios = DesafioDAO::listarPorEmpresa($idempresa);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área da Empresa</title>
    <link rel="stylesheet" href="area-empresa.css">
</head>
<body>
    <?php include "../assets/Components/NavLogadaEmpresa.php"; ?>

    <main>
        <h1>Bem-vinda, <?= htmlspecialchars($nomeempresa) ?>!</h1>
        <p>Aqui você pode gerenciar seus desafios e vagas disponíveis.</p>

        <div class="botoes-area">
            <a href="cadastra-desafio.php" class="botao-area">+ Criar Desafio</a>
        </div>

        <section class="cards-info">
            <?php if (empty($desafios)): ?>
                <p>Nenhum desafio cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($desafios as $d): ?>
                    <div class="card-info" onclick="abrirModal('<?= htmlspecialchars($d['nomedesafio']) ?>', '<?= nl2br(htmlspecialchars($d['orientacaodesafio'])) ?>', <?= (int)$d['vagaslimite'] ?>)">
                        <h3><?= htmlspecialchars($d['nomedesafio']) ?></h3>
                        <p><strong>Vagas:</strong> <?= (int)$d['vagaslimite'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <!-- Modal Detalhes -->
    <div id="modalDesafio" class="modal">
        <div class="modal-conteudo">
            <span class="fechar" onclick="fecharModal()">&times;</span>
            <h2 id="modalNome"></h2>
            <p id="modalOrientacao"></p>
            <p><strong>Vagas:</strong> <span id="modalVagas"></span></p>
        </div>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>

    <script>
        function abrirModal(nome, orientacao, vagas) {
            document.getElementById('modalNome').innerText = nome;
            document.getElementById('modalOrientacao').innerHTML = orientacao;
            document.getElementById('modalVagas').innerText = vagas;
            document.getElementById('modalDesafio').style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modalDesafio').style.display = 'none';
        }

        window.onclick = function(e) {
            if (e.target.id === "modalDesafio") fecharModal();
        }
    </script>
</body>
</html>
