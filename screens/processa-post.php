<?php
session_start();

require_once "../assets/src/PostagemDAO.php";
require_once "../assets/src/Util.php";

// Verifica se o usuário está logado
$idusuario = $_SESSION['idusuario'] ?? null;
if (!$idusuario) {
    $_SESSION['mensagem'] = "Erro: usuário não logado.";
    header("Location: cadastro-post.php");
    exit;
}

// Verifica se o formulário foi enviado corretamente
if (!isset($_POST['idarea'], $_POST['legenda'], $_FILES['foto'])) {
    $_SESSION['mensagem'] = "Erro: dados do formulário incompletos.";
    header("Location: cadastro-post.php");
    exit;
}

// Recebe dados do formulário
$idarea = $_POST['idarea'];
$legenda = trim($_POST['legenda']);

// Valida a área e legenda
if (empty($idarea) || empty($legenda)) {
    $_SESSION['mensagem'] = "Erro: todos os campos são obrigatórios.";
    header("Location: cadastro-post.php");
    exit;
}

// Valida se o arquivo de foto foi enviado
if (!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['mensagem'] = "Erro ao enviar a foto. Tente novamente.";
    header("Location: cadastro-post.php");
    exit;
}

// Salva a foto e pega o nome do arquivo
$nomeFoto = Util::salvarFoto($_FILES['foto']);
if (!$nomeFoto) {
    $_SESSION['mensagem'] = "Erro ao salvar a foto. Tente novamente.";
    header("Location: cadastro-post.php");
    exit;
}

// Cadastra a postagem
try {
    PostagemDAO::cadastrarPost($idusuario, $idarea, $nomeFoto, $legenda);
    $_SESSION['mensagem'] = "Post criado com sucesso!";
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Erro ao criar post: " . $e->getMessage();
}

header("Location: cadastro-post.php");
exit;
?>
