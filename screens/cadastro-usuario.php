<?php
session_start();
require_once "../assets/src/UsuarioDAO.php";
require_once "../assets/src/AreaDAO.php";

$areas = AreaDAO::listarAreas();
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="cadastro.css">
</head>

<body>
    <?php include "../assets/Components/NavBar.php"; ?>

    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <?php if ($mensagem): ?>
            <p class="mensagem"><?= $mensagem ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data" action="processa-usuario.php">

            <label>Foto de Perfil:</label>
            <input type="file" name="foto" accept="image/*" onchange="previewImage(event)">
            <small>Recomendado imagens 600x600</small>
            <div id="preview-container">
                <img id="preview" src="#" alt="Preview" style="display:none;">
            </div>

            <label>Nome:</label>
            <input type="text" name="nome_u" required>

            <label>Email:</label>
            <input type="email" name="email_u" required>

            <label>Data de Nascimento:</label>
            <input type="date" name="datanascimento_u" required>

            <label>Área de Especialização:</label>
            <select name="areaespecializacao" required>
                <option value="">Selecione...</option>
                <?php foreach ($areas as $area): ?>
                    <option value="<?= $area['idarea'] ?>"><?= $area['nome_a'] ?></option>
                <?php endforeach; ?>
            </select>

            <label>Senha:</label>
            <input type="password" name="senha_u" required>

            <label>Confirme a Senha:</label>
            <input type="password" name="confirma_senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
                output.style.borderRadius = '50%';
                output.style.width = '150px';
                output.style.height = '150px';
                output.style.objectFit = 'cover';
                output.style.border = '2px solid #1f3b6e';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>