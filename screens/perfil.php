<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";
require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/CurtidaDAO.php";
require_once "../assets/src/ComentarioDAO.php";

$idUsuarioPerfil = isset($_GET['id']) ? (int) $_GET['id'] : null;
if (!$idUsuarioPerfil) {
    header("Location: index.php");
    exit;
}

$idUsuarioLogado = $_SESSION['idusuario'] ?? null;

$usuario = UsuarioDAO::buscarPorId($idUsuarioPerfil);
if (!$usuario) {
    header("Location: index.php");
    exit;
}

$postagens = PostagemDAO::listarPorUsuario($idUsuarioPerfil);

// Valores padrão para exibição
$usuario['foto'] = $usuario['foto'] ?? 'default.png';
$usuario['nome'] = $usuario['nome'] ?? 'Usuário';
$usuario['area'] = $usuario['area'] ?? 'Sem área';
$usuario['bio'] = $usuario['bio'] ?? '';
$usuario['seguidores'] = $usuario['seguidores'] ?? 0;
$usuario['seguindo'] = $usuario['seguindo'] ?? 0;
?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Perfil | CareerLab</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="perfil.css">
</head>

<body>

    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <div class="perfil-container">
            <div class="perfil-header">
                <?php
                $fotoPerfil = !empty($usuario['foto']) && file_exists("../uploads/" . $usuario['foto'])
                    ? "../uploads/" . htmlspecialchars($usuario['foto'])
                    : "../uploads/default.png";
                ?>
                <img src="<?= $fotoPerfil ?>" alt="Foto do usuário" class="foto-perfil">
                <div class="perfil-info">
                    <h2><?= htmlspecialchars($usuario['nome']) ?></h2>
                    <p class="area"><?= htmlspecialchars($usuario['area']) ?></p>
                    <p class="bio"><?= htmlspecialchars($usuario['bio']) ?></p>
                    <div class="seguidores" style="font-weight: 600;">
                        <!-- Novo: badge de XP -->
                        <div class="xp-badge" >
                            <?= (int) ($usuario['exp']) ?> XP
                        </div>
                        <span><strong><?= $usuario['seguidores'] ?></strong>
                                Seguidores</span>
                       <span><strong><?= $usuario['seguindo'] ?></strong>
                                Seguindo</span>
                    </div>
                    <div class="botoes">
                        <form method="POST" action="processa-seguir.php">
                            <input type="hidden" name="idSeguido" value="<?= $idUsuarioPerfil ?>">
                            <input type="hidden" name="redirect"
                                value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                            <button type="submit" class="btn-seguir" data-id="<?= $user['idusuario'] ?>">
                                Seguir
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <hr>

            <h3>Publicações</h3>
            <div class="postagens-grid">
                <?php if ($postagens): ?>
                    <?php foreach ($postagens as $post):
                        $curtiu = CurtidaDAO::usuarioCurtiu($idUsuarioLogado, $post['idpostagem']);
                        $totalCurtidas = CurtidaDAO::contarCurtidas($post['idpostagem']);
                        $totalComentarios = ComentarioDAO::contarComentarios($post['idpostagem']);

                        $post['foto_usuario'] = $post['foto_usuario'] ?? 'default.png';
                        $post['nome_usuario'] = $post['nome_usuario'] ?? 'Usuário';
                        $post['area'] = $post['area'] ?? 'Sem área';
                        $post['foto'] = $post['foto'] ?? 'default-post.png';
                        $post['legenda'] = $post['legenda'] ?? '';
                        ?>
                        <div class="post-card card mb-3" data-id="<?= $post['idpostagem'] ?>">
                            <img src="../uploads/<?= htmlspecialchars($post['foto']) ?>" class="card-img-top" alt="Postagem">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong><?= htmlspecialchars($post['nome_usuario']) ?></strong>
                                </div>
                                <div class="legenda mt-2"><?= nl2br(htmlspecialchars($post['legenda'])) ?></div>

                                <div class="d-flex align-items-center mt-2">
                                    <div class="curtidas me-3">
                                        <button class="btn-curtir btn btn-light">
                                            <i class="bi <?= $curtiu ? 'bi-heart-fill text-danger' : 'bi-heart' ?>"></i>
                                        </button>
                                        <span class="contador"><?= $totalCurtidas ?></span>
                                    </div>
                                    <div class="comentarios">
                                        <button class="btn-comentar btn btn-light" data-id="<?= $post['idpostagem'] ?>">
                                            <i class="bi bi-chat"></i>
                                            <span class="contador-comentario"><?= $totalComentarios ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma publicação.</p>
                <?php endif; ?>

            </div>
        </div>

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
                        <textarea id="novo-comentario" class="form-control mt-2"
                            placeholder="Escreva um comentário..."></textarea>
                        <button id="enviar-comentario" class="btn btn-primary mt-2">Comentar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include "../assets/Components/Footer.php"; ?>

    <script>
        // Curtir
        document.querySelectorAll('.btn-curtir').forEach(btn => {
            btn.addEventListener('click', async () => {
                const card = btn.closest('.post-card');
                const idpostagem = card.dataset.id;
                const res = await fetch('curtir.php', { method: 'POST', body: new URLSearchParams({ idpostagem }) });
                const data = await res.json();
                if (data.error) return alert(data.error);

                card.querySelector('.contador').textContent = data.total;
                const icon = btn.querySelector('i');
                icon.className = 'bi ' + (data.curtiu ? 'bi-heart-fill text-danger' : 'bi-heart');
            });
        });

        // Comentários
        let postagemAtual = null;
        document.querySelectorAll('.btn-comentar').forEach(btn => {
            btn.addEventListener('click', async () => {
                postagemAtual = btn.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('comentarioModal'));
                modal.show();

                const res = await fetch('processa-comentario.php', { method: 'POST', body: new URLSearchParams({ idpostagem: postagemAtual, acao: 'listar' }) });
                const data = await res.json();
                const lista = document.getElementById('lista-comentarios');
                lista.innerHTML = '';
                data.forEach(c => {
                    const div = document.createElement('div');
                    div.innerHTML = `<strong>${c.nome_u}:</strong> ${c.conteudo}`;
                    lista.appendChild(div);
                });
            });
        });

        document.getElementById('enviar-comentario').addEventListener('click', async () => {
            const conteudo = document.getElementById('novo-comentario').value.trim();
            if (!conteudo) return alert('Digite um comentário');
            const res = await fetch('processa-comentario.php', { method: 'POST', body: new URLSearchParams({ idpostagem: postagemAtual, conteudo, acao: 'enviar' }) });
            const data = await res.json();
            if (data.sucesso) {
                const lista = document.getElementById('lista-comentarios');
                const div = document.createElement('div');
                div.innerHTML = `<strong>${data.nome_u}:</strong> ${conteudo}`;
                lista.appendChild(div);
                document.querySelector(`.post-card[data-id='${postagemAtual}'] .contador-comentario`).textContent = data.total;
                document.getElementById('novo-comentario').value = '';
            } else alert(data.error);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>