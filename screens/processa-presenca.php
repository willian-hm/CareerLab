<?php
header('Content-Type: application/json; charset=utf-8');
require_once "../assets/src/PresencaMentoriaDAO.php";

try {
    $idmentoria = $_POST['idmentoria'] ?? null;
    $idusuario = $_POST['idusuario'] ?? null;
    $acao = $_POST['acao'] ?? 'confirmar';

    if (!$idmentoria || !$idusuario) {
        throw new Exception("Dados insuficientes.");
    }

    if ($acao === 'desconfirmar') {
        PresencaMentoriaDAO::desconfirmarPresenca($idmentoria, $idusuario);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Presença removida. XP ajustado.', 'acao' => 'confirmar']);
    } else {
        PresencaMentoriaDAO::confirmarPresenca($idmentoria, $idusuario);
        echo json_encode(['sucesso' => true, 'mensagem' => 'Presença confirmada. +5 XP!', 'acao' => 'desconfirmar']);
    }
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['erro' => $e->getMessage()]);
}
