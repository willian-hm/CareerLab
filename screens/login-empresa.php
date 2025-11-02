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
    <link rel="stylesheet" href="cadastro.css">
    <style>
        /* Centraliza o conteúdo da página */
        .container {
            max-width: 500px;
            margin: 200px auto;
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }


        /* Footer sempre no final */
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>

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

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
