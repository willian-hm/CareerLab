<?php
session_start();
require_once "../assets/src/ConexaoBD.php";

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Requisição inválida.");
    }

    if (!isset($_SESSION['idusuario'])) {
        throw new Exception("Você precisa estar logado para cancelar a inscrição.");
    }

    $idusuario = $_SESSION['idusuario'];
    $idmentoria = $_POST['idmentoria'] ?? '';

    if (empty($idmentoria)) {
        throw new Exception("Mentoria não especificada.");
    }

    $conexao = ConexaoBD::conectar();

    // Verifica se está inscrito
    $sql = "SELECT * FROM inscrevermentoria WHERE idusuario = ? AND idmentoria = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idusuario, $idmentoria]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("Você não está inscrito nessa mentoria.");
    }

    // Remove inscrição
    $sqlDel = "DELETE FROM inscrevermentoria WHERE idusuario = ? AND idmentoria = ?";
    $stmtDel = $conexao->prepare($sqlDel);
    $stmtDel->execute([$idusuario, $idmentoria]);

    $_SESSION['mensagem'] = "Inscrição cancelada com sucesso.";
    header("Location: mentorias.php");
    exit;
} catch (Exception $e) {
    $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
    header("Location: mentorias.php");
    exit;
}
