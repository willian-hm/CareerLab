<?php
include_once "../assets/incs/valida-sessao.php";
require_once "../assets/src/UsuarioDAO.php";

$conexao = ConexaoBD::conectar();

// agora busca também o XP e ordena do maior para o menor
$stmt = $conexao->prepare("
    SELECT idusuario, nome_u, email_u, foto, bio_u, areaespecializacao, exp
    FROM usuario
    ORDER BY exp DESC, nome_u ASC
");
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
        :root {
            --azul-escuro: #085c67;
            --azul: #087788;
            --turquesa: #00cbb5;
            --cinza: #323b3b;
            --cinza-claro: #f2f6f6;
            --amarelo: #fdbc29;
        }

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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 2px solid #ccc;
        }

        .usuario-info {
            flex: 1;
            text-align: left;
        }

        .usuario-info h3 {
            margin: 0;
            color: #333;
        }

        .usuario-info p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }

        .xp-badge {
            background-color: var(--amarelo);
            color: white;
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 14px;
        }

        .posicao {
            font-size: 1.1rem;
            font-weight: bold;
            color: #555;
            width: 40px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include "../assets/Components/NavLogada.php"; ?>

    <main>
        <h1>🏆 Ranking de Usuários</h1>
        <p>Veja quem mais acumulou XP na plataforma!</p>

        <div class="ranking-container">
            <?php if (empty($usuarios)): ?>
                <p>Nenhum usuário cadastrado.</p>
            <?php else: ?>
                <?php
                $posicao = 1;
                foreach ($usuarios as $u):
                    ?>
                    <div class="usuario-card">
                        <div class="posicao">#<?= $posicao++ ?></div>
                        <img class="usuario-foto" src="../uploads/<?= htmlspecialchars($u['foto'] ?? 'default.png') ?>"
                            alt="<?= htmlspecialchars($u['nome_u']) ?>">
                        <div class="usuario-info">
                            <h3><?= htmlspecialchars($u['nome_u']) ?></h3>
                            <p><strong>Email:</strong> <?= htmlspecialchars($u['email_u']) ?></p>
                            <?php if (!empty($u['bio_u'])): ?>
                                <p><strong>Bio:</strong> <?= htmlspecialchars($u['bio_u']) ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="xp-badge"><?= (int) ($u['exp'] ?? 0) ?> XP</div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include "../assets/Components/Footer.php"; ?>
</body>

</html>