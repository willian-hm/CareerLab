<?php
require_once "../assets/src/UsuarioDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_u'] ?? '';
    $senha = $_POST['senha_u'] ?? '';

    try {
        // Busca usuário pelo nome
        $usuario = UsuarioDAO::buscarPorNome($nome);

        if(!$usuario) {
            throw new Exception("Nome de usuário não encontrado!");
        }

        if(!password_verify($senha, $usuario['senha_u'])) {
            throw new Exception("Senha incorreta!");
        }

        // Login bem-sucedido: cria cookies
        setcookie("idusuario", $usuario['idusuario'], time()+3600, "/");
        setcookie("nomeusuario", $usuario['nome_u'], time()+3600, "/");
        setcookie("fotousuario", $usuario['foto'], time()+3600, "/");

        header("Location: feed.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: login-usuario.php");
        exit;
    }
} else {
    header("Location: login-usuario.php");
    exit;
}
