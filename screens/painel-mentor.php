<?php
include_once "../assets/incs/valida-sessao-mentor.php";
require_once "../assets/src/MentorDAO.php";
require_once "../assets/src/MentoriaDAO.php"; // novo DAO

$mentor = MentorDAO::buscarPorId($idmentor);
$mentorias = MentoriaDAO::listarPorMentor($idmentor);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Painel do Mentor</title>
    <link rel="stylesheet" href="painel-mentor.css">
</head>

<body>
    <?php include "../assets/Components/NavBarLogadaMentor.php"; ?>

    <main>
        <div class="container">
            <h1>Bem-vindo, <?= htmlspecialchars($mentor['nome_mentor']) ?>!</h1>
            <p><strong>Área:</strong> <?= htmlspecialchars($mentor['area_nome'] ?? 'Não informada') ?></p>
            <p><strong>Bio:</strong> <?= htmlspecialchars($mentor['bio_m']) ?></p>
            <p><strong>LinkedIn:</strong>
                <a href="<?= htmlspecialchars($mentor['linkedin']) ?>" target="_blank">
                    <?= htmlspecialchars($mentor['linkedin']) ?>
                </a>
            </p>

            <hr>

            <div class="acoes">
                <a href="cadastro-mentoria.php" class="botao-criar">+ Criar Mentoria</a>
            </div>

            <h2>Suas Mentorías</h2>

            <?php if (count($mentorias) > 0): ?>
                <div class="cards-mentorias">
                    <?php foreach ($mentorias as $m): ?>
                        <div class="card-mentoria" onclick="abrirModal(<?= htmlspecialchars(json_encode($m)) ?>)">
                            <h3><?= htmlspecialchars($m['titulo'] ?? 'Sem título') ?></h3>
                            <p><strong>Data:</strong> <?= htmlspecialchars($m['data'] ?? '—') ?></p>
                            <p><strong>Horário:</strong> <?= htmlspecialchars($m['horario'] ?? '—') ?></p>
                            <span class="status <?= strtolower($m['status'] ?? '') ?>">
                                <?= htmlspecialchars($m['status'] ?? '—') ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Nenhuma mentoria cadastrada ainda.</p>
            <?php endif; ?>

            <!-- Modal -->
            <div id="modal-mentoria" class="modal">
                <div class="modal-content">
                    <span class="fechar" onclick="fecharModal()">&times;</span>
                    <h2 id="modal-titulo"></h2>
                    <p><strong>Área:</strong> <span id="modal-area"></span></p>
                    <p><strong>Data:</strong> <span id="modal-data"></span></p>
                    <p><strong>Horário:</strong> <span id="modal-horario"></span></p>
                    <p><strong>Local:</strong> <span id="modal-local"></span></p>
                    <p><strong>Vagas:</strong> <span id="modal-vagas"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    <p><strong>Descrição:</strong></p>
                    <p id="modal-descricao"></p>

                    <a id="botao-editar" href="#" class="botao-editar">Editar</a>
                    <a id="botao-excluir" href="#" class="botao-excluir">Excluir Mentoria</a>
                </div>
            </div>

            <script>
                function abrirModal(mentoria) {
                    document.getElementById("modal-titulo").innerText = mentoria.titulo;
                    document.getElementById("modal-area").innerText = mentoria.nome_area || 'Não informada';
                    document.getElementById("modal-data").innerText = mentoria.data || '—';
                    document.getElementById("modal-horario").innerText = mentoria.horario || '—';
                    document.getElementById("modal-local").innerText = mentoria.local || '—';
                    document.getElementById("modal-vagas").innerText = mentoria.vaga_limite || '—';
                    document.getElementById("modal-status").innerText = mentoria.status || '—';
                    document.getElementById("modal-descricao").innerText = mentoria.descricao || '—';

                    // editar
                    document.getElementById("botao-editar").href = "editar-mentoria.php?id=" + mentoria.idmentoria;

                    // excluir — confirma antes de ir
                    document.getElementById("botao-excluir").href = "processa-exclusao-mentoria.php?id=" + mentoria.idmentoria;
                    document.getElementById("botao-excluir").onclick = function (e) {
                        if (!confirm('Tem certeza que deseja excluir esta mentoria?')) {
                            e.preventDefault();
                            return false;
                        }
                        return true;
                    };

                    document.getElementById("modal-mentoria").style.display = "flex";
                }

                function fecharModal() {
                    document.getElementById("modal-mentoria").style.display = "none";
                }
            </script>



        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>

</html>