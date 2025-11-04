<?php
session_start();
require_once "../assets/src/MentorDAO.php";
require_once "../assets/src/Util.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../screens/cadastro-mentor.php");
    exit;
}

try {
    // Passa diretamente os dados do POST e o arquivo
    MentorDAO::CadastrarMentor($_POST, $_FILES['foto'] ?? null);

    $_SESSION['mensagem'] = "Cadastro realizado com sucesso! Faça login para continuar.";
    header("Location: ../screens/login-mentor.php");
    exit;

} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    header("Location: ../screens/cadastro-mentor.php");
    exit;
}
