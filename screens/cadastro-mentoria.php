<?php
include_once "../assets/incs/valida-sessao-mentor.php";
require_once "../assets/src/MentoriaDAO.php";
require_once "../assets/src/AreaDAO.php";

$mensagem = "";

// Carrega as áreas de especialização
try {
    $areas = AreaDAO::listarAreas(); // <-- ADICIONA ESTA LINHA
} catch (Exception $e) {
    $areas = [];
    $mensagem = "Erro ao carregar áreas: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        MentoriaDAO::cadastrar($_POST, $idmentor);
        $mensagem = "Mentoria cadastrada com sucesso!";
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Mentoria</title>
    <link rel="stylesheet" href="cadastro-mentoria.css">
</head>
<body>
    <?php include "../assets/Components/NavBarLogadaMentor.php"; ?>

    <main>
        <div class="container">
            <h1>Cadastrar Nova Mentoria</h1>

            <?php if ($mensagem): ?>
                <p class="mensagem"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>

                <label>Área de Especialização:</label>
                <select name="idarea" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= htmlspecialchars($area['idarea']) ?>">
                            <?= htmlspecialchars($area['nome_a']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="data">Data:</label>
                <input type="date" name="data" id="data" required>

                <label for="horario">Horário:</label>
                <input type="time" name="horario" id="horario" required>

                <label for="vaga_limite">Limite de Vagas:</label>
                <input type="number" name="vaga_limite" id="vaga_limite" min="1" required>

                <label for="local">Local / Link de Videoconferência:</label>
                <input type="text" name="local" id="local" required>

                <button type="submit" class="botao-salvar">Cadastrar Mentoria</button>
                <a href="painel-mentor.php" class="botao-voltar">Voltar</a>
            </form>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
