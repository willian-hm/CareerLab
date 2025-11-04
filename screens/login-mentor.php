<?php
session_start();
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Mentor</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>
<main>
    <div class="container">
        <h1>Login do Mentor</h1>

        <?php if ($mensagem): ?>
            <p class="mensagem"><?= $mensagem ?></p>
        <?php endif; ?>

        <form method="POST" action="processa-login-mentor.php">
            <label>Email:</label>
            <input type="email" name="email_mentor" required>

            <label>Senha:</label>
            <input type="password" name="senha_mentor" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</main>
    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
