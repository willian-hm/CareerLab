<?php
session_start();
require_once "../assets/src/CurtidaDAO.php";

header('Content-Type: application/json');

$idusuario = $_SESSION['idusuario'] ?? null;
$idpostagem = $_POST['idpostagem'] ?? null;

if (!$idusuario) {
    echo json_encode(['error' => 'Usuário não logado']);
    exit;
}

if (!$idpostagem || !is_numeric($idpostagem)) {
    echo json_encode(['error' => 'ID da postagem inválido']);
    exit;
}

$idpostagem = (int)$idpostagem;

try {
    if (CurtidaDAO::usuarioCurtiu($idusuario, $idpostagem)) {
        $success = CurtidaDAO::descurtir($idusuario, $idpostagem);
        $curtiu = false;
    } else {
        $success = CurtidaDAO::curtir($idusuario, $idpostagem);
        $curtiu = true;
    }

    if (!$success) {
        echo json_encode(['error' => 'Erro ao atualizar curtida no banco']);
        exit;
    }

    $totalCurtidas = CurtidaDAO::contarCurtidas($idpostagem);

    echo json_encode([
        'curtiu' => $curtiu,
        'total' => $totalCurtidas
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro de banco: ' . $e->getMessage()]);
}
