<?php
session_start();
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Usuário</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>
<main>
     <div class="container">
        <h1>Login Usuário</h1>
        <?php if($mensagem) echo "<p class='mensagem'>$mensagem</p>"; ?>
        <form method="POST" action="processa-login-usuario.php">
            <label>Nome de Usuário:</label>
            <input type="text" name="nome_u" required>
            
            <label>Senha:</label>
            <input type="password" name="senha_u" required>
            
            <button type="submit">Entrar</button>
        </form>
    </div>
</main>
   

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
