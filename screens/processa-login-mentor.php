<?php
require_once "../assets/src/MentorDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_mentor'] ?? '';
    $senha = $_POST['senha_mentor'] ?? '';

    try {
        $mentor = MentorDAO::buscarPorEmail($email);

        if(!$mentor) {
            throw new Exception("Email não encontrado!");
        }

        if(!password_verify($senha, $mentor['senha_mentor'])) {
            throw new Exception("Senha incorreta!");
        }

        // Cria cookies
        setcookie("idmentor", $mentor['idmentor'], time()+3600, "/");
        setcookie("nomementor", $mentor['nome'], time()+3600, "/");
        setcookie("fotomentor", $mentor['foto'] ?? "", time()+3600, "/");

        header("Location: feed.php");
        exit;
    } catch(Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: login-mentor.php");
        exit;
    }
} else {
    header("Location: login-mentor.php");
    exit;
}
