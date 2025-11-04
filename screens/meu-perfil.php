<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";
require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/CurtidaDAO.php";
require_once "../assets/src/ComentarioDAO.php";

$idUsuario = $_SESSION['idusuario'];
$usuario = UsuarioDAO::buscarPorId($idUsuario);
$postagens = PostagemDAO::listarPorUsuario($idUsuario);

// Valores padrão para exibição
$usuario['foto'] = $usuario['foto'] ?? 'padrao.png';
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
    <title>Meu Perfil | CareerLab</title>
    <link rel="stylesheet" href="meu-perfil.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <div class="seguidores">
               
                <a href="seguidores.php"><span><strong><?= $usuario['seguidores'] ?></strong> Seguidores</span></a>
                
                <a href="seguindo.php"><span><strong><?= $usuario['seguindo'] ?></strong> Seguindo</span></a>
            </div>
            <div class="botoes">
                <a href="editar-perfil.php" class="btn editar">Editar informações</a>
                <a href="cadastro-post.php" class="btn novo-post">Nova Publicação</a>
                <button class="btn excluir" data-bs-toggle="modal" data-bs-target="#excluirPerfilModal">
                    Excluir perfil
                </button>
            </div>
        </div>
    </div>

<hr>

<h3>Suas publicações</h3>
<div class="postagens-grid">
    <?php if ($postagens): ?>
        <?php foreach ($postagens as $post): 
            $curtiu = CurtidaDAO::usuarioCurtiu($idUsuario, $post['idpostagem']);
            $totalCurtidas = CurtidaDAO::contarCurtidas($post['idpostagem']);
            $totalComentarios = ComentarioDAO::contarComentarios($post['idpostagem']);


        // Valores padrão para post
        $post['foto_usuario'] = $post['foto_usuario'] ?? 'padrao.png';
        $post['nome_usuario'] = $post['nome_usuario'] ?? 'Usuário';
        $post['area'] = $post['area'] ?? 'Sem área';
        $post['foto'] = $post['foto'] ?? 'padrao-post.png';
        $post['legenda'] = $post['legenda'] ?? '';
    ?>
    <div class="post-card card mb-3" data-id="<?= $post['idpostagem'] ?>">
        <img src="../uploads/<?= htmlspecialchars($post['foto']) ?>" class="card-img-top" alt="Postagem">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <strong><?= htmlspecialchars($post['nome_usuario']) ?></strong>
                <button class="btn btn-sm btn-danger btn-excluir">Excluir</button>
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
        <textarea id="novo-comentario" class="form-control mt-2" placeholder="Escreva um comentário..."></textarea>
        <button id="enviar-comentario" class="btn btn-primary mt-2">Comentar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Excluir Perfil -->

<div class="modal fade" id="excluirPerfilModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmação</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja excluir seu perfil? Esta ação não pode ser desfeita.</p>
        <div id="feedback-excluir" class="text-danger"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="confirmar-exclusao" class="btn btn-danger">Excluir</button>
      </div>
    </div>
  </div>
</div>

</main>

<?php include "../assets/Components/Footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
// Exclusão do perfil via AJAX
$('#confirmar-exclusao').click(function() {
    $.ajax({
        url: 'excluir-perfil.php',
        type: 'POST',
        data: {idusuario: <?= $idUsuario ?>},
        success: function(response) {
            // Redireciona após exclusão
            window.location.href = 'index.php';
        },
        error: function() {
            $('#feedback-excluir').text('Ocorreu um erro ao excluir o perfil.');
        }
    });
});
</script>

<script>
// Curtir
document.querySelectorAll('.btn-curtir').forEach(btn => {
    btn.addEventListener('click', async () => {
        const card = btn.closest('.post-card');
        const idpostagem = card.dataset.id;
        const res = await fetch('curtir.php', { method:'POST', body: new URLSearchParams({idpostagem}) });
        const data = await res.json();
        if (data.error) return alert(data.error);

        card.querySelector('.contador').textContent = data.total;
        const icon = btn.querySelector('i');
        icon.className = 'bi ' + (data.curtiu ? 'bi-heart-fill text-danger' : 'bi-heart');
    });
});

// Excluir
document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', async () => {
        if (!confirm('Deseja realmente excluir esta postagem?')) return;
        const card = btn.closest('.post-card');
        const idpostagem = card.dataset.id;
        const res = await fetch('excluir-post.php', { method:'POST', body: new URLSearchParams({idpostagem}) });
        const data = await res.json();
        if (data.sucesso) card.remove();
        else alert(data.error);
    });
});

// Comentários
let postagemAtual = null;
document.querySelectorAll('.btn-comentar').forEach(btn => {
    btn.addEventListener('click', async () => {
        postagemAtual = btn.dataset.id;
        const modal = new bootstrap.Modal(document.getElementById('comentarioModal'));
        modal.show();

        const res = await fetch('processa-comentario.php', { method:'POST', body: new URLSearchParams({ idpostagem: postagemAtual, acao:'listar' }) });
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
    const res = await fetch('processa-comentario.php', { method:'POST', body: new URLSearchParams({ idpostagem: postagemAtual, conteudo, acao:'enviar' }) });
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

</body>
</html>
