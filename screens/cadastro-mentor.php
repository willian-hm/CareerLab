<?php
session_start();
require_once "../assets/src/MentorDAO.php";
require_once "../assets/src/AreaDAO.php";

$areas = AreaDAO::listarAreas();
$mensagem = $_SESSION['mensagem'] ?? "";
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Mentor</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <?php include "../assets/Components/NavBar.php"; ?>

<main>
    <div class="container">
        <h1>Cadastro de Mentor</h1>
        <?php if($mensagem): ?><p class="mensagem"><?= $mensagem ?></p><?php endif; ?>

        <form method="POST" enctype="multipart/form-data" action="processa-mentor.php">
            <label>Foto:</label>
            <input type="file" name="foto" accept="image/*" onchange="previewImage(event)">
            <div id="preview-container"><img id="preview" style="display:none;"></div>

            <label>Nome:</label>
            <input type="text" name="nome_mentor" required>

            <label>Email:</label>
            <input type="email" name="email_mentor" required>

            <label>Área de Especialização:</label>
            <select name="areaespecializacao" required>
                <option value="">Selecione...</option>
                <?php foreach ($areas as $a): ?>
                    <option value="<?= $a['idarea'] ?>"><?= $a['nome_a'] ?></option>
                <?php endforeach; ?>
            </select>

            <label>LinkedIn:</label>
            <input type="text" name="linkedin">

            <label>Bio:</label>
            <textarea name="bio_m" rows="3"></textarea>

            <label>Senha:</label>
            <input type="password" name="senha_mentor" required>

            <label>Confirme a Senha:</label>
            <input type="password" name="confirma_senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</main>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => {
        const img = document.getElementById('preview');
        img.src = reader.result;
        img.style.display = 'block';
        img.style.borderRadius = '50%';
        img.style.width = '150px';
        img.style.height = '150px';
        img.style.objectFit = 'cover';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</body>
</html>
