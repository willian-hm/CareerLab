<?php
header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . "/../assets/src/ConexaoBD.php";
    require_once __DIR__ . "/../assets/src/MentoriaDAO.php";

    $idmentoria = $_GET['id'] ?? null;

    if (!$idmentoria) {
        http_response_code(400);
        echo json_encode(['erro' => 'ID da mentoria não informado.']);
        exit;
    }

    $alunos = MentoriaDAO::listarInscritos($idmentoria);

    // normaliza para array vazia caso não haja inscritos
    if (!$alunos) {
        $alunos = [];
    }

    // retorna array (mesmo que vazio)
    echo json_encode($alunos);
} catch (Throwable $e) {
    http_response_code(500);
    // não vaze detalhes sensíveis em produção; aqui é útil para debug
    echo json_encode(['erro' => 'Erro ao buscar inscritos: ' . $e->getMessage()]);
}
