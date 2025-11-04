<?php
include_once "../assets/incs/valida-sessao-mentor.php";
require_once "../assets/src/MentorDAO.php";

$mentor = MentorDAO::buscarPorId($idmentor);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Mentor</title>
    <link rel="stylesheet" href="painel.css">
</head>
<body>
    <?php include "../assets/Components/NavBarLogadaMentor.php"; ?>

<main>
    <div class="container">
        <h1>Bem-vindo, <?= htmlspecialchars($mentor['nome_mentor']) ?>!</h1>
        <p><strong>Área:</strong> <?= htmlspecialchars($mentor['area_nome'] ?? 'Não informada') ?></p>
        <p><strong>Bio:</strong> <?= htmlspecialchars($mentor['bio_m']) ?></p>
        <p><strong>LinkedIn:</strong> <a href="<?= htmlspecialchars($mentor['linkedin']) ?>" target="_blank"><?= $mentor['linkedin'] ?></a></p>
    </div>
</main>
</body>
</html>
