<?php
require_once "../assets/src/EmpresaDAO.php";
require_once "../assets/src/Util.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Salva foto
        $_POST['foto'] = Util::salvarFoto($_FILES['foto'] ?? null);

        // Cadastra usando DAO
        EmpresaDAO::cadastrarEmpresa($_POST);

        $_SESSION['mensagem'] = "Empresa cadastrada com sucesso!";
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage();
    }

    header("Location: cadastro-empresa.php");
    exit;
} else {
    header("Location: cadastro-empresa.php");
    exit;
}
