<?php
include_once "../assets/incs/valida-sessao-mentor.php";
require_once "../assets/src/MentoriaDAO.php";
require_once "../assets/src/AreaDAO.php";

$idmentoria = $_GET['id'] ?? null;
if (!$idmentoria) {
    header("Location: painel-mentor.php");
    exit;
}

$mentoria = MentoriaDAO::buscarPorId($idmentoria);
$areas = AreaDAO::listarAreas();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Mentoria</title>
    <link rel="stylesheet" href="editar-mentoria.css">
</head>
<?php include "../assets/Components/NavBarLogadaMentor.php"; ?>
<body>
    <main>
        <div class="container">
            <h1>Editar Mentoria</h1>

            <form action="processa-edicao-mentoria.php" method="POST">
                <input type="hidden" name="idmentoria" value="<?= htmlspecialchars($mentoria['idmentoria']) ?>">

                <label>Título:</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($mentoria['titulo']) ?>" required>

                <label>Descrição:</label>
                <textarea name="descricao" rows="5" required><?= htmlspecialchars($mentoria['descricao']) ?></textarea>

                <label>Área:</label>
                <select name="idarea" required>
                    <?php foreach ($areas as $a): ?>
                        <option value="<?= $a['idarea'] ?>" <?= $a['idarea'] == $mentoria['idarea'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['nome_a']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Data:</label>
                <input type="date" name="data" value="<?= htmlspecialchars($mentoria['data']) ?>" required>

                <label>Horário:</label>
                <input type="time" name="horario" value="<?= htmlspecialchars($mentoria['horario']) ?>" required>

                <label>Vagas:</label>
                <input type="number" name="vaga_limite" value="<?= htmlspecialchars($mentoria['vaga_limite']) ?>" required>

                <label>Local/Link:</label>
                <input type="text" name="local" value="<?= htmlspecialchars($mentoria['local']) ?>" required>

                <label>Status:</label>
                <select name="status" required>
                    <option value="ativa" <?= $mentoria['status'] === 'ativa' ? 'selected' : '' ?>>Ativa</option>
                    <option value="encerrada" <?= $mentoria['status'] === 'encerrada' ? 'selected' : '' ?>>Encerrada</option>
                    <option value="pendente" <?= $mentoria['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                </select>

                <button type="submit" class="botao-salvar">Salvar Alterações</button>
                <a href="painel-mentor.php" class="botao-voltar">Voltar</a>
            </form>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
