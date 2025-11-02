<?php
// Inclui validação de sessão para qualquer tipo de usuário
include "../assets/incs/valida-sessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feed</title>
    <link rel="stylesheet" href="cadastro.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            padding: 50px;
        }

        footer {
            margin-top: auto;
        }

        .btn-logout {
            margin-top: 20px;
            padding: 10px 20px;
            font-weight: bold;
            background-color: #1f3b6e;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background-color: #16325a;
        }

        img.profile {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #1f3b6e;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>

    <div class="main-content">
        <h1>Bem-vindo(a), <?= isset($nome) ? htmlspecialchars($nome) : 'Usuário' ?>!</h1>
        <p>Tipo de conta: <?= isset($tipo) ? ucfirst($tipo) : '' ?></p>

        <?php if(isset($foto) && $foto): ?>
            <img src="../uploads/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" class="profile">
        <?php endif; ?>

        <a href="../assets/incs/logout.php" class="btn-logout">Sair</a>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
