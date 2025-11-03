<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/SeguidoDAO.php";

$idUsuario = $_SESSION['idusuario'];
$idSeguido = $_POST['idSeguido'] ?? null;

if ($idSeguido) {
    $pdo = ConexaoBD::conectar();
    $stmt = $pdo->prepare("DELETE FROM seguido WHERE idusuario = :idUsuario AND idseguido = :idSeguido");
    $stmt->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindValue(':idSeguido', $idSeguido, PDO::PARAM_INT);
    $stmt->execute();
}

header("Location: seguindo.php");
?>
