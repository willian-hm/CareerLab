<?php
// Inicia a sessão (caso ainda não esteja iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Limpa todas as variáveis de sessão
$_SESSION = [];

// Destroi a sessão
session_destroy();

// Redireciona para login de usuário (padrão)
header("Location: ../../screens/index.php");
exit;
