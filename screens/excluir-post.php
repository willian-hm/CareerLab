<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['error' => 'Usuário não logado']);
    exit;
}

require_once "../assets/src/PostagemDAO.php";

$idUsuario = $_SESSION['idusuario'];
$idPostagem = $_POST['idpostagem'] ?? null;

if (!$idPostagem) {
    echo json_encode(['error' => 'ID da postagem não informado']);
    exit;
}

try {
    $sucesso = PostagemDAO::excluirPorUsuario($idUsuario, $idPostagem);

    if ($sucesso) {
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['error' => 'Não foi possível excluir a postagem. Talvez ela não exista ou não pertença a você.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro ao excluir postagem: ' . $e->getMessage()]);
}
