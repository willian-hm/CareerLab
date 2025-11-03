<?php
include "../assets/incs/valida-sessao.php";
require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/AreaDAO.php";
require_once "../assets/src/CurtidaDAO.php";
require_once "../assets/src/ComentarioDAO.php";

$areas = AreaDAO::listarAreas();
$filtroArea = $_GET['filtro'] ?? null;
$posts = PostagemDAO::listarPosts($filtroArea);
$idusuario = $_SESSION['idusuario'];
?>

<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - CareerLab</title>
    <link rel="stylesheet" href="feed.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

<main class="feed-container">
    <!-- Cabeçalho do feed -->
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
            <?php
            // Valores padrão para evitar null
            $post['idpostagem'] = $post['idpostagem'] ?? 0;
            $post['nome_u'] = $post['nome_u'] ?? 'Usuário';
            $post['nome_a'] = $post['nome_a'] ?? 'Geral';
            $post['foto_usuario'] = $post['foto_usuario'] ?? 'padrao.png';
            $post['foto'] = $post['foto'] ?? 'padrao-post.png';
            $post['legenda'] = $post['legenda'] ?? '';

            $curtiu = CurtidaDAO::usuarioCurtiu($idusuario, $post['idpostagem']);
            $totalCurtidas = CurtidaDAO::contarCurtidas($post['idpostagem']);
            $primeiroComentario = ComentarioDAO::obterPrimeiroComentario($post['idpostagem']);
            $totalComentarios = ComentarioDAO::contarComentarios($post['idpostagem']);
            ?>
            <div class="post-card card mb-3" data-id="<?= $post['idpostagem'] ?>">
                <img src="../uploads/<?= htmlspecialchars($post['foto']) ?>" class="card-img-top"
                    alt="Post de <?= htmlspecialchars($post['nome_u']) ?>">
                <div class="card-body">
                    <div class="usuario"><strong><?= htmlspecialchars($post['nome_u']) ?></strong></div>
                    <div class="area"><?= htmlspecialchars($post['nome_a']) ?></div>
                    <div class="legenda"><?= nl2br(htmlspecialchars($post['legenda'])) ?></div>

                    <div class="d-flex align-items-center mt-2">
                        <!-- Curtidas -->
                        <div class="curtidas me-3">
                            <button class="btn-curtir btn btn-light">
                                <?php if ($curtiu): ?>
                                    <i class="bi bi-heart-fill text-danger"></i>
                                <?php else: ?>
                                    <i class="bi bi-heart"></i>
                                <?php endif; ?>
                            </button>
                            <span class="contador"><?= $totalCurtidas ?></span>
                        </div>

                        <!-- Comentários -->
                        <div class="comentarios">
                            <button class="btn-comentar btn btn-light" data-id="<?= $post['idpostagem'] ?>">
                                <i class="bi bi-chat"></i>
                                <span class="contador-comentario"><?= $totalComentarios ?></span>
                            </button>
                        </div>
                    </div>

                    <!-- Primeiro comentário -->
                    <?php if ($primeiroComentario): ?>
                        <div class="primeiro-comentario mt-2">
                            <strong><?= htmlspecialchars($primeiroComentario['nome_u'] ?? 'Usuário') ?>:</strong>
                            <?= nl2br(htmlspecialchars($primeiroComentario['conteudo'] ?? '')) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum post encontrado.</p>
    <?php endif; ?>
</main>

<?php include "../assets/Components/Footer.php"; ?>

<!-- Modal Comentários -->
<div class="modal fade" id="comentarioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comentários</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="lista-comentarios"></div>
                <textarea id="novo-comentario" class="form-control mt-2" placeholder="Escreva um comentário..."></textarea>
                <button id="enviar-comentario" class="btn btn-primary mt-2">Comentar</button>
            </div>
        </div>
    </div>
</div>

<!-- JS Bootstrap e Feed -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Curtir/Descurtir
    document.querySelectorAll('.btn-curtir').forEach(btn => {
        btn.addEventListener('click', async () => {
            const card = btn.closest('.post-card');
            const idpostagem = card.dataset.id;
            const formData = new FormData();
            formData.append('idpostagem', idpostagem);
            try {
                const res = await fetch('curtir.php', { method: 'POST', body: formData });
                const data = await res.json();
                if (data.error) { alert(data.error); return; }

                card.querySelector('.contador').textContent = data.total;
                const icon = btn.querySelector('i');
                if (data.curtiu) {
                    icon.classList.remove('bi-heart');
                    icon.classList.add('bi-heart-fill', 'text-danger');
                } else {
                    icon.classList.remove('bi-heart-fill', 'text-danger');
                    icon.classList.add('bi-heart');
                }
            } catch (err) { console.error(err); alert('Erro ao curtir/descurtir.'); }
        });
    });

    // Comentários
    let postagemAtual = null;
    document.querySelectorAll('.btn-comentar').forEach(btn => {
        btn.addEventListener('click', async () => {
            postagemAtual = btn.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('comentarioModal'));
            modal.show();

            const res = await fetch('processa-comentario.php', {
                method: 'POST',
                body: new URLSearchParams({ idpostagem: postagemAtual, acao: 'listar' })
            });
            const data = await res.json();
            const lista = document.getElementById('lista-comentarios');
            lista.innerHTML = '';
            data.forEach(c => {
                const div = document.createElement('div');
                div.classList.add('mb-2');
                div.innerHTML = `<strong>${c.nome_u ?? 'Usuário'}:</strong> ${c.conteudo ?? ''}`;
                lista.appendChild(div);
            });
        });
    });

    document.getElementById('enviar-comentario').addEventListener('click', async () => {
        const conteudo = document.getElementById('novo-comentario').value.trim();
        if (!conteudo) return alert('Digite um comentário');
        const res = await fetch('processa-comentario.php', {
            method: 'POST',
            body: new URLSearchParams({
                idpostagem: postagemAtual,
                conteudo,
                acao: 'enviar'
            })
        });
        const data = await res.json();
        if (data.sucesso) {
            const lista = document.getElementById('lista-comentarios');
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = `<strong>${data.nome_u ?? 'Usuário'}:</strong> ${conteudo}`;
            lista.appendChild(div);
            document.querySelector(`.post-card[data-id='${postagemAtual}'] .contador-comentario`).textContent = data.total;
            document.getElementById('novo-comentario').value = '';
        } else {
            alert(data.error);
        }
    });
</script>


</body>
</html>
