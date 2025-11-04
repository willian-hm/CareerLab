<?php
if (!isset($_SESSION)) session_start();
?>

<nav class="navbar">
    <div class="nav-container">
        <a href="painel-mentor.php" class="logo">CareerLab - Mentor</a>
        <ul class="nav-links">
            <li><a href="painel-mentor.php">Painel</a></li>
            <li><a href="#">Minhas Mentorias</a></li>
            <li><a href="#">Perfil</a></li>
            <li><a href="logout-mentor.php" class="logout">Sair</a></li>
        </ul>
        <?php if(isset($_SESSION['fotomentor'])): ?>
            <img src="../uploads/<?= $_SESSION['fotomentor'] ?>" alt="Foto" class="foto-perfil">
        <?php endif; ?>
    </div>
</nav>

<style>
.navbar {
    background: #1f3b6e;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.nav-container {
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: space-between;
}
.logo {
    color: #fff;
    font-weight: bold;
    text-decoration: none;
}
.nav-links {
    list-style: none;
    display: flex;
    gap: 15px;
}
.nav-links a {
    color: #fff;
    text-decoration: none;
}
.logout {
    color: #ff8c8c;
}
.foto-perfil {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
