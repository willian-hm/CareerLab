<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/SeguidoDAO.php";

$idUsuarioLogado = $_SESSION['idusuario'];
$pesquisa = $_GET['pesquisa'] ?? '';

$usuarios = SeguidoDAO::listarUsuariosParaSeguir($idUsuarioLogado, $pesquisa);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pesquisar Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="pesquisar.css">
</head>

<body>

    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <div class="container mt-4">
            <h1>Pesquisar Usuários</h1>

            <form method="GET" class="mb-3">
                <input type="text" name="pesquisa" placeholder="Pesquisar usuários..."
                    value="<?= htmlspecialchars($pesquisa) ?>">
                <button type="submit">Buscar</button>
            </form>




            <div class="usuarios-grid">
                <?php if ($usuarios): ?>
                    <?php foreach ($usuarios as $user):
                        $foto = !empty($user['foto']) && file_exists("../uploads/" . $user['foto'])
                            ? "../uploads/" . $user['foto']
                            : "../uploads/default.png";

                        ?>
                        <div class="usuario-card">
                            <a href="perfil.php?id=<?= $user['idusuario'] ?>">
                                <img src="<?= $foto ?>" alt="<?= htmlspecialchars($user['nome']) ?>">
                                <span><?= htmlspecialchars($user['nome']) ?></span>
                            </a>
                            <?php if ($user['idusuario'] != $idUsuarioLogado): ?>
                                <form method="POST" action="processa-seguir.php">
                                    <input type="hidden" name="idSeguido" value="<?= $user['idusuario'] ?>">
                                    <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                                    <button type="submit" class="btn-seguir" data-id="<?= $user['idusuario'] ?>">
                                        Seguir
                                    </button>
                                </form>

                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="sem-usuarios">Nenhum usuário encontrado.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include "../assets/Components/footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

</body>

</html>