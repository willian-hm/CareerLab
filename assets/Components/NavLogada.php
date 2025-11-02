    <link rel="stylesheet" href="nav-logada.css" />    
    <nav>
    <div class="navbar-logo">
         <a href="feed.php"><img src="../img/logo.png" alt="Logo"></a>
    </div>

    <ul class="nav-links">
        <li><a href="mentorias.php">Mentorias</a></li>
        <li><a href="desafios.php">Desafios</a></li>
        <li><a href="ranking.php">Ranking</a></li>

        <!-- Menu do usuário -->
        <li class="user-menu">
            <img src="../uploads/<?= htmlspecialchars($foto ?? 'default.png') ?>" alt="<?= htmlspecialchars($nome ?? 'Usuário') ?>" class="user-foto">
            <ul class="dropdown">
                <li><a href="perfil.php">Perfil</a></li>
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
