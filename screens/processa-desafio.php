<?php
session_start();
require_once "../assets/src/DesafioDAO.php";
require_once "../assets/incs/valida-sessao-empresa.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dados = [
            'nomedesafio' => trim($_POST['nomedesafio']),
            'orientacaodesafio' => trim($_POST['orientacaodesafio']),
            'vagaslimite' => (int)$_POST['vagaslimite']
        ];

        DesafioDAO::cadastrar($dados, $idempresa);
        $_SESSION['mensagem'] = "Desafio cadastrado com sucesso!";
    }
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Erro ao cadastrar desafio: " . $e->getMessage();
}

header("Location: area-empresa.php");
exit;
