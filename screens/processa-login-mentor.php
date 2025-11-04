<?php
session_start();
require_once "../assets/src/ConexaoBD.php";
require_once "../assets/src/MentorDAO.php";
require_once "../assets/src/UsuarioDAO.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login-mentor.php");
    exit;
}

$email = $_POST['email_mentor'] ?? null;
$senha = $_POST['senha_mentor'] ?? null;

if (!$email || !$senha) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header("Location: login-mentor.php");
    exit;
}

$mentor = MentorDAO::buscarPorEmail($email);

if ($mentor && password_verify($senha, $mentor['senha_mentor'])) {
    // Cria sessão do mentor
    $_SESSION['idmentor'] = $mentor['idmentor'];
    $_SESSION['nome_mentor'] = $mentor['nome_mentor'];
    $_SESSION['foto_mentor'] = $mentor['foto'] ?? 'default.png';

    // 1️⃣ Busca o usuário equivalente pelo nome do mentor
    $usuario = UsuarioDAO::buscarPorNome($mentor['nome_mentor']);
    if ($usuario) {
        $_SESSION['idusuario'] = $usuario['idusuario'];
        $_SESSION['nome_u'] = $usuario['nome_u'];
        $_SESSION['foto'] = $usuario['foto'];
    }

    header("Location: painel-mentor.php");
    exit;
} else {
    $_SESSION['mensagem'] = "Email ou senha incorretos!";
    header("Location: login-mentor.php");
    exit;
}
?>
