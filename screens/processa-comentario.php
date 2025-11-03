<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['error' => 'Faça login para comentar']);
    exit;
}

require_once "../assets/src/ComentarioDAO.php";

$idusuario = $_SESSION['idusuario'];
$idpostagem = $_POST['idpostagem'] ?? null;
$acao = $_POST['acao'] ?? null;

if (!$idpostagem) {
    echo json_encode(['error' => 'Postagem inválida']);
    exit;
}

switch ($acao) {
    case 'listar':
        $comentarios = ComentarioDAO::listarComentarios($idpostagem);
        echo json_encode($comentarios);
        break;
    case 'enviar':
        $conteudo = trim($_POST['conteudo'] ?? '');
        if (!$conteudo) {
            echo json_encode(['error' => 'Comentário vazio']);
            exit;
        }
        ComentarioDAO::adicionarComentario($idusuario, $idpostagem, $conteudo);
        $total = ComentarioDAO::contarComentarios($idpostagem);
        // Para retornar o nome do usuário logado
        echo json_encode(['sucesso' => true, 'total' => $total, 'nome_u' => $_SESSION['nomeusuario']]);
        break;
    default:
        echo json_encode(['error' => 'Ação inválida']);
        break;
}
?>
