<?php
// Ajuste o caminho conforme sua estrutura
include_once "../assets/incs/valida-sessao-mentor.php"; // garante $idmentor da sessão
require_once "../assets/src/MentoriaDAO.php";

if (!isset($_GET['id'])) {
    header("Location: painel-mentor.php");
    exit;
}

$idmentoria = (int) $_GET['id'];

try {
    // busca a mentoria para checar dono
    $mentoria = MentoriaDAO::buscarPorId($idmentoria);
    if (!$mentoria) {
        // não encontrada
        $_SESSION['mensagem'] = "Mentoria não encontrada.";
        header("Location: painel-mentor.php");
        exit;
    }

    // Verifica se a mentoria pertence ao mentor logado
    if ($mentoria['mentor_id'] != $idmentor) {
        $_SESSION['mensagem'] = "Você não tem permissão para excluir esta mentoria.";
        header("Location: painel-mentor.php");
        exit;
    }

    // Tenta excluir
    MentoriaDAO::excluir($idmentoria);

    $_SESSION['mensagem'] = "Mentoria excluída com sucesso.";
    header("Location: painel-mentor.php");
    exit;

} catch (PDOException $e) {
    // Se falhar por causa de FK, mostre mensagem clara
    $msg = $e->getMessage();
    // opcional: logar $msg em arquivo de logs
    $_SESSION['mensagem'] = "Erro ao excluir mentoria. Possíveis restrições no banco: " . htmlspecialchars($msg);
    header("Location: painel-mentor.php");
    exit;
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Erro: " . htmlspecialchars($e->getMessage());
    header("Location: painel-mentor.php");
    exit;
}
