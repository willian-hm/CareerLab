<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem é Você?</title>
    <link rel="stylesheet" href="index.css">
    <style>
        /* Container principal ocupa toda a tela e centraliza o conteúdo */
        body, html {
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
            text-align: center;
            flex-direction: column;
        }

        .botoes-tipo-conta a {
            display: inline-block;
            margin: 10px;
        }

        /* Footer fixo no final da tela */
        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>

    <div class="main-content">
        <h1>Quem é você?</h1>
        <p>Escolha seu tipo de conta para continuar:</p>

        <div class="botoes-tipo-conta">
            <a href="login-usuario.php" class="btn btn-primary">Sou Estudante</a>
            <a href="login-mentor.php" class="btn btn-primary">Sou Mentor</a>
            <a href="login-empresa.php" class="btn btn-primary">Sou Empresa</a>
        </div>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
