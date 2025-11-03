<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/SeguidoDAO.php";

$idUsuario = $_SESSION['idusuario'];

// Lista de usuários que estou seguindo
$pdo = ConexaoBD::conectar();
$stmt = $pdo->prepare("
    SELECT u.idusuario, u.nome_u AS nome, u.foto
    FROM seguido s
    JOIN usuario u ON s.idseguido = u.idusuario
    WHERE s.idusuario = :idUsuario
    ORDER BY u.nome_u ASC
");
$stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$seguindo = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Seguindo | CareerLab</title>
    <link rel="stylesheet" href="seguir.css">
</head>

<body>

    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <div class="container">


            <h2>Seguindo</h2>

            <?php if ($seguindo): ?>
                <?php foreach ($seguindo as $usuarioSeguido): ?>
                    <a href="deixar-seguir-perfil.php?id=<?= $usuarioSeguido['idusuario'] ?>">
                        <div class="usuario-card">
                        <div class="usuario-info">
                            <?php
                            $fotoPerfil = !empty($usuarioSeguido['foto']) && file_exists("../uploads/" . $usuarioSeguido['foto'])
                                ? "../uploads/" . htmlspecialchars($usuarioSeguido['foto'])
                                : "../uploads/default.png";

                            ?>
                            <img src="<?= $fotoPerfil ?>" alt="Foto do usuário" class="foto-perfil">
                            <span><?= htmlspecialchars($usuarioSeguido['nome']) ?></span>
                        </div>
                    </div>
                    </a>
                    
                <?php endforeach; ?>
            <?php else: ?>
                <p>Você não está seguindo ninguém ainda.</p>
            <?php endif; ?>

        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $('.btn-deixar-seguir').click(function () {
            const btn = $(this);
            const idSeguido = btn.data('id');

            $.post('deixar-seguir.php', { idSeguido }, function () {
                btn.closest('.usuario-card').remove();
            });
        });
    </script>

    <?php include "../assets/Components/Footer.php"; ?>


</body>

</html>