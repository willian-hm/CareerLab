<?php
// assets/incs/valida-sessao-empresa.php

session_start();

// Verifica se a empresa está logada
if (!isset($_SESSION['idempresa'])) {
    $_SESSION['mensagem'] = "Faça login para acessar a área da empresa.";
    header("Location: ../screens/login-empresa.php");
    exit;
}

// Variáveis rápidas para uso em páginas e componentes
$idempresa = $_SESSION['idempresa'];
$nomeempresa = $_SESSION['nomeempresa'] ?? "Empresa";
$fotoempresa = $_SESSION['fotoempresa'] ?? null;
?>
