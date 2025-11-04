<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/ConexaoBD.php";

// Verifica se o usuário é mentor
if ($_SESSION['tipo'] != 'mentor') {
    $_SESSION['mensagem'] = "Acesso restrito a mentores.";
    header("Location: ../screens/feed.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $area = trim($_POST['area']);
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $vaga_limite = $_POST['vaga_limite'];
    $local = trim($_POST['local']);
    $mentor_id = $_SESSION['idusuario'];

    try {
        $pdo = ConexaoBD::conectar();
        $stmt = $pdo->prepare("
            INSERT INTO mentoria (titulo, descricao, area, data, horario, mentor_id, vaga_limite, local, status)
            VALUES (:titulo, :descricao, :area, :data, :horario, :mentor_id, :vaga_limite, :local, 'ativa')
        ");
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':area' => $area,
            ':data' => $data,
            ':horario' => $horario,
            ':mentor_id' => $mentor_id,
            ':vaga_limite' => $vaga_limite,
            ':local' => $local
        ]);

        $_SESSION['mensagem'] = "Mentoria cadastrada com sucesso!";
        header("Location: listar-mentorias.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar mentoria: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Mentoria</title>
    <link rel="stylesheet" href="../assets/css/estilo.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Mentoria</h1>

        <?php if (isset($erro)): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post" class="form-cadastro">
            <label>Título:</label>
            <input type="text" name="titulo" required>

            <label>Descrição:</label>
            <textarea name="descricao" required></textarea>

            <label>Área:</label>
            <input type="text" name="area" required>

            <label>Data:</label>
            <input type="date" name="data" required>

            <label>Horário:</label>
            <input type="time" name="horario" required>

            <label>Limite de Vagas:</label>
            <input type="number" name="vaga_limite" min="1" required>

            <label>Local / Link:</label>
            <input type="text" name="local" placeholder="Ex: Sala 101 ou link Meet">

            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </div>
</body>
</html>
