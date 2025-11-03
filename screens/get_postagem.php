<?php
require_once "../assets/src/PostagemDAO.php";

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['erro' => 'ID da postagem não informado']);
    exit;
}

$idpostagem = intval($_GET['id']);
$post = PostagemDAO::buscarPostPorId($idpostagem);

if (!$post) {
    echo json_encode(['erro' => 'Postagem não encontrada']);
    exit;
}

// Define foto padrão se não existir
if (empty($post['foto']) || !file_exists("../uploads/" . $post['foto'])) {
    $post['foto'] = 'padrao-post.png';
}

// Garante que curtidas e comentários existam
$post['curtidas'] = $post['curtidas'] ?? 0;
$post['comentarios'] = $post['comentarios'] ?? [];

echo json_encode($post);
