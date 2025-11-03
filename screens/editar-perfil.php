<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";
require_once "../assets/src/AreaDAO.php";

$idUsuario = $_SESSION['idusuario'] ?? null;
if (!$idUsuario) {
    header("Location: login-usuario.php");
    exit;
}

$usuario = UsuarioDAO::buscarPorId($idUsuario);
$areas = AreaDAO::listarAreas();

$nome = $usuario['nome'] ?? '';
$email = $usuario['email_u'] ?? '';
$bio = $usuario['bio'] ?? '';
$area = $usuario['area'] ?? '';
$foto = $usuario['foto'] ?? 'padrao.png';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome_u' => $_POST['nome_u'] ?? $nome,
        'email_u' => $_POST['email_u'] ?? $email,
        'bio_u' => $_POST['bio_u'] ?? $bio,
        'areaespecializacao' => $_POST['areaespecializacao'] ?? $area
    ];

    $arquivoFoto = $_FILES['foto'] ?? null;

    try {
        $atualizou = UsuarioDAO::atualizarUsuario($idUsuario, $dados, $arquivoFoto);
        if ($atualizou) {
            $mensagem = "Perfil atualizado com sucesso!";
            $usuario = UsuarioDAO::buscarPorId($idUsuario);
            $nome = $usuario['nome'];
            $email = $usuario['email_u'];
            $bio = $usuario['bio'];
            $area = $usuario['area'];
            $foto = $usuario['foto'];
            $_SESSION['nomeusuario'] = $nome;
            $_SESSION['fotousuario'] = $foto;
        } else {
            $mensagem = "Nenhuma alteração realizada.";
        }
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil | CareerLab</title>
    <link rel="stylesheet" href="editar-perfil.css">
    <style>
        .preview-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <div class="perfil-container">


            <h2>Editar Perfil</h2>


            <?php if ($mensagem): ?>
                <div class="mensagem <?= strpos($mensagem, 'Erro') === 0 ? 'erro' : 'sucesso' ?>">
                    <?= htmlspecialchars($mensagem) ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="foto-atual text-center">
                    <img src="../uploads/<?= htmlspecialchars($foto) ?>" alt="Foto atual" id="preview"
                        class="preview-img">
                </div>

                <label for="foto">Alterar Foto de Perfil</label>
                <div class="input-file-container">
                    <label for="foto" class="input-file-label">Escolher Foto</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <span class="input-file-name" id="file-name">Nenhum arquivo selecionado</span>
                </div>


                <label for="nome_u">Nome</label>
                <input type="text" id="nome_u" name="nome_u" value="<?= htmlspecialchars($nome) ?>" required>

                <label for="email_u">Email</label>
                <input type="email" id="email_u" name="email_u" value="<?= htmlspecialchars($email) ?>" required>

                <label for="bio_u">Bio</label>
                <textarea id="bio_u" name="bio_u"><?= htmlspecialchars($bio) ?></textarea>

                <label for="areaespecializacao">Área de Especialização</label>
                <select id="areaespecializacao" name="areaespecializacao">
                    <option value="">Selecione uma área</option>
                    <?php foreach ($areas as $a): ?>
                        <option value="<?= $a['idarea'] ?>" <?= $area == $a['nome_a'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['nome_a']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="btn-container">
                    <button type="submit" class="btn btn-salvar">Salvar Alterações</button>
                    <a href="meu-perfil.php" class="btn btn-cancelar">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>

    <script>
        const inputFoto = document.getElementById('foto');
        const fileName = document.getElementById('file-name');
        const preview = document.getElementById('preview');

        inputFoto.addEventListener('change', () => {
            const file = inputFoto.files[0];
            if (file) {
                fileName.textContent = file.name;

                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = "Nenhum arquivo selecionado";
                preview.src = "../uploads/<?= htmlspecialchars($foto) ?>"; // mantém foto atual
            }
        });

    </script>

</body>

</html>