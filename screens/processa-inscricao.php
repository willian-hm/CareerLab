<?php
session_start();
require_once "../assets/src/ConexaoBD.php";

$idmentoria = $_POST['idmentoria'];
$idusuario = $_SESSION['idusuario']; // precisa já estar na sessão

$conexao = ConexaoBD::conectar();

// Verifica se já está inscrito
$check = $conexao->prepare("SELECT * FROM inscrevermentoria WHERE idmentoria = ? AND idusuario = ?");
$check->execute([$idmentoria, $idusuario]);

if ($check->rowCount() > 0) {
    $_SESSION['mensagem'] = "Você já está inscrito nessa mentoria.";
    header("Location: mentorias.php");
    exit;
}

// Verifica vagas
$sql = "SELECT vaga_limite, (SELECT COUNT(*) FROM inscrevermentoria WHERE idmentoria = ?) AS inscritos
        FROM mentoria WHERE idmentoria = ?";
$stmt = $conexao->prepare($sql);
$stmt->execute([$idmentoria, $idmentoria]);
$m = $stmt->fetch(PDO::FETCH_ASSOC);

if ($m['inscritos'] >= $m['vaga_limite']) {
    $_SESSION['mensagem'] = "Mentoria cheia!";
    header("Location: mentorias.php");
    exit;
}

// Insere inscrição
$insert = $conexao->prepare("INSERT INTO inscrevermentoria (idmentoria, idusuario) VALUES (?, ?)");
$insert->execute([$idmentoria, $idusuario]);

$_SESSION['mensagem'] = "Inscrição realizada com sucesso!";
header("Location: mentorias.php");
exit;
?>
