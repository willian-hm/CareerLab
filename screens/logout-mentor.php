<?php
session_start();

// Encerra apenas a sessão do mentor
if (isset($_SESSION['idmentor'])) {
    session_unset(); // Remove variáveis da sessão
    session_destroy(); // Encerra a sessão
}

// Mensagem de saída opcional
session_start();
$_SESSION['mensagem'] = "Logout realizado com sucesso.";

// Redireciona para a tela de login de mentor
header("Location: ../screens/login-mentor.php");
exit;
?>
