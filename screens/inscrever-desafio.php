<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/DesafioDAO.php";

$iddesafio = $_GET['id'] ?? null;
if (!$iddesafio) {
    header("Location: desafios.php");
    exit;
}

$conexao = ConexaoBD::conectar();
$stmt = $conexao->prepare("SELECT * FROM desafio WHERE iddesafio = ?");
$stmt->execute([$iddesafio]);
$desafio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$desafio) {
    header("Location: desafios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inscrição no Desafio</title>
    <link rel="stylesheet" href="area-empresa.css">
</head>
<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <h1>Inscrição no Desafio</h1>

        <div class="card-info" style="margin: 0 auto; max-width: 700px;">
            <h2><?= htmlspecialchars($desafio['nomedesafio']) ?></h2>
            <p><?= nl2br(htmlspecialchars($desafio['orientacaodesafio'])) ?></p>
        </div>

        <form action="processa-inscricao-desafio.php" method="POST" class="form-desafio" style="margin-top:30px;">
            <input type="hidden" name="iddesafio" value="<?= $iddesafio ?>">
            
            <label>Link do Repositório no GitHub:</label>
            <input type="url" name="linkgit" placeholder="https://github.com/seuusuario/seuprojeto" required>

            <button type="submit" class="botao-area">Enviar Inscrição</button>
        </form>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
