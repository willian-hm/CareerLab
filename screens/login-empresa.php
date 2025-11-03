<?php
session_start();
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login Empresa</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>
<main>
 <div class="container">
        <h1>Login Empresa</h1>
        <?php if($mensagem) echo "<p class='mensagem'>$mensagem</p>"; ?>
        <form method="POST" action="processa-login-empresa.php">
            <label>CNPJ:</label>
            <input type="email" name="cnpj" required>

            <label>Senha:</label>
            <input type="password" name="senha_empresa" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</main>
   

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
