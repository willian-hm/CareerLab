<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CareerLab</title>
    <link rel="stylesheet" href="index.css" />
  </head>
  <body>
    <?php
    include '../assets/Components/NavBar.php';
    ?>

    <!-- Hero -->
    <section class="hero">
      <div class="hero-content">
        <h1>Transforme talentos em impacto real</h1>
        <p>
          Conectamos estudantes, mentores e empresas em desafios reais que geram
          aprendizado, inovação e oportunidades.
        </p>
        <div class="cta">
          <a href="#participar" class="btn">Começar agora</a>
        </div>
      </div>
    </section>

    <!-- Sobre -->
    <section id="sobre" class="section sobre">
      <div class="sobre-content">
        <div class="texto">
          <h2>O que é o CareerLab?</h2>
          <p>
            O CareerLab é um ecossistema de desenvolvimento que aproxima
            estudantes do mercado de trabalho através de projetos práticos,
            mentorias e conexões com empresas reais.
          </p>
          <p>
            Aqui, o aprendizado acontece na prática. Cada desafio é uma
            oportunidade de evoluir, se destacar e ser descoberto.
          </p>
        </div>
        <div class="imagem">
          <img src="../img/teamwork.png" alt="Equipe colaborando" />
        </div>
      </div>
    </section>

    <!-- Missão -->
    <section id="missao" class="section valores">
      <h2>Nossa Missão</h2>
      <p class="sub">
        Conectar talentos, ideias e oportunidades através da experiência
        prática.
      </p>
      <div class="valores-grid">
        <div class="valor">
          <h3>🚀 Inovação</h3>
          <p>
            Estimulamos o protagonismo e a criatividade de quem busca fazer
            diferente.
          </p>
        </div>
        <div class="valor">
          <h3>🤝 Colaboração</h3>
          <p>
            Conectamos mentes e propósitos — porque ninguém evolui sozinho.
          </p>
        </div>
        <div class="valor">
          <h3>🌱 Crescimento</h3>
          <p>
            Cada projeto é uma oportunidade de evoluir pessoal e
            profissionalmente.
          </p>
        </div>
      </div>
    </section>

    <!-- Histórias -->
    <section id="hist" class="section historias">
      <h2>Histórias que Inspiram</h2>
      <p class="sub">
        Pessoas que transformaram aprendizado em conquistas reais.
      </p>

      <div class="cards">
        <div class="card">
          <img src="../img/aluno1.png" alt="Aluno CareerLab" />
          <h3>Lucas Souza</h3>
          <p>
            “Consegui meu primeiro estágio graças ao desafio da CareerLab. A
            experiência foi transformadora!”
          </p>
        </div>
        <div class="card">
          <img src="../img/mentora.png" alt="Mentora CareerLab" />
          <h3>Daniela Costa</h3>
          <p>
            “Mentorar jovens talentos foi inspirador. A energia e vontade de
            aprender me renovaram.”
          </p>
        </div>
        <div class="card">
          <img src="../img/empresa.png" alt="Empresa parceira" />
          <h3>TechCorp</h3>
          <p>
            “Encontramos profissionais incríveis através da CareerLab. É um
            ganho mútuo.”
          </p>
        </div>
      </div>
    </section>

    <!-- Participar -->
    <section id="participar" class="section participar">
      <h2>Quer fazer parte?</h2>
      <p class="sub">
        Escolha o seu perfil e entre nessa rede de aprendizado e oportunidades.
      </p>
      <div class="caixas-perfil">
        <a href="cadastro-usuario.php"
            class="caixa-perfil">
          <img src="../img/estudante.png" alt="Sou estudante" />
          <h3>Sou Estudante</h3>
          <p>Participe de desafios reais e destaque-se no mercado.</p>
        </a>

        <a href="cadastro-mentor.php"
           class="caixa-perfil">
          <img src="../img/mentor.png" alt="Sou mentor" />
          <h3>Sou Mentor</h3>
          <p>Compartilhe conhecimento e inspire a próxima geração.</p>
        </a>

        <a href="cadastro-empresa.php"
           class="caixa-perfil">
          <img src="../img/empresa-btn.png" alt="Sou empresa" />
          <h3>Sou Empresa</h3>
          <p>Descubra novos talentos e impulsione sua equipe com inovação.</p>
        </a>
      </div>
    </section>

    <?php
    include '../assets/Components/footer.php';
    ?>

    <script>
      const toggle = document.getElementById("menu-toggle");
      const navLinks = document.getElementById("nav-links");
      toggle.addEventListener("click", () => {
        navLinks.classList.toggle("active");
        toggle.classList.toggle("active");
      });
    </script>
  </body>
</html>
