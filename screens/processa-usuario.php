<?php
require_once "../assets/src/UsuarioDAO.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Passa $_POST e $_FILES['foto'] para o DAO
        UsuarioDAO::cadastrarUsuario($_POST, $_FILES['foto'] ?? null);
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
    }

    header("Location: cadastro-usuario.php");
    exit;
} else {
    header("Location: cadastro-usuario.php");
    exit;
}
