<?php
session_start();
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";

$idUsuario = $_SESSION['idusuario'] ?? null;
if (!$idUsuario) {
    header("Location: login-usuario.php");
    exit;
}

// Exclui o usuário do banco
UsuarioDAO::excluir($idUsuario);

// Destrói sessão
session_destroy();

// Redireciona para página inicial
header("Location: index.php");
exit;
