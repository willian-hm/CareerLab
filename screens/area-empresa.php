<?php
include_once "../assets/incs/valida-sessao-empresa.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área da Empresa</title>
    <link rel="stylesheet" href="area-empresa.css">
</head>
<body>
    <?php include "../assets/Components/NavLogadaEmpresa.php"; ?>

    <main>
        <h1>Bem-vinda, <?= htmlspecialchars($nomeempresa) ?>!</h1>
        <p>Aqui você pode gerenciar suas vagas e visualizar suas oportunidades.</p>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
