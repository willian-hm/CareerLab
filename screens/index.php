<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CareerLab</title>
  <link rel="stylesheet" href="./index.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>

<body>

  <?php include '../assets/Components/NavBar.php'; ?>

  <!-- HERO -->
  <section class="hero">
    <div class="hero-container">
      <h1>Forme talentos prontos para o mercado</h1>
      <p>Com desafios reais, mentoria, ranking e contratação direta.</p>
      <a href="#participar" class="btn-cta">Começar Agora</a>
    </div>
  </section>
<!-- MISSÃO -->
<section class="missao">
  <div class="missao-grid">
    
    <div class="missao-img">
      <img src="img/missão" alt="Pessoas colaborando">
    </div>

    <div class="missao-text">
      <span class="mini-sub">Nós guiamos ideias para a realidade</span>
      <h2>Nossa Missão</h2>
      <p>
        No CareerLab, acreditamos que o futuro se constrói com propósito, 
        aprendizado e prática real. Nossa missão é capacitar talentos 
        através de desafios guiados, mentoria e colaboração, criando pontes 
        entre quem quer aprender e quem precisa de inovação.
      </p>
     
    </div>

  </div>
</section>

 <section class="testemunhos">
  <h2>Não confie só na nossa palavra</h2>
  <p class="sub">Veja o que nossos parceiros têm a dizer</p>

  <div class="testemunhos-container">
    
    <div class="testemunho-card">
      <div class="quote">“</div>
      <p class="texto">
        A equipe do CareerLab transformou a forma como recrutamos talentos.
        Os participantes chegam preparados e motivados, com experiências reais.
      </p>
      <div class="perfil">
        <img src="img/user1.jpg" alt="Foto de Rafael Moreira">
        <div>
          <h4>Rafael Moreira</h4>
          <span>CEO da TechSolutions</span>
        </div>
      </div>
    </div>

    <div class="testemunho-card">
      <div class="quote">“</div>
      <p class="texto">
        Mentorar no CareerLab foi uma das experiências mais gratificantes
        da minha carreira. Ver o crescimento dos jovens é inspirador.
      </p>
      <div class="perfil">
        <img src="img/user2.jpg" alt="Foto de Julia Alves">
        <div>
          <h4>Julia Alves</h4>
          <span>Product Manager na InnovateX</span>
        </div>
      </div>
    </div>

    <div class="testemunho-card">
      <div class="quote">“</div>
      <p class="texto">
        O CareerLab superou nossas expectativas — os projetos são criativos, 
        práticos e os profissionais saem prontos para o mercado.
      </p>
      <div class="perfil">
        <img src="img/user3.jpg" alt="Foto de Ricardo Lopes">
        <div>
          <h4>Ricardo Lopes</h4>
          <span>CEO da BrightAI</span>
        </div>
      </div>
    </div>

  </div>
</section>

<section class="faq">
  <h2>Perguntas Frequentes</h2>

  <div class="faq-container">
    <?php
    $faqs = [
      [
        "pergunta" => "O que é o CareerLab?",
        "resposta" => "O CareerLab é uma plataforma que conecta talentos, mentores e empresas por meio de desafios práticos e projetos reais."
      ],
      [
        "pergunta" => "Como posso participar?",
        "resposta" => "Você pode se cadastrar como estudante, mentor ou empresa, preenchendo o formulário disponível na seção “Participar”."
      ],
      [
        "pergunta" => "O CareerLab é gratuito?",
        "resposta" => "Sim! A participação como estudante e mentor é totalmente gratuita. As empresas podem usar o sistema de forma personalizada."
      ]
    ];

    foreach ($faqs as $index => $faq) {
      echo '
      <div class="faq-item">
        <input type="checkbox" id="faq' . $index . '">
        <label class="faq-question" for="faq' . $index . '">
          ' . htmlspecialchars($faq["pergunta"]) . '
          <span class="arrow">+</span>
        </label>
        <div class="faq-answer">
          <p>' . htmlspecialchars($faq["resposta"]) . '</p>
        </div>
      </div>';
    }
    ?>
  </div>
</section>

  <!-- SEÇÃO RANKING E GAMIFICAÇÃO -->
<section class="ranking-gamificacao">
  <div class="ranking-header">
    <h3>Sobre o CareerLab</h3>
    <h2>Ranking e Gamificação</h2>
    <p>Transformamos o aprendizado em uma experiência envolvente.  
      Cada conquista conta pontos e o progresso dos participantes aparece em um ranking dinâmico e divertido!</p>
  </div>

  <div class="ranking-cards">
    <div class="ranking-card">
      <img src="img/icon-ranking.png" alt="Ícone de ranking">
      <h4>🏆 Ranking Interativo</h4>
      <p>Os alunos acumulam pontos ao completar desafios e subir no ranking, incentivando o crescimento e a competitividade saudável.</p>
    </div>

    <div class="ranking-card">
      <img src="img/icon-badge.png" alt="Ícone de conquistas">
      <h4>🎯 Conquistas e Selos</h4>
      <p>A cada meta alcançada, o participante desbloqueia selos e medalhas que mostram suas habilidades e dedicação.</p>
    </div>

    <div class="ranking-card">
      <img src="img/icon-game.png" alt="Ícone de gamificação">
      <h4>💡 Aprendizado Gamificado</h4>
      <p>Missões, níveis e recompensas tornam o aprendizado mais divertido, estimulando a participação ativa e contínua.</p>
    </div>
  </div>
</section>

  

  <!-- CTA -->
  <section id="participar" class="participar">
    <h2>Pronto para Começar?</h2>

    <div class="perfils">
      <a href="cadastro-usuario.php" class="perfil">Sou Estudante</a>
      <a href="cadastro-mentor.php" class="perfil">Sou Mentor</a>
      <a href="cadastro-empresa.php" class="perfil">Sou Empresa</a>
    </div>
  </section>

  <?php include '../assets/Components/footer.php'; ?>
</body>