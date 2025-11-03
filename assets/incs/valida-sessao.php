<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica login
if (!isset($_SESSION['idusuario']) && !isset($_SESSION['idmentor']) && !isset($_SESSION['idempresa'])) {
    $_SESSION['mensagem'] = "Para acessar essa página, é necessário fazer login.";
    header("Location: login-usuario.php");
    exit;
}

// Inicializa variáveis do usuário logado
$id = $nome = $foto = $tipo = null;

if (isset($_SESSION['idusuario'])) {
    $id = $_SESSION['idusuario'];
    $nome = $_SESSION['nomeusuario'] ?? "Usuário";
    $foto = $_SESSION['fotousuario'] ?? "default.png";
    $tipo = "usuario";
} elseif (isset($_SESSION['idmentor'])) {
    $id = $_SESSION['idmentor'];
    $nome = $_SESSION['nomementor'] ?? "Mentor";
    $foto = $_SESSION['fotomentor'] ?? "default.png";
    $tipo = "mentor";
} elseif (isset($_SESSION['idempresa'])) {
    $id = $_SESSION['idempresa'];
    $nome = $_SESSION['nomeempresa'] ?? "Empresa";
    $foto = $_SESSION['fotoempresa'] ?? "default.png";
    $tipo = "empresa";
}
