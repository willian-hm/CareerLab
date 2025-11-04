<?php
session_start();

if (!isset($_SESSION['idmentor'])) {
    $_SESSION['mensagem'] = "Faça login para acessar o painel do mentor.";
    header("Location: ../screens/login-mentor.php");
    exit;
}

$idmentor = $_SESSION['idmentor'];
$nomementor = $_SESSION['nomementor'];
