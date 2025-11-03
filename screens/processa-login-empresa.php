<?php
require_once "../assets/src/EmpresaDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = $_POST['cnpj_empresa'] ?? '';
    $senha = $_POST['senha_empresa'] ?? '';

    try {
        // Busca empresa pelo CNPJ
        $empresa = EmpresaDAO::buscarPorCNPJ($cnpj); // deve retornar array associativo ou false

        if (!$empresa) {
            throw new Exception("CNPJ não encontrado!");
        }

        // Verifica senha
        if (!password_verify($senha, $empresa['senha_empresa'])) {
            throw new Exception("Senha incorreta!");
        }

        // Login bem-sucedido: salva dados na sessão
        $_SESSION['idempresa'] = $empresa['idempresa'];
        $_SESSION['nomeempresa'] = $empresa['nome_empresa'];
        $_SESSION['fotoempresa'] = $empresa['foto'] ?? null;

        // Redireciona para feed
        header("Location: feed.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: login-empresa.php");
        exit;
    }
} else {
    header("Location: login-empresa.php");
    exit;
}
