<?php
session_start();
require_once "../assets/src/MentorDAO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        MentorDAO::cadastrarMentor($_POST, $_FILES['foto'] ?? null);
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        header("Location: login-mentor.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
        header("Location: cadastro-mentor.php");
        exit;
    }
} else {
    header("Location: cadastro-mentor.php");
    exit;
}
