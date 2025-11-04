<?php
require_once "../assets/incs/valida-sessao-mentor.php";
require_once "../assets/src/MentorDAO.php";

$idmentor = $_SESSION['idmentor'];
$mentor = MentorDAO::buscarPorId($idmentor);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Mentor</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div class="container">
        <h1>Bem-vindo, <?= htmlspecialchars($mentor['nome_mentor']) ?>!</h1>

        <div class="perfil-mentor">
            <img src="../assets/uploads/<?= htmlspecialchars($mentor['foto'] ?? 'padrao.jpg') ?>" 
                 alt="Foto do mentor" 
                 width="120" height="120">

            <p><strong>Área:</strong> <?= htmlspecialchars($mentor['area_mentor']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($mentor['email_mentor']) ?></p>
            <p><strong>Bio:</strong> <?= htmlspecialchars($mentor['bio_mentor'] ?? 'Sem bio') ?></p>
        </div>

        <div class="acoes">
            <a href="cadastro-mentoria.php" class="botao">+ Criar Mentoria</a>
            <a href="editar-mentor.php" class="botao">✏️ Editar Perfil</a>
            <a href="../assets/incs/logout-mentor.php" class="botao sair">🚪 Sair</a>
        </div>
    </div>

</body>
</html>
