<?php
session_start();
require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/Util.php";

$idusuario = $_COOKIE['idusuario'] ?? null;

if (!$idusuario) {
    $_SESSION['mensagem'] = "Erro: usuário não logado.";
    header("Location: cadastro-post.php");
    exit;
}

// Salva a foto e pega o nome do arquivo
$nomeFoto = Util::salvarFoto($_FILES['foto']);

// Recebe dados do formulário
$idarea = $_POST['idarea']; // vem do select
$legenda = $_POST['legenda'] ?? "";

// Valida se a foto foi salva
if ($nomeFoto) {
    PostagemDAO::cadastrarPost($idusuario, $idarea, $nomeFoto, $legenda);
    $_SESSION['mensagem'] = "Post criado com sucesso!";
} else {
    $_SESSION['mensagem'] = "Erro ao criar post. Tente novamente.";
}

header("Location: cadastro-post.php");
exit;
