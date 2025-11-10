<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../assets/src/ConexaoBD.php';

$iddesafio = $_GET['iddesafio'] ?? null;
if (!$iddesafio) {
    http_response_code(400);
    echo json_encode(["erro" => "iddesafio não informado"]);
    exit;
}

try {
    $con = ConexaoBD::conectar();
    $sql = "
      SELECT u.idusuario, u.nome_u, u.email_u, u.foto, COALESCE(u.exp,0) as exp,
             CASE WHEN ps.idusuario IS NOT NULL THEN 1 ELSE 0 END AS selecionado
      FROM inscricaodesafio i
      JOIN usuario u ON i.idusuario = u.idusuario
      LEFT JOIN projetoselecionado ps ON ps.idusuario = u.idusuario AND ps.iddesafio = i.iddesafio
      WHERE i.iddesafio = ?
      ORDER BY u.nome_u
    ";
    $stmt = $con->prepare($sql);
    $stmt->execute([$iddesafio]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$rows) $rows = [];
    echo json_encode($rows, JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["erro" => "Erro interno: " . $e->getMessage()]);
}
