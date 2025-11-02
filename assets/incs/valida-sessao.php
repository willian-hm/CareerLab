<?php
// Inicia a sessão
session_start();

// Verifica se algum cookie de login existe
if (!isset($_COOKIE['idusuario']) && !isset($_COOKIE['idmentor']) && !isset($_COOKIE['idempresa'])) {
    $_SESSION['msg'] = "Para acessar essa página, é necessário fazer login.";
    header("Location: quem-e-voce.php");
    exit;
}

// Inicializa variáveis com isset para evitar warnings
$id = $nome = $foto = $tipo = null;

if (isset($_COOKIE['idusuario'])) {
    $id = $_COOKIE['idusuario'];
    $nome = $_COOKIE['nomeusuario'] ?? null;
    $foto = $_COOKIE['fotousuario'] ?? null;
    $tipo = "usuario";
} elseif (isset($_COOKIE['idmentor'])) {
    $id = $_COOKIE['idmentor'];
    $nome = $_COOKIE['nomementor'] ?? null;
    $foto = $_COOKIE['fotomentor'] ?? null;
    $tipo = "mentor";
} elseif (isset($_COOKIE['idempresa'])) {
    $id = $_COOKIE['idempresa'];
    $nome = $_COOKIE['nomeempresa'] ?? null;
    $foto = $_COOKIE['fotoempresa'] ?? null;
    $tipo = "empresa";
}
