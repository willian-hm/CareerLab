<?php
if (!isset($_SESSION))
    session_start();
?>

<link rel="stylesheet" href="nav-logada.css" />

<style>
    .foto-perfilnav {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .foto-perfilnav:hover {
        cursor: pointer;
        opacity: 0.8;
        border: 1px solid #ccc;
    }
</style>
<nav>
    <div class="navbar-logo">
        <a href="feed.php"><img src="../img/logo.png" alt="Logo"></a>
    </div>

    <ul class="nav-links">
        <li><a href="painel-mentor.php">Painel do Mentor</a></li>

        <!-- Menu do usuário -->
        <li class="user-menu">
            <?php
            $fotoPerfil = !empty($fotomentor) && file_exists(
                "../uploads/" . $fotomentor
            ) ? "../uploads/" . htmlspecialchars($fotomentor) : "../uploads/default.png";
            ?>
            <img src="<?= $fotoPerfil ?>" alt="Foto do usuário" class="foto-perfilnav">
            <ul class="dropdown">
                <li><b><?= htmlspecialchars($_SESSION['nomementor']) ?></b></li>
                <li><a href="logout-mentor.php">Sair</a></li>
            </ul>
        </li>
    </ul>

    <div class="menu-toggle">&#9776;</div>
</nav>

<script>
    const userMenu = document.querySelector('.user-menu');
    const dropdown = userMenu.querySelector('.dropdown');

    userMenu.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function () {
        dropdown.style.display = 'none';
    });

    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
</script>