<?php
include_once "../assets/incs/valida-sessao-empresa.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Desafio</title>
    <link rel="stylesheet" href="area-empresa.css">
</head>
<body>
    <?php include "../assets/Components/NavLogadaEmpresa.php"; ?>

    <main>
        <h1>Cadastrar Novo Desafio</h1>
        <form action="processa-desafio.php" method="POST" class="form-desafio">
            <label>Nome do Desafio:</label>
            <input type="text" name="nomedesafio" required maxlength="100">

            <label>Orientações do Desafio:</label>
            <textarea name="orientacaodesafio" rows="6" required></textarea>

            <label>Quantidade de Vagas:</label>
            <input type="number" name="vagaslimite" min="1" required>

            <button type="submit" class="botao-area">Salvar Desafio</button>
        </form>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
