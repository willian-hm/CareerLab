<?php
require_once "../assets/src/MentorDAO.php";
require_once "../assets/src/Util.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Salva foto
        $_POST['foto'] = Util::salvarFoto($_FILES['foto'] ?? null);

        // Cadastra usando DAO
        MentorDAO::cadastrarMentor($_POST);

        $_SESSION['mensagem'] = "Mentor cadastrado com sucesso!";
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
    }

    header("Location: cadastro-mentor.php");
    exit;
} else {
    header("Location: cadastro-mentor.php");
    exit;
}
