<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/SeguidoDAO.php";

$idUsuario = $_SESSION['idusuario'];

// Lista de seguidores
$pdo = ConexaoBD::conectar();
$stmt = $pdo->prepare("
    SELECT u.idusuario, u.nome_u AS nome, u.foto
    FROM seguido s
    JOIN usuario u ON s.idusuario = u.idusuario
    WHERE s.idseguido = :idUsuario
    ORDER BY u.nome_u ASC
");
$stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();
$seguidores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Seguidores | CareerLab</title>
    <link rel="stylesheet" href="seguir.css">
</head>
<body>

<?php include "../assets/Components/NavLogada.php"; ?>

<main >
    <div class="container">
    <h2>Seguidores</h2>

    <?php if ($seguidores): ?>
        <?php foreach ($seguidores as $seguidor): ?>
            <div class="usuario-card">
                <div class="usuario-info">
                    <img src="../uploads/<?= htmlspecialchars($seguidor['foto'] ?? 'default.png') ?>" alt="Foto do usuário">
                    <span><?= htmlspecialchars($seguidor['nome']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Você não possui seguidores ainda.</p>
    <?php endif; ?>
        </div>
</main>

<?php include "../assets/Components/Footer.php"; ?>

</body>
</html>
