<?php
require_once "../assets/src/EmpresaDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_empresa'] ?? '';
    $senha = $_POST['senha_empresa'] ?? '';

    try {
        $empresa = EmpresaDAO::buscarPorCNPJ($cnpj);

        if(!$empresa) {
            throw new Exception("Email não encontrado!");
        }

        if(!password_verify($senha, $empresa['senha_empresa'])) {
            throw new Exception("Senha incorreta!");
        }

        // Cria cookies
        setcookie("idempresa", $empresa['idempresa'], time()+3600, "/");
        setcookie("nomeempresa", $empresa['nome_empresa'], time()+3600, "/");
        setcookie("fotoempresa", $empresa['foto'] ?? "", time()+3600, "/");

        header("Location: feed.php");
        exit;
    } catch(Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: login-empresa.php");
        exit;
    }
} else {
    header("Location: login-empresa.php");
    exit;
}
