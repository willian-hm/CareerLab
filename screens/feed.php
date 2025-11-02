<?php
include "../assets/incs/valida-sessao.php"; // garante que só usuários logados acessam
require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/AreaDAO.php";

$areas = AreaDAO::listarAreas();
$filtroArea = $_GET['filtro'] ?? null;

$posts = PostagemDAO::listarPosts($filtroArea);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - CareerLab</title>
    <link rel="stylesheet" href="feed.css">
</head>
<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main class="feed-container">

        <!-- Cabeçalho do feed: título, filtro e botão -->
        <div class="feed-header">
            <h1>Feed de Posts</h1>

            <div class="feed-actions">
                <form method="GET" style="display:inline-block;">
                    <select name="filtro" onchange="this.form.submit()">
                        <option value="">Todas as Áreas</option>
                        <?php foreach ($areas as $area): ?>
                            <option value="<?= $area['idarea'] ?>" <?= ($filtroArea == $area['idarea']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($area['nome_a']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <a href="cadastro-post.php" class="btn-post">Criar Post</a>
            </div>
        </div>

        <!-- Lista de posts -->
        <?php if ($posts): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <img src="../uploads/<?= htmlspecialchars($post['foto']) ?>" alt="Post de <?= htmlspecialchars($post['nome_u']) ?>">

                    <div class="post-content">
                        <div class="usuario"><?= htmlspecialchars($post['nome_u']) ?></div>
                        <div class="area"><?= htmlspecialchars($post['nome_a'] ?? 'Geral') ?></div>
                        <div class="legenda"><?= nl2br(htmlspecialchars($post['legenda'])) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum post encontrado.</p>
        <?php endif; ?>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
