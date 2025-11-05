<?php
if (!isset($_SESSION)) session_start();

$fotoempresa = $_SESSION['fotoempresa'] ?? null;

// Caminho da foto
$fotoPerfil = !empty($fotoempresa) && file_exists("../uploads/" . $fotoempresa)
    ? "../uploads/" . htmlspecialchars($fotoempresa)
    : "../uploads/default.png";
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
        <a href="area-empresa.php"><img src="../img/logo.png" alt="Logo"></a>
    </div>

    <ul class="nav-links">
        <li><a href="area-empresa.php">Área da Empresa</a></li>

        <li class="user-menu">
            <img src="<?= $fotoPerfil ?>" alt="Foto da empresa" class="foto-perfilnav">
            <ul class="dropdown">
                <li><b><?= htmlspecialchars($_SESSION['nomeempresa']) ?></b></li>
                <li><a href="logout-empresa.php">Sair</a></li>
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
