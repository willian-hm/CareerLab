<?php
require_once "../assets/src/EmpresaDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = $_POST['cnpj'] ?? ''; // corrigido aqui
    $senha = $_POST['senha_empresa'] ?? '';

    try {
        $empresa = EmpresaDAO::buscarPorCNPJ($cnpj);

        if (!$empresa) {
            throw new Exception("CNPJ não encontrado!");
        }

        if (!password_verify($senha, $empresa['senha_empresa'])) {
            throw new Exception("Senha incorreta!");
        }

        $_SESSION['idempresa'] = $empresa['idempresa'];
        $_SESSION['nomeempresa'] = $empresa['nome_empresa'];
        $_SESSION['fotoempresa'] = $empresa['foto'] ?? null;

        header("Location: area-empresa.php");
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
