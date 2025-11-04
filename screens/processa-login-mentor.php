<?php
session_start();
require_once "../assets/src/MentorDAO.php";

$email = $_POST['email_mentor'] ?? null;
$senha = $_POST['senha_mentor'] ?? null;

if (!$email || !$senha) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header("Location: login-mentor.php");
    exit;
}

$mentor = MentorDAO::buscarPorEmail($email);

if (!$mentor || !password_verify($senha, $mentor['senha_mentor'])) {
    $_SESSION['mensagem'] = "E-mail ou senha incorretos!";
    header("Location: login-mentor.php");
    exit;
}

$_SESSION['idmentor'] = $mentor['idmentor'];
$_SESSION['nomementor'] = $mentor['nome_mentor'];
$_SESSION['fotomentor'] = $mentor['foto'];

header("Location: painel-mentor.php");
exit;
