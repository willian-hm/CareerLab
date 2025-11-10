<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";

$conexao = ConexaoBD::conectar();
$stmt = $conexao->prepare("SELECT idusuario, nome_u, email_u, foto, bio_u, areaespecializacao FROM usuario ORDER BY nome_u ASC");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Usuários</title>
    <link rel="stylesheet" href="area-empresa.css">
    <style>
        main {
            max-width: 900px;
            margin: 40px auto;
            text-align: center;
        }
        .ranking-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }
        .usuario-card {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 15px 20px;
            transition: 0.2s;
        }
        .usuario-card:hover {
            background: #eef4ff;
            transform: translateY(-2px);
        }
        .usuario-foto {
            width: 60px; height: 60px; border-radius: 50%; 
            object-fit: cover; margin-right: 20px; border: 2px solid #ccc;
        }
        .usuario-info {
            flex: 1;
            text-align: left;
        }
        .usuario-info h3 {
            margin: 0; color: #333;
        }
        .usuario-info p {
            margin: 5px 0; color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <h1>Ranking de Usuários</h1>
        <p>Confira todos os usuários cadastrados na plataforma.</p>

        <div class="ranking-container">
            <?php if (empty($usuarios)): ?>
                <p>Nenhum usuário cadastrado.</p>
            <?php else: ?>
                <?php foreach ($usuarios as $u): ?>
                    <div class="usuario-card">
                        <img class="usuario-foto" 
                             src="../uploads/<?= htmlspecialchars($u['foto'] ?? 'default.png') ?>" 
                             alt="<?= htmlspecialchars($u['nome_u']) ?>">
                        <div class="usuario-info">
                            <h3><?= htmlspecialchars($u['nome_u']) ?></h3>
                            <p><strong>Email:</strong> <?= htmlspecialchars($u['email_u']) ?></p>
                            <?php if (!empty($u['bio_u'])): ?>
                                <p><strong>Bio:</strong> <?= htmlspecialchars($u['bio_u']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($u['areaespecializacao'])): ?>
                                <p><strong>Área:</strong> <?= htmlspecialchars($u['areaespecializacao']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>
</html>
