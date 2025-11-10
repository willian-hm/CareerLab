async function carregarAlunos(idmentoria) {
  const container = document.getElementById("modal-alunos");
  container.innerHTML = "<p>Carregando alunos...</p>";

  try {
    const response = await fetch(`listar-inscritos.php?id=${idmentoria}`);
    const data = await response.json();

    if (!Array.isArray(data)) {
      console.error("Resposta inesperada:", data);
      container.innerHTML = "<p>Erro ao carregar alunos.</p>";
      return;
    }

    if (data.length === 0) {
      container.innerHTML = "<p>Nenhum aluno inscrito.</p>";
      return;
    }

    container.innerHTML = data
      .map(
        (a) => `
    <div class="aluno">
        <div class="info-aluno">
            <strong>${a.nome_u}</strong> (${a.email_u})<br>
            <span class="xp">XP: ${a.exp ?? 0}</span>
        </div>
        <button class="botao-presenca" data-idusuario="${
          a.idusuario
        }" data-idmentoria="${idmentoria}">Confirmar Presença</button>
    </div>
`
      )
      .join("");

    // Ação de presença via AJAX
    document.querySelectorAll(".botao-presenca").forEach((btn) => {
      btn.addEventListener("click", async () => {
        const idusuario = btn.dataset.idusuario;
        const idmentoria = btn.dataset.idmentoria;
        const acao = btn.textContent.includes("Desconfirmar")
          ? "desconfirmar"
          : "confirmar";

        const formData = new FormData();
        formData.append("idmentoria", idmentoria);
        formData.append("idusuario", idusuario);
        formData.append("acao", acao);

        const resp = await fetch("processa-presenca.php", {
          method: "POST",
          body: formData,
        });
        const json = await resp.json();

        if (json.sucesso) {
          btn.textContent =
            json.acao === "confirmar"
              ? "Confirmar Presença"
              : "Desconfirmar Presença";
          btn.classList.toggle("confirmado");
          carregarAlunos(idmentoria);
        } else {
          alert(json.erro || "Erro ao processar presença.");
        }
      });
    });
  } catch (err) {
    console.error("Erro no fetch:", err);
    container.innerHTML = "<p>Erro ao carregar alunos.</p>";
  }
}

function abrirModal(mentoria) {
  document.getElementById("modal-titulo").innerText = mentoria.titulo;
  document.getElementById("modal-area").innerText =
    mentoria.nome_area || "Não informada";
  document.getElementById("modal-data").innerText = mentoria.data || "—";
  document.getElementById("modal-horario").innerText = mentoria.horario || "—";
  document.getElementById("modal-local").innerText = mentoria.local || "—";
  document.getElementById("modal-vagas").innerText =
    mentoria.vaga_limite || "—";
  document.getElementById("modal-status").innerText = mentoria.status || "—";
  document.getElementById("modal-descricao").innerText =
    mentoria.descricao || "—";

  document.getElementById("botao-editar").href =
    "editar-mentoria.php?id=" + mentoria.idmentoria;
  document.getElementById("botao-excluir").href =
    "processa-exclusao-mentoria.php?id=" + mentoria.idmentoria;
  document.getElementById("botao-excluir").onclick = function (e) {
    if (!confirm("Tem certeza que deseja excluir esta mentoria?")) {
      e.preventDefault();
    }
  };

  carregarAlunos(mentoria.idmentoria);
  document.getElementById("modal-mentoria").style.display = "flex";
}

function fecharModal() {
  document.getElementById("modal-mentoria").style.display = "none";
}

// crie um helper que renderiza cada aluno com botão adaptável
function renderAlunoHTML(a, idmentoria) {
  // botão inicial é "Confirmar Presença"
  // se a.has_presenca === true então mostra "Presença confirmada" e botão desfazer
  const tem = a.has_presenca ? true : false;
  return `
    <div class="aluno" data-idusuario="${a.idusuario}">
        <div>
            <strong>${a.nome_u}</strong> (${a.email_u})<br>
            XP: ${a.exp ?? 0}
        </div>
        <div class="acoes-aluno">
            ${
              tem
                ? `<button class="botao-presenca confirmado" data-acao="desfazer" data-idmentoria="${idmentoria}" data-idusuario="${a.idusuario}">Desfazer Presença</button>`
                : `<button class="botao-presenca" data-acao="confirmar" data-idmentoria="${idmentoria}" data-idusuario="${a.idusuario}">Confirmar Presença</button>`
            }
        </div>
    </div>`;
}

// carregar alunos agora pede também se já confirmaram presença
async function carregarAlunos(idmentoria) {
  const container = document.getElementById("modal-alunos");
  container.innerHTML = "<p>Carregando alunos...</p>";

  try {
    const response = await fetch(`listar-inscritos.php?id=${idmentoria}`);
    const data = await response.json();
    console.log("listar-inscritos response:", data);

    if (!Array.isArray(data)) {
      container.innerHTML = `<p>Erro ao carregar alunos.</p>`;
      return;
    }
    if (data.length === 0) {
      container.innerHTML = "<p>Nenhum aluno inscrito.</p>";
      return;
    }

    // opcional: para cada aluno, checar se já tem presença (pode ser feito no backend)
    // para eficiência, seria melhor que listar-inscritos já retornasse has_presenca;
    // mas vamos checar localmente via endpoint rápido que retorna se existe (ou adaptar listar-inscritos.php)
    // Assumindo que listar-inscritos já traz `has_presenca` (se não trouxer, podemos chamar um endpoint extra)
    container.innerHTML = data
      .map((a) => renderAlunoHTML(a, idmentoria))
      .join("");

    // attach handlers nos botões
    container.querySelectorAll(".botao-presenca").forEach((btn) => {
      btn.addEventListener("click", async function (e) {
        e.preventDefault();
        const acao = this.dataset.acao; // confirmar/desfazer
        const idusuario = this.dataset.idusuario;
        const idmentoria = this.dataset.idmentoria;
        await togglePresenca(this, idmentoria, idusuario, acao);
      });
    });
  } catch (err) {
    console.error("Erro no fetch:", err);
    container.innerHTML = "<p>Erro ao carregar alunos.</p>";
  }
}

// envia a ação e atualiza o botão/XP no DOM sem reload
async function togglePresenca(buttonElem, idmentoria, idusuario, acao) {
  try {
    buttonElem.disabled = true;
    buttonElem.innerText =
      acao === "confirmar" ? "Confirmando..." : "Removendo...";

    const form = new FormData();
    form.append("idmentoria", idmentoria);
    form.append("idusuario", idusuario);
    form.append("acao", acao);

    const res = await fetch("processa-presenca.php", {
      method: "POST",
      body: form,
    });
    const json = await res.json();
    console.log("processa-presenca:", json);

    if (json.sucesso) {
      // atualiza visual: se confirmou -> trocar botão pra "Desfazer Presença"
      const parent = buttonElem.closest(".aluno");
      const xpElem = parent.querySelector("div"); // onde XP é mostrado (simples)
      // opcional: incrementar visualmente o XP mostrado (precisa do valor exato retornado do servidor para ser perfeito)
      // para simplicidade, vamos apenas ajustar o botão
      if (acao === "confirmar") {
        buttonElem.dataset.acao = "desfazer";
        buttonElem.innerText = "Desfazer Presença";
        buttonElem.classList.add("confirmado");
      } else {
        buttonElem.dataset.acao = "confirmar";
        buttonElem.innerText = "Confirmar Presença";
        buttonElem.classList.remove("confirmado");
      }
      // reativa o botão
      buttonElem.disabled = false;
    } else {
      // não obteve sucesso (ex: já registrado)
      alert(json.mensagem || json.erro || "Erro ao processar.");
      buttonElem.disabled = false;
      buttonElem.innerText =
        acao === "confirmar" ? "Confirmar Presença" : "Desfazer Presença";
    }
  } catch (err) {
    console.error("Erro togglePresenca:", err);
    alert("Erro de comunicação com o servidor.");
    buttonElem.disabled = false;
    buttonElem.innerText =
      acao === "confirmar" ? "Confirmar Presença" : "Desfazer Presença";
  }
}
