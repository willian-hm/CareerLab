<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../assets/src/ConexaoBD.php';

$iddesafio = $_POST['iddesafio'] ?? null;
$idusuario  = $_POST['idusuario'] ?? null;
$acao       = $_POST['acao'] ?? null;

if (!$iddesafio || !$idusuario || !$acao) {
    http_response_code(400);
    echo json_encode(["status"=>"erro","mensagem"=>"Parâmetros inválidos"]);
    exit;
}

try {
    $con = ConexaoBD::conectar();

    if ($acao === 'selecionar') {
        // verifica duplicata
        $check = $con->prepare("SELECT 1 FROM projetoselecionado WHERE idusuario = ? AND iddesafio = ?");
        $check->execute([$idusuario, $iddesafio]);
        if ($check->fetch()) {
            echo json_encode(["status"=>"ok","mensagem"=>"Já selecionado"]);
            exit;
        }

        $ins = $con->prepare("INSERT INTO projetoselecionado (idusuario, iddesafio) VALUES (?, ?)");
        $ins->execute([$idusuario, $iddesafio]);

        // soma XP
        $up = $con->prepare("UPDATE usuario SET exp = COALESCE(exp,0) + 100 WHERE idusuario = ?");
        $up->execute([$idusuario]);

        echo json_encode(["status"=>"ok"]);
        exit;

    } elseif ($acao === 'desmarcar') {
        $del = $con->prepare("DELETE FROM projetoselecionado WHERE idusuario = ? AND iddesafio = ?");
        $del->execute([$idusuario, $iddesafio]);

        // remove XP (não deixa negativo)
        // Postgres: GREATEST(COALESCE(exp,0) - 100, 0)
        $up = $con->prepare("UPDATE usuario SET exp = GREATEST(COALESCE(exp,0) - 100, 0) WHERE idusuario = ?");
        $up->execute([$idusuario]);

        echo json_encode(["status"=>"ok"]);
        exit;
    } else {
        http_response_code(400);
        echo json_encode(["status"=>"erro","mensagem"=>"Ação inválida"]);
        exit;
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(["status"=>"erro","mensagem"=>"Erro servidor: " . $e->getMessage()]);
}
