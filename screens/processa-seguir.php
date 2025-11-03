<?php
session_start();

if (!isset($_SESSION['idusuario'])) {
    header("Location: login.php");
    exit;
}

require_once "../assets/src/SeguidoDAO.php";

$idUsuario = $_SESSION['idusuario'];
$idSeguido = $_POST['idSeguido'] ?? null;

if ($idSeguido) {
    SeguidoDAO::seguirUsuario($idUsuario, $idSeguido);
}

header("Location: pesquisar.php");
exit;
?>
