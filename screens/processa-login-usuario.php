<?php
session_start();
require_once "../assets/src/UsuarioDAO.php"; // DAO que consulta usuários

$nome_u = $_POST['nome_u'] ?? null;
$senha_u = $_POST['senha_u'] ?? null;

// Verifica campos
if (!$nome_u || !$senha_u) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header("Location: login-usuario.php");
    exit;
}

// Busca usuário no banco
$usuario = UsuarioDAO::buscarPorNome($nome_u); // método que retorna usuário pelo nome

if (!$usuario || !password_verify($senha_u, $usuario['senha_u'])) {
    $_SESSION['mensagem'] = "Usuário ou senha incorretos!";
    header("Location: login-usuario.php");
    exit;
}

// Login bem-sucedido: salva dados na sessão
$_SESSION['idusuario'] = $usuario['idusuario'];
$_SESSION['nomeusuario'] = $usuario['nome_u'];

// Se existir foto, salva o nome do arquivo; senão null
$_SESSION['fotousuario'] = $usuario['foto'];

// Redireciona para feed
header("Location: feed.php");
exit;
