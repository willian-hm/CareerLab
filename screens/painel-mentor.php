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
                <table class="tabela-mentorias">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Área</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Local/Link</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mentorias as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m['titulo'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['nome_area'] ?? 'Não informada') ?></td>
                                <td><?= htmlspecialchars($m['data'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['horario'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['local'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['status'] ?? '') ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nenhuma mentoria cadastrada ainda.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>

</html>