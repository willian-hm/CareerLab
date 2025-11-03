<?php

require_once "../assets/incs/valida-sessao.php";
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
    <title>Novo Post - CareerLab</title>
    <link rel="stylesheet" href="cadastro-post.css">
</head>

<body>
    <?php include_once "../assets/Components/NavLogada.php"; ?>

    <main class="post-container">
        <section class="post-card">
            <h1 class="titulo">Criar Novo Post</h1>

            <?php if ($mensagem): ?>
                <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <form action="processa-post.php" method="POST" enctype="multipart/form-data" class="form-post">

                <!-- Preview da imagem -->
                <div class="preview-container" id="preview">
                    <span>Pré-visualização da imagem</span>
                </div>

                <!-- Upload -->
                <label for="foto" class="upload-btn">Escolher Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*" required>

                <!-- Select da área -->
                <label for="idarea" class="label-area">Área do Post:</label>
                <select name="idarea" id="idarea" required>
                    <option value="">Escolha uma Área</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= $area['idarea'] ?>"><?= htmlspecialchars($area['nome_a']) ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Legenda -->
                <textarea name="legenda" placeholder="Escreva uma legenda..." required></textarea>

                <button type="submit" class="btn">Publicar</button>
            </form>
        </section>
    </main>

    <?php include_once "../assets/Components/Footer.php"; ?>

    <script>
        const inputFoto = document.getElementById('foto');
        const preview = document.getElementById('preview');

        inputFoto.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Pré-visualização">`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `<span>Pré-visualização da imagem</span>`;
            }
        });
    </script>
</body>

</html>
