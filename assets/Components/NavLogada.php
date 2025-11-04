    <?php

    $foto = $_SESSION['fotousuario'];
    $nome = $_SESSION['nomeusuario'];

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
         <li><a href="feed.php">Feed</a></li>
        <li><a href="mentorias.php">Mentorias</a></li>
        <li><a href="desafios.php">Desafios</a></li>
        <li><a href="ranking.php">Ranking</a></li>
        <li><a href="pesquisar.php">Pesquisar</a></li>

        <!-- Menu do usuário -->
        <li class="user-menu">
                <?php
                $fotoPerfil = !empty($foto) && file_exists("../uploads/" . $foto
                    ) ? "../uploads/" . htmlspecialchars($foto) : "../uploads/default.png";
                ?>
                <img src="<?= $fotoPerfil ?>" alt="Foto do usuário" class="foto-perfilnav">
            <ul class="dropdown">
                <li><b><?= htmlspecialchars($_SESSION['nomeusuario']) ?></b></li>
                <li><a href="meu-perfil.php">Perfil</a></li>
                <li><a href="configuracoes.php">Configurações</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </li>
    </ul>

    <div class="menu-toggle">&#9776;</div>
</nav>

<script>
const userMenu = document.querySelector('.user-menu');
const dropdown = userMenu.querySelector('.dropdown');

userMenu.addEventListener('click', function(e){
    e.stopPropagation();
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', function(){
    dropdown.style.display = 'none';
});

const menuToggle = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});
</script>
