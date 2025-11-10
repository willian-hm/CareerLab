<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quem é Você?</title>
    <link rel="stylesheet" href="index.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

     :root {
            --azul-escuro: #085c67;
            --azul: #087788;
            --turquesa: #00cbb5;
            --cinza: #323b3b;
            --cinza-claro: #f2f6f6;
            --amarelo: #fdbc29;
        }

    body,
    html {
        height: 100%;
        font-family: "Poppins", sans-serif;
        overflow: hidden;
    }

    /* Fundo com degradê */
    body {
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #ffffff 0%, #e9f2ff 100%);
        position: relative;
    }

    /* Partículas animadas */
    .particle {
        position: absolute;
        background: #08677D;
        border-radius: 50%;
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0) scale(1);
            opacity: 0.8;
        }

        50% {
            transform: translateY(-50px) scale(1.1);
            opacity: 1;
        }

        100% {
            transform: translateY(0) scale(1);
            opacity: 0.8;
        }
    }

    /* Container principal */
    .main-content {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2;
        padding: 20px;
    }

    /* Card central */
    .card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 3rem 3.5rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
        animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card h1 {
        font-size: 2.2rem;
        color: var(--azul-escuro);
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    .card p {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 2.2rem;
    }

    /* Botões dentro do card */
    .botoes-tipo-conta {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .botoes-tipo-conta a {
        display: inline-block;
        padding: 14px 20px;
        background: #08677D;
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px #08677D;
        position: relative;
        overflow: hidden;
    }

    .botoes-tipo-conta a::before {
        content: "";
        position: absolute;
        top: 0;
        left: -75%;
        width: 50%;
        height: 100%;
        background: rgba(255, 255, 255, 0.3);
        transform: skewX(-25deg);
        transition: 0.5s;
    }

    .botoes-tipo-conta a:hover::before {
        left: 125%;
    }

    .botoes-tipo-conta a:hover {
        transform: scale(1.05);
        background: var(--amarelo);
        font-weight: bold;
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    }

    /* Footer */
    footer {
        margin-top: auto;
        z-index: 2;
    }

    /* Responsividade */
    @media (max-width: 600px) {
        .card {
            padding: 2.5rem 2rem;
        }

        .card h1 {
            font-size: 1.8rem;
        }

        .card p {
            font-size: 1rem;
        }

        .botoes-tipo-conta a {
            font-size: 0.95rem;
        }
    }
    </style>
</head>

<body>
    <?php include "../assets/Components/NavBar.php"; ?>

    <!-- Partículas -->
    <div class="particle" style="width: 100px; height: 100px; top: 10%; left: 15%; animation-delay: 0s;"></div>
    <div class="particle" style="width: 80px; height: 80px; top: 60%; left: 75%; animation-delay: 2s;"></div>
    <div class="particle" style="width: 120px; height: 120px; top: 40%; left: 40%; animation-delay: 4s;"></div>
    <div class="particle" style="width: 60px; height: 60px; top: 75%; left: 25%; animation-delay: 6s;"></div>

    <div class="main-content">
        <div class="card">
            <h1>Quem é você?</h1>
            <p>Escolha seu tipo de conta para continuar:</p>

            <div class="botoes-tipo-conta">
                <a href="login-usuario.php">Sou Estudante</a>
                <a href="login-mentor.php">Sou Mentor</a>
                <a href="login-empresa.php">Sou Empresa</a>
            </div>
        </div>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>
</body>

</html>