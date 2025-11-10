<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CareerLab</title>
    <link rel="stylesheet" href="./index.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php include '../assets/Components/NavBar.php'; ?>

    <!-- SLIDER HERO -->
    <section class="hero-slider">

        <!-- Slide 1 -->
        <div class="slide active">
            <img src="img/slide1.png" class="slide-bg">
            <div class="overlay"></div>
            <div class="slide-content">
                <h1>Formando Talentos Prontos Para o Mercado</h1>
                <p>Desafios reais, mentoria e ranking gamificado.</p>
                <a href="#participar" class="btn-cta">Começar Agora</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide">
            <img src="img/slide2.png" class="slide-bg">
            <div class="overlay"></div>
            <div class="slide-content">
                <h1>Desafios Reais Todos os Dias</h1>
                <p>Resolva problemas de empresas e ganhe experiência prática.</p>
                <a href="#participar" class="btn-cta">Participar</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide">
            <img src="img/slide3.png" class="slide-bg">
            <div class="overlay"></div>
            <div class="slide-content">
                <h1>Se Destaque no Ranking</h1>
                <p>Ganhe pontos, badges e seja visto por empresas.</p>
                <a href="#participar" class="btn-cta">Subir no Ranking</a>
            </div>
        </div>


        <!-- Bolinhas -->
        <div class="slider-dots" id="slider-dots"></div>

    </section>
    <section class="missao">
        <div class="missao-grid">

            <div class="missao-img">
                <img src="../img/mission.png" alt="">
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
    <!-- SEÇÃO RANKING E GAMIFICAÇÃO -->
    <section class="ranking-gamificacao">
        <div class="rg-grid">

            <div class="rg-text">
                <span class="mini-sub">A evolução merece reconhecimento</span>
                <h2>Ranking e Gamificação</h2>
                <p>
                    No CareerLab, cada passo conta. Aqui, aprender é jogar com propósito:
                    desafios geram pontos, conquistas liberam medalhas e seu progresso é exibido
                    em um ranking real e dinâmico. Crescer deixa de ser invisível.
                </p>

                <ul class="rg-list">
                    <li>
                        <strong>🏆 Ranking Interativo:</strong> avance completando desafios semanais.
                    </li>
                    <li>
                        <strong>🎖 Medalhas de Conquista:</strong> destaque habilidades e evolução.
                    </li>
                    <li>
                        <strong>🚀 Progressão Contínua:</strong> aprendizado que não para.
                    </li>
                </ul>
            </div>

            <div class="rg-img">
                <img src="../img/teamwork.png" alt="">
            </div>

        </div>
    </section>

    <section class="testemunhos">
        <div class="testemunhos-header">
            <h2>Não confie só na nossa palavra</h2>
            <p>Veja o que nossos parceiros têm a dizer</p>
            <a href="#participar" class="btn-link">Participar Agora →</a>
        </div>

        <div class="slider-container">
            <div class="testemunhos-slider" id="testemunhos-slider">

                <div class="testemunho-card">
                    <img src="../img/empresa.png" alt="" class="perfil-img">
                    <div class="quote">“</div>
                    <p>
                        A equipe do CareerLab transformou a forma como recrutamos talentos.
                        Os participantes chegam preparados e motivados, com experiências reais.
                    </p>
                    <h4>Rafaela Moreira</h4>
                    <span>CEO da TechSolutions</span>
                </div>

                <div class="testemunho-card">
                    <img src="../img/aluno1.png" alt="" class="perfil-img">
                    <div class="quote">“</div>
                    <p>
                        Mentorar no CareerLab foi uma das experiências mais gratificantes
                        da minha carreira. Ver o crescimento dos jovens é inspirador.
                    </p>
                    <h4>Julio Alves</h4>
                    <span>Product Manager na InnovateX</span>
                </div>

                <div class="testemunho-card">
                    <img src="../img/mentora.png" alt="" class="perfil-img">
                    <div class="quote">“</div>
                    <p>
                        O CareerLab superou nossas expectativas — os projetos são criativos,
                        práticos e os profissionais saem prontos para o mercado.
                    </p>
                    <h4>Juliana Lopes</h4>
                    <span>CEO da BrightAI</span>
                </div>

            </div>

            <div class="slider-buttons">
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
        </div>
    </section>


    <section class="faq">
        <h2>Perguntas Frequentes</h2>

        <div class="faq-list">
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
            "resposta" => "Sim! A participação como estudante e mentor é gratuita. Empresas têm planos personalizados."
          ]
        ];

        foreach ($faqs as $index => $faq) {
          echo '
          <div class="faq-row">
            <input type="checkbox" id="faq'.$index.'">
            <label for="faq'.$index.'" class="faq-question">
              '.$faq["pergunta"].'
              <span class="arrow">→</span>
            </label>
            <div class="faq-answer">
              <p>'.$faq["resposta"].'</p>
            </div>
          </div>';
        }
        ?>
        </div>
    </section>




    <section id="participar" class="participar">
        <div class="participar-container">
            <h2>Pronto para Começar?</h2>
            <p>Escolha como deseja entrar no CareerLab</p>

            <div class="participar-cards">

                <a href="cadastro-usuario.php" class="card">
                    <img src="../img/estudante.png" alt="Estudante">
                    <h3>Sou Estudante</h3>
                </a>

                <a href="cadastro-mentor.php" class="card">
                    <img src="../img/mentor.png" alt="Mentor">
                    <h3>Sou Mentor</h3>
                </a>

                <a href="cadastro-empresa.php" class="card">
                    <img src="../img/empresa.png" alt="Empresa">
                    <h3>Sou Empresa</h3>
                </a>

            </div>
        </div>
    </section>
    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll(".slide");
    const dotsContainer = document.getElementById("slider-dots");

    slides.forEach((_, i) => {
        const dot = document.createElement("div");
        dot.classList.add("dot");
        if (i === 0) dot.classList.add("active");
        dot.onclick = () => goToSlide(i);
        dotsContainer.appendChild(dot);
    });

    function updateSlider() {
        slides.forEach((slide, index) => {
            slide.classList.toggle("active", index === currentSlide);
        });

        document.querySelectorAll(".dot").forEach((dot, index) => {
            dot.classList.toggle("active", index === currentSlide);
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateSlider();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateSlider();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateSlider();
    }

    setInterval(nextSlide, 6000); // autoplay
    </script>


    <?php include '../assets/Components/footer.php'; ?>
</body>