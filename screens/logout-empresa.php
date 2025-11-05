<?php

session_start();

// Remove todas as variáveis de sessão da empresa
unset($_SESSION['idempresa']);
unset($_SESSION['nomeempresa']);
unset($_SESSION['fotoempresa']);

// Destroi a sessão completamente
session_destroy();

// Mensagem opcional
session_start();
$_SESSION['mensagem'] = "Você saiu da conta da empresa com sucesso.";

// Redireciona para a tela de login
header("Location: login-empresa.php");
exit;
?>
