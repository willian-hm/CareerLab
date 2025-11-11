<?php
session_start();
require_once "../assets/src/ConexaoBD.php";
require_once "../assets/src/MentoriaDAO.php";
require_once "../assets/src/AreaDAO.php";

$conexao = ConexaoBD::conectar();

// Filtro de área
$idarea = $_GET['idarea'] ?? '';
$areas = AreaDAO::listarAreas();

// Usuário logado
$idusuario = $_SESSION['idusuario'] ?? null;

// ---------------------
// MENTORIAS DISPONÍVEIS
// ---------------------
if (!empty($idarea)) {
    $sql = "SELECT m.*, a.nome_a AS nome_area,
            (SELECT COUNT(*) FROM inscrevermentoria i WHERE i.idmentoria = m.idmentoria) AS inscritos
            FROM mentoria m
            LEFT JOIN areaespecializacao a ON m.idarea = a.idarea
            WHERE m.idarea = ?
            AND m.idmentoria NOT IN (SELECT idmentoria FROM inscrevermentoria WHERE idusuario = ?)
            ORDER BY m.data ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idarea, $idusuario]);
} else {
    $sql = "SELECT m.*, a.nome_a AS nome_area,
            (SELECT COUNT(*) FROM inscrevermentoria i WHERE i.idmentoria = m.idmentoria) AS inscritos
            FROM mentoria m
            LEFT JOIN areaespecializacao a ON m.idarea = a.idarea
            WHERE m.idmentoria NOT IN (SELECT idmentoria FROM inscrevermentoria WHERE idusuario = ?)
            ORDER BY m.data ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$idusuario]);
}
$mentoriasDisponiveis = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ---------------------
// MENTORIAS INSCRITAS
// ---------------------
$sqlInscritas = "SELECT m.*, a.nome_a AS nome_area
                 FROM mentoria m
                 INNER JOIN inscrevermentoria i ON m.idmentoria = i.idmentoria
                 LEFT JOIN areaespecializacao a ON m.idarea = a.idarea
                 WHERE i.idusuario = ?
                 ORDER BY m.data ASC";
$stmtInscritas = $conexao->prepare($sqlInscritas);
$stmtInscritas->execute([$idusuario]);
$mentoriasInscritas = $stmtInscritas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentorias</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f4f6fa;
    font-family: "Poppins", sans-serif;
}
/* AQUI você adiciona */
.btn-primary {
    background-color: #082f6d !important;
    border-color: #082f6d !important;
}
.container { margin-top: 30px; }
.card-mentoria {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 20px;
    transition: 0.3s;
    cursor: pointer;
}
.card-mentoria:hover { transform: scale(1.02); }
.card-mentoria.cheia {
    background: #eaeaea;
    cursor: not-allowed;
    opacity: 0.7;
}
.status-vagas { font-size: 0.9em; font-weight: bold; color: #0a3a8a; }
.status-cheia { color: #a02330ff; }
.nav-tabs .nav-link.active { font-weight: bold; color: #0d6efd !important; }
</style>
</head>
<body>

<?php include_once "../assets/Components/NavLogada.php"; ?>

<main>
<div class="container">
    <h2 class="text-center mb-4 fw-bold display-6">Mentorias</h2>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <div class="alert alert-info text-center">
            <?= $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?>
        </div>
    <?php endif; ?>

    <!-- Abas -->
    <ul class="nav nav-tabs mb-4" id="mentoriaTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#disponiveis">Disponíveis</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#inscritas">Minhas Inscrições</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Mentorias Disponíveis -->
        <div class="tab-pane fade show active" id="disponiveis">
            <form method="GET" class="mb-4 text-center">
                <select name="idarea" class="form-select w-50 d-inline">
                    <option value="">Todas as Áreas</option>
                    <?php foreach ($areas as $area): ?>
                        <option value="<?= $area['idarea'] ?>" <?= $idarea == $area['idarea'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($area['nome_a']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary ms-2">Filtrar</button>
            </form>

            <div class="row">
                <?php if (empty($mentoriasDisponiveis)): ?>
                    <p class="text-center">Nenhuma mentoria disponível no momento.</p>
                <?php else: ?>
                    <?php foreach ($mentoriasDisponiveis as $m): 
                        $vagasRestantes = $m['vaga_limite'] - $m['inscritos'];
                        $cheia = $vagasRestantes <= 0;
                    ?>
                        <div class="col-md-4">
                            <div class="card-mentoria <?= $cheia ? 'cheia' : '' ?>" 
                                data-id="<?= $m['idmentoria'] ?>"
                                data-titulo="<?= htmlspecialchars($m['titulo']) ?>"
                                data-descricao="<?= htmlspecialchars($m['descricao']) ?>"
                                data-area="<?= htmlspecialchars($m['nome_area']) ?>"
                                data-data="<?= date('d/m/Y', strtotime($m['data'])) ?>"
                                data-horario="<?= htmlspecialchars($m['horario']) ?>"
                                data-local="<?= htmlspecialchars($m['local']) ?>"
                                data-vagas="<?= $vagasRestantes ?>">
                                <h5><?= htmlspecialchars($m['titulo']) ?></h5>
                                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($m['data'])) ?></p>
                                <p><strong>Horário:</strong> <?= htmlspecialchars($m['horario']) ?></p>
                                <p class="<?= $cheia ? 'status-cheia' : 'status-vagas' ?>">
                                    <?= $cheia ? 'Mentoria Cheia' : "Vagas disponíveis: $vagasRestantes" ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Minhas Inscrições -->
        <div class="tab-pane fade" id="inscritas">
            <div class="row">
                <?php if (empty($mentoriasInscritas)): ?>
                    <p class="text-center">Você ainda não está inscrito em nenhuma mentoria.</p>
                <?php else: ?>
                    <?php foreach ($mentoriasInscritas as $m): ?>
                        <div class="col-md-4">
                            <div class="card-mentoria">
                                <h5><?= htmlspecialchars($m['titulo']) ?></h5>
                                <p><strong>Área:</strong> <?= htmlspecialchars($m['nome_area']) ?></p>
                                <p><strong>Data:</strong> <?= date('d/m/Y', strtotime($m['data'])) ?></p>
                                <p><strong>Horário:</strong> <?= htmlspecialchars($m['horario']) ?></p>
                                <p><strong>Local:</strong> <?= htmlspecialchars($m['local']) ?></p>

                                <form action="processa-cancelamento.php" method="POST" onsubmit="return confirm('Deseja cancelar a inscrição nesta mentoria?')">
                                    <input type="hidden" name="idmentoria" value="<?= $m['idmentoria'] ?>">
                                    <button type="submit" class="btn btn-danger w-100 mt-2">Cancelar Inscrição</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DETALHES -->
<div class="modal fade" id="modalMentoria" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Área:</strong> <span id="areaModal"></span></p>
        <p><strong>Data:</strong> <span id="dataModal"></span></p>
        <p><strong>Horário:</strong> <span id="horarioModal"></span></p>
        <p><strong>Local:</strong> <span id="localModal"></span></p>
        <p><strong>Descrição:</strong> <span id="descricaoModal"></span></p>
        <p><strong>Vagas Restantes:</strong> <span id="vagasModal"></span></p>
      </div>
      <div class="modal-footer">
        <form action="processa-inscricao.php" method="POST">
            <input type="hidden" name="idmentoria" id="idMentoriaInput">
            <button type="submit" class="btn btn-success">Inscrever-se</button>
        </form>
      </div>
    </div>
  </div>
</div>

</main>

<?php include_once "../assets/Components/Footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.card-mentoria').forEach(card => {
    card.addEventListener('click', () => {
        if (card.classList.contains('cheia')) {
            alert('Essa mentoria está cheia.');
            return;
        }
        if (!card.dataset.descricao) return;

        document.getElementById('tituloModal').innerText = card.dataset.titulo;
        document.getElementById('areaModal').innerText = card.dataset.area;
        document.getElementById('dataModal').innerText = card.dataset.data;
        document.getElementById('horarioModal').innerText = card.dataset.horario;
        document.getElementById('localModal').innerText = card.dataset.local;
        document.getElementById('descricaoModal').innerText = card.dataset.descricao;
        document.getElementById('vagasModal').innerText = card.dataset.vagas;
        document.getElementById('idMentoriaInput').value = card.dataset.id;

        new bootstrap.Modal(document.getElementById('modalMentoria')).show();
    });
});
</script>
</body>
</html>
