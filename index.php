<?php
session_start();
include('./dados/db.php');



// Recupera mensagens
if (isset($_SESSION['messagesSucesso'])) {
  $mensagem2 = $_SESSION['messagesSucesso'];
  unset($_SESSION['messagesSucesso']);
}

if (isset($_SESSION['messageErro'])) {
  $mensagem = $_SESSION['messageErro'];
  unset($_SESSION['messageErro']);
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title>Portfólio | Jonas Fabricio</title>
  <link rel="stylesheet" href="assets/css/styles11.css" />

  <link rel="shortcut icon" href="./images/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- Script deve ficar AQUI, antes do fechamento do body -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="is-preload">

  <!-- Mensagens -->
  <?php if (!empty($mensagem)): ?>
    <div id="sos" class="mensagem-fixa" style="background:#ee5252;">
      <?php echo $mensagem; ?>
    </div>
  <?php endif; ?>

  <?php if (!empty($mensagem2)): ?>
    <div id="sos" class="mensagem-fixa" style="background:#32be39;">
      <?php echo $mensagem2; ?>
    </div>
  <?php endif; ?>


  <!-- Wrapper -->
  <div id="wrapper">
    <!-- Main -->
    <div id="main">
      <div class="inner">
        <!-- Header -->
        <header id="header">
          <a href="index.html" class="logo"><strong>Jonas Fabricio </strong>- Desenvolvedor Web</a>
          <ul class="icons">
            <li>
              <a target="_blank" href="https://github.com/jonasfab" class="icon brands fa-github"><span
                  class="label">Github</span></a>
            </li>
            <li>
              <a target="_blank" href="https://www.linkedin.com/in/jonas-fabricio-dos-santos-2734b4236/"
                class="icon brands fa-linkedin"><span class="label">linkedin</span></a>
            </li>

          </ul>
        </header>

        <!-- Banner -->
        <section id="banner">
          <div class="content">
            <header>
              <h1>Olá. Bem vindo ao meu portfólio</h1>
              <p>
                Eu Sou <span>Jonas</span>! <br />Trabalho em desenvolvimento
                de sites de alta performance.
              </p>
            </header>
            <p>
              Este portfólio reúne projetos que desenvolvi, sempre com foco em
              qualidade, soluções modernas e eficientes, unindo design,
              desempenho, funcionalidade e uma ótima experiência do usuário.
            </p>
            <ul class="actions">
              <li><a href="#projetos" class="button big">Projetos</a></li>
            </ul>
          </div>
          <span class="image object">
            <img src="images/main.png" alt="" />
          </span>
        </section>
        <style>
          .content span {
            font-weight: bold;
          }
        </style>

        <!-- Section -->
        <section id="habilidades">
          <header class="major">
            <h2>Habilidades</h2>
          </header>

          <div class="habilidades-grid">
            <article class="skill-item">
              <span class="icon"><i class="fa-brands fa-html5"></i></span>
              <h3>HTML</h3>
            </article>

            <article class="skill-item">
              <span class="icon"><i class="fa-brands fa-css3-alt"></i></span>
              <h3>CSS</h3>
            </article>

            <article class="skill-item">
              <span class="icon"><i class="fa-brands fa-js"></i></span>
              <h3>JavaScript</h3>
            </article>

            <article class="skill-item">
              <span class="icon"><i class="fa-brands fa-php"></i></span>
              <h3>PHP</h3>
            </article>

            <article class="skill-item">
              <span class="icon"><i class="fa-brands fa-bootstrap"></i></span>
              <h3>Bootstrap</h3>
            </article>

            <article class="skill-item">
              <span class="icon"><i class="fa-solid fa-database"></i></span>
              <h3>phpMyAdmin</h3>
            </article>
          </div>
        </section>

        <!-- Section -->
        <section id="projetos">
          <header class="major" id="projeto_sites">
            <h2>Projetos</h2>
          </header>
          <div class="posts">

            <article>
              <a class="image"><img src="images/pic22.png" alt="" /></a>
              <h3>Portfólio - Desenvolvedor</h3>
              <p>
                <strong>Criação do projeto utilizando:</strong> HTML - CSS - JAVASCRIPT - JQUERY - PHP - Bootstrap -
                phpMyAdmin
              </p>
              <ul class="actions">
                <li>
                  <a target="_blank" href="./index.php" class="button">Visualizar</a>
                </li>
              </ul>
            </article>

            <article>
              <a class="image"><img src="images/pic25.png" alt="" /></a>
              <h3>TV ONLINE</h3>
              <p>
                <strong>Criação do projeto utilizando:</strong> HTML - CSS -
                JAVASCRIPT - PHP - phpMyAdmin - Lista de IPTV
              </p>
              <ul class="actions">
                <li>
                  <a target="_blank" href="./projetos/TV_ONLINE"
                    class="button">Visualizar</a>
                </li>
              </ul>
            </article>

            <article>
              <a class="image"><img src="images/pic27.png" alt="" /></a>
              <h3>Painel de Senahs</h3>
              <p>
                <strong>Criação do projeto utilizando:</strong> Esta em desenvolvimento
              </p>
              <ul class="actions">
                <li>
                  <a target="_blank" href="./projetos/Painel_Senha/index.php"
                    class="button">Visualizar</a>
                </li>
              </ul>
            </article>


            <article>
              <a class="image"><img src="images/pict03.png" alt="" /></a>
              <h3>Portfólio - Marketing digital</h3>
              <p>
                <strong>Criação do projeto utilizando:</strong> HTML - CSS -
                JAVASCRIPT - BOOTSTRAP
              </p>
              <ul class="actions">
                <li>
                  <a target="_blank" href="./projetos/Portfólio - Marketing digital/index.html"
                    class="button">Visualizar</a>
                </li>
              </ul>
            </article>

            <article>
              <a class="image"><img src="images/pic20.png" alt="" /></a>
              <h3>Portfólio - Desenvolvedor</h3>
              <p>
                <strong>Criação do projeto utilizando:</strong> HTML - CSS - JAVASCRIPT
              </p>
              <ul class="actions">
                <li>
                  <a target="_blank" href="./projetos/Portfólio - Desenvolvedor/index.html"
                    class="button">Visualizar</a>
                </li>
              </ul>
            </article>




          </div>
        </section>

        <!-- Section 
        <section>
          <header class="major" id="projeto_sites">
            <h2>Baixar Corrículo</h2>
          </header>

          <div class="">
            <p>Aqui esta meu corrículo, <a href="./images/Currículo Jonas Fabricio.pdf" download>clique aqui para
                baixar.</a></p>
          </div>

        </section> -->

        <!-- Section -->
        <section id="contato">
          <header class="major" id="projeto_sites">
            <h2>Entrar em contato</h2>
          </header>


          <form method="post" action="enviar_contato.php">

            <div class="row gtr-uniform">


              <input type="hidden" name="status" value="0" />


              <div class="col-6 col-12-xsmall">
                <input required type="text" name="nome" id="demo-name" placeholder="Nome" />
              </div>

              <div class="col-6 col-12-xsmall">
                <input required type="tel" name="telefone" id="telefone" placeholder="Telefone" />

                <script>
                  document.getElementById("telefone").addEventListener("input", function(e) {
                    let v = e.target.value.replace(/\D/g, "").slice(0, 11);

                    if (v.length >= 2) {
                      v = `(${v.slice(0, 2)}) ` + v.slice(2);
                    }
                    if (v.length >= 10) {
                      v = v.slice(0, 9) + "-" + v.slice(9);
                    }

                    e.target.value = v;
                  });
                </script>
              </div>

              <div class="col-6 col-12-xsmall">
                <input required type="email" name="email" id="demo-email" placeholder="E-mail" />
              </div>

              <div class="col-12">
                <textarea style="resize: none" required name="descricao" id="demo-message"
                  placeholder="Me conte sobre seu projeto ou dúvida." rows="6"></textarea>
              </div>

              <!-- Break -->
              <div class="col-12">
                <ul class="actions">
                  <li>
                    <input type="submit" value="Enviar Mensagem" class="primary" />
                  </li>
                </ul>
              </div>

            </div>
          </form>

        </section>


      </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar">
      <div class="inner">
        <!-- Search -->
        <section class="alt">
          <svg width="30" height="30" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="24" cy="24" r="22" fill="url(#gradient-main)" stroke="currentColor" stroke-width="2" />
            <path d="M16 18L12 24L16 30" stroke="white" stroke-width="2.5" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M32 18L36 24L32 30" stroke="white" stroke-width="2.5" stroke-linecap="round"
              stroke-linejoin="round" />
            <path d="M28 16L20 32" stroke="white" stroke-width="2.5" stroke-linecap="round" />
            <path d="M28 16L20 32" stroke="white" stroke-width="2.5" stroke-linecap="round" />
            <defs>
              <linearGradient id="gradient-main" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#7823e7" />
                <stop offset="100%" stop-color="#333" />
              </linearGradient>
            </defs>
          </svg>
          <p>Desenvolvedor Web</p>
        </section>

        <!-- Menu -->
        <nav id="menu">
          <header class="major">
            <h2>Menu</h2>
          </header>
          <ul>
            <li><a href="#habilidades">Habilidades</a></li>
            <li><a href="#projetos">Projetos</a></li>
            <li><a href="#contato">Entrar em contato</a></li>
            <li><a href="./login.php">Login</a></li>
          </ul>
        </nav>

        <!-- Section -->
        <section>
          <header class="major">
            <h2>Layout</h2>
          </header>
          <div class="mini-posts">
            <article>
              <a class="image"><img src="./images/pic00.png" alt="" /></a>
              <p>Design em Desktop e Notebook.</p>
            </article>
            <article>
              <a class="image"><img src="./images/pic01.png" alt="" /></a>
              <p>Design em Tablets.</p>
            </article>
            <article>
              <a class="image"><img src="./images/pic02.png" alt="" /></a>
              <p>Design em Smartphones.</p>
            </article>
          </div>
        </section>

        <!-- Section -->
        <section>
          <header class="major">
            <h2>Entrar em contato</h2>
          </header>
          <ul class="actions">
            <li>
              <a href="#contato" class="button big">Entrar em contato</a>
            </li>
          </ul>
        </section>

        <!-- Footer -->
        <footer id="footer">
          <p class="copyright">
            &copy; 2025 Desenvolvido por | Jonas Fabricio
          </p>
        </footer>
      </div>
    </div>
  </div>

  <!--esconder Menu-->

  <!-- Funções -->
  <script>
    function converterMinusculas() {
      let input = document.getElementById("meuInput");
      input.value = input.value.toLowerCase();
    }

    setTimeout(() => {
      let mensagem = document.getElementById("sos");
      if (mensagem) mensagem.style.display = "none";
    }, 10000);

    $(window).scroll(function() {
      if ($(this).scrollTop() > 60) {
        $(".scroll-aparecer").css({
          opacity: "1",
          height: "60px"
        });
      } else {
        $(".scroll-aparecer").css({
          opacity: "0",
          height: "0"
        });
      }
    });
  </script>

  <div class="scroll-aparecer">
    <a href="#header"><span id="mouse"></span></a>
  </div>

  <!-- Scripts -->

  <script src="assets/js/browser.min.js"></script>
  <script src="assets/js/breakpoints.min.js"></script>
  <script src="assets/js/util.js"></script>
  <script src="assets/js/main.js"></script>

  <style>
    * {
      scroll-behavior: smooth;
    }

    .alt {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 5px;
    }

    .alt p {
      font-size: 20px;
      color: #464646;
    }

    .features i {
      font-size: 50px;
      position: relative;
      top: 12px;
    }

    .scroll-aparecer {
      position: fixed;
      bottom: 20px;
      right: 20px;
      opacity: 0;
      height: 0;
      width: 40px;
      /* necessário */
      overflow: visible;
      z-index: 9999;
      transition: opacity 0.3s ease, height 0.3s ease;
    }

    #mouse {
      display: block;
      width: 22px;
      height: 40px;
      border-radius: 20px;
      border: 4px solid #9851f8;
      margin: 0 auto;
      position: relative;
    }

    #mouse::before {
      content: "";
      display: block;
      width: 4px;
      height: 8px;
      background: #9851f8;
      border-radius: 2px;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      animation: mouse 0.7s infinite alternate;
    }

    @keyframes mouse {
      from {
        top: 8px;
      }

      to {
        top: 14px;
      }
    }

    .mensagem-fixa {
      position: fixed;
      bottom: 10px;
      right: 10px;
      width: 700px;
      padding: 15px;
      color: #fff;
      border-radius: 5px;
      font-size: 14px;
      z-index: 1000;
      box-shadow: 0 0 10px #0003;
    }

    @media (max-width: 700px) {
      .mensagem-fixa {

        width: 300px;

      }
    }
  </style>
</body>

</html>