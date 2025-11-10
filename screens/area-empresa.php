<?php
include_once "../assets/incs/valida-sessao-empresa.php";
require_once "../assets/src/DesafioDAO.php";
require_once "../assets/src/ConexaoBD.php";

$desafios = DesafioDAO::listarPorEmpresa($idempresa);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área da Empresa</title>
    <link rel="stylesheet" href="area-empresa.css">
    <style>
        /* ajustes visuais rápidos */
        main { padding: 40px; max-width: 1100px; margin: 40px auto; }
        .cards-info { display: grid; grid-template-columns: repeat(auto-fill,minmax(260px,1fr)); gap: 18px; margin-top: 20px; }
        .card-info { background:#fff; border-radius:10px; padding:18px; border:1px solid #e6e6e6; cursor:pointer; transition: .15s; }
        .card-info:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .card-info h3 { margin:0 0 8px 0; }
        .card-info p { margin:0; color:#666; font-size:14px; }

        /* Modal */
        .modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999; }
        .modal-conteudo { width: 92%; max-width: 900px; background:#fff; border-radius:10px; padding:18px; max-height:90vh; overflow:auto; }
        .fechar { position:absolute; right:14px; top:14px; cursor:pointer; font-size:22px; color:#777; }
        .inscritos-list { margin-top: 12px; }
        .inscrito { display:flex; align-items:center; justify-content:space-between; padding:10px 12px; border-bottom:1px solid #f0f0f0; }
        .inscrito .info { display:flex; gap:12px; align-items:center; flex:1; }
        .avatar { width:46px; height:46px; border-radius:50%; object-fit:cover; border:1px solid #ddd; }
        .nome { font-weight:600; }
        .email { color:#666; font-size:13px; }
        .acoes { display:flex; gap:8px; align-items:center; }
        .btn-selecionar { background:#0d6efd; color:white; border:none; padding:7px 12px; border-radius:8px; cursor:pointer; font-weight:600; }
        .btn-desmarcar { background:#dc3545; color:white; border:none; padding:7px 12px; border-radius:8px; cursor:pointer; font-weight:600; }
        .badge-selecionado { background:#ffd700; color:#111; padding:6px 10px; border-radius:999px; font-weight:700; box-shadow:0 3px 8px rgba(255,215,0,0.28); }
        .vazio { padding:16px; color:#666; }
    </style>
</head>
<body>
    <?php include "../assets/Components/NavLogadaEmpresa.php"; ?>

    <main>
        <h1>Bem-vinda, <?= htmlspecialchars($nomeempresa) ?>!</h1>
        <p>Aqui você pode gerenciar seus desafios e selecionar participantes para os projetos.</p>

        <div class="botoes-area">
            <a href="cadastra-desafio.php" class="botao-area">+ Criar Desafio</a>
        </div>

        <section class="cards-info">
            <?php if (empty($desafios)): ?>
                <p>Nenhum desafio cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($desafios as $d): ?>
                    <div class="card-info" data-iddesafio="<?= (int)$d['iddesafio'] ?>" onclick="abrirModal(<?= (int)$d['iddesafio'] ?>)">
                        <h3><?= htmlspecialchars($d['nomedesafio']) ?></h3>
                        <p><strong>Vagas:</strong> <?= (int)$d['vagaslimite'] ?></p>
                        <p><?= htmlspecialchars(strlen($d['orientacaodesafio']) > 100 ? substr($d['orientacaodesafio'], 0, 100) . '...' : $d['orientacaodesafio']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>

    <!-- Modal Detalhes + Inscritos -->
    <div id="modalDesafio" class="modal" onclick="if(event.target.id==='modalDesafio') fecharModal()">
        <div class="modal-conteudo" role="dialog" aria-modal="true" aria-labelledby="modalTitulo">
            <span class="fechar" onclick="fecharModal()">&times;</span>
            <h2 id="modalTitulo"></h2>
            <p id="modalOrientacao"></p>
            <p><strong>Vagas:</strong> <span id="modalVagas"></span></p>

            <hr style="margin:14px 0">

            <h3>Inscritos</h3>
            <div id="inscritosContainer" class="inscritos-list">
                <div class="vazio">Carregando inscritos...</div>
            </div>
        </div>
    </div>

    <?php include "../assets/Components/Footer.php"; ?>

    <script>
    let currentDesafioId = null;

    function abrirModal(iddesafio) {
        currentDesafioId = iddesafio;
        // limpa e abre
        document.getElementById('modalTitulo').innerText = 'Detalhes do desafio';
        document.getElementById('modalOrientacao').innerHTML = '';
        document.getElementById('modalVagas').innerText = '';
        document.getElementById('inscritosContainer').innerHTML = '<div class="vazio">Carregando inscritos...</div>';
        document.getElementById('modalDesafio').style.display = 'flex';

        // busca dados do desafio (opcional: pode buscar via endpoint; aqui pegamos do DOM card)
        const card = document.querySelector(`.card-info[data-iddesafio="${iddesafio}"]`);
        if (card) {
            document.getElementById('modalTitulo').innerText = card.querySelector('h3').innerText;
            document.getElementById('modalOrientacao').innerHTML = card.querySelector('p:nth-of-type(3)') ? card.querySelector('p:nth-of-type(3)').innerHTML : '';
            document.getElementById('modalVagas').innerText = card.querySelector('p:nth-of-type(2)').innerText.replace('Vagas:','').trim();
        }

        carregarInscritos(iddesafio);
    }

    function fecharModal() {
        document.getElementById('modalDesafio').style.display = 'none';
        currentDesafioId = null;
    }

    async function carregarInscritos(iddesafio) {
        const container = document.getElementById('inscritosContainer');
        container.innerHTML = '<div class="vazio">Carregando inscritos...</div>';
        try {
            const resp = await fetch('listar-inscritos-desafio.php?iddesafio=' + encodeURIComponent(iddesafio), { headers: { 'Accept': 'application/json' }});
            if (!resp.ok) throw new Error('Erro servidor: ' + resp.status);
            const data = await resp.json();
            // data expected: array of { idusuario, nome_u, email_u, foto, selecionado(0/1), exp }
            if (!Array.isArray(data)) {
                container.innerHTML = '<div class="vazio">Resposta inesperada do servidor.</div>';
                console.error(data);
                return;
            }
            if (data.length === 0) {
                container.innerHTML = '<div class="vazio">Nenhum inscrito encontrado para este desafio.</div>';
                return;
            }

            container.innerHTML = data.map(u => {
                const avatar = u.foto ? `../uploads/${u.foto}` : '../uploads/default.png';
                const selecionado = u.selecionado == 1;
                return `
                    <div class="inscrito" data-idusuario="${u.idusuario}">
                        <div class="info">
                            <img src="${avatar}" alt="${escapeHtml(u.nome_u)}" class="avatar" />
                            <div>
                                <div class="nome">${escapeHtml(u.nome_u)} ${selecionado ? '<span class="badge-selecionado">Selecionado</span>' : ''}</div>
                                <div class="email">${escapeHtml(u.email_u)}</div>
                                <div style="color:#777; font-size:12px; margin-top:6px;">XP: ${Number(u.exp || 0)}</div>
                            </div>
                        </div>
                        <div class="acoes">
                            ${selecionado 
                                ? `<button class="btn-desmarcar" data-acao="desmarcar" data-idusuario="${u.idusuario}">Desmarcar</button>`
                                : `<button class="btn-selecionar" data-acao="selecionar" data-idusuario="${u.idusuario}">Selecionar Projeto</button>`
                            }
                        </div>
                    </div>
                `;
            }).join('');

            // attach handlers
            container.querySelectorAll('.btn-selecionar, .btn-desmarcar').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const ação = btn.dataset.acao;
                    const idusuario = btn.dataset.idusuario;
                    await toggleSelecionado(btn, currentDesafioId, idusuario, ação);
                });
            });

        } catch (err) {
            console.error(err);
            container.innerHTML = '<div class="vazio">Erro ao carregar inscritos.</div>';
        }
    }

    async function toggleSelecionado(button, iddesafio, idusuario, acao) {
        try {
            button.disabled = true;
            button.textContent = acao === 'selecionar' ? 'Processando...' : 'Removendo...';

            const form = new FormData();
            form.append('iddesafio', iddesafio);
            form.append('idusuario', idusuario);
            form.append('acao', acao);

            const resp = await fetch('selecionar-projeto.php', { method: 'POST', body: form });
            const json = await resp.json();

            if (json.status === 'ok') {
                // recarrega inscritos pra refletir estado e XP atualizado
                await carregarInscritos(iddesafio);
            } else {
                alert(json.mensagem || 'Erro ao atualizar seleção.');
                button.disabled = false;
                button.textContent = acao === 'selecionar' ? 'Selecionar Projeto' : 'Desmarcar';
            }
        } catch (err) {
            console.error(err);
            alert('Erro de comunicação com o servidor.');
            button.disabled = false;
            button.textContent = acao === 'selecionar' ? 'Selecionar Projeto' : 'Desmarcar';
        }
    }

    function escapeHtml(unsafe) {
        return String(unsafe)
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
    }
    </script>
</body>
</html>
