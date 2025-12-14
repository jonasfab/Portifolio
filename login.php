<?php
session_start();
include('./dados/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = trim($_POST['email']);  // Remove espaços extras
	$senha = $_POST['senha'];

	// Buscar usuário pelo e-mail exatamente como no banco
	$sql = "SELECT * FROM usuarios WHERE BINARY email = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$usuario = $result->fetch_assoc();

		// Verifica se o usuário está ativo
		if ($usuario['ativo'] == 0) {
			$mensagem = "E-mail desativado! Entre em contato com o administrador.";
		} elseif (password_verify($senha, $usuario['senha'])) {

			// Iniciar sessão e redirecionar para a página principal
			$_SESSION['user_id'] = $usuario['id'];
			$_SESSION['username'] = $usuario['nome'];
			$_SESSION['email'] = $usuario['email'];
			$_SESSION['data_criacao'] = $usuario['data_criacao'];
			$_SESSION['telefone'] = $usuario['telefone'];
			$_SESSION['acesso_admin'] = $usuario['acesso_admin'];
			$_SESSION['acesso_conteudo_1'] = $usuario['acesso_conteudo_1'];
			$_SESSION['acesso_conteudo_2'] = $usuario['acesso_conteudo_2'];
			$_SESSION['acesso_conteudo_3'] = $usuario['acesso_conteudo_3'];
			$_SESSION['acesso_conteudo_4'] = $usuario['acesso_conteudo_4'];
			$_SESSION['acesso_conteudo_5'] = $usuario['acesso_conteudo_5'];

			// Atualizar último login e status
			$sql_update = "UPDATE usuarios SET ultimo_login = NOW(), status = 'logado' WHERE id = ?";
			$stmt_update = $conn->prepare($sql_update);
			$stmt_update->bind_param('i', $usuario['id']);
			$stmt_update->execute();

			header('Location: ./admin/controle.php');
			exit;
		} else {
			$mensagem = "Senha incorreta!";
		}
	} else {
		$mensagem = "E-mail não encontrado!";
	}
}

// Mensagens de sucesso ou erro da sessão
if (isset($_SESSION['messagesSucesso'])) {
	$mensagem2 = $_SESSION['messagesSucesso'];
	unset($_SESSION['messagesSucesso']);
}

if (isset($_SESSION['messageErro'])) {
	$mensagem2 = $_SESSION['messageErro'];
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

	<link rel="shortcut icon" href="./images/logo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	<!-- Script deve ficar AQUI, antes do fechamento do body -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="is-preload">

	<?php if (!empty($mensagem)): ?>
		<div id="sos" style="background-color:#c81aeb;" class="mensagem-fixa">
			<?php echo $mensagem; ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($mensagem2)): ?>
		<div id="sos" style="background-color:rgba(183, 8, 206, 0.92);" class="mensagem-fixa">
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
						<li><a target="_blank" href="https://github.com/jonasfab" class="icon brands fa-github"><span
									class="label">Github</span></a></li>
						<li><a target="_blank" href="https://www.linkedin.com/in/jonas-fabricio-dos-santos-2734b4236/"
								class="icon brands fa-linkedin"><span class="label">linkedin</span></a>
						</li>
					</ul>
				</header>



				<!-- Section -->
				<section id="contato">
					<header class="major" id="projeto_sites">
						<h2>Login</h2>
					</header>

					<form method="post" action="#">
						<div class="row gtr-uniform">

							<div class="col-6 col-12-xsmall">
								<input id="meuInput" oninput="converterMinusculas()" type="email" name="email"
									required placeholder="E-mail">
							</div>

							<div class="col-6 col-12-xsmall">
								<input class="form-control" type="password" id="senha" name="senha" required placeholder="Senha">
							</div>

							<p>Esqueceu a senha? <a href="./esqueci_senha/esqueci_senha.php">Clique aqui.</a></p>

							<!-- Break -->
							<div class="col-12">
								<ul class="actions">
									<li><input type="submit" value="Entrar" class="primary" /></li>
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
						<circle cx="24" cy="24" r="22" fill="url(#gradient-main)" stroke="currentColor"
							stroke-width="2" />
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
						<li><a href="./index.php#habilidades">Habilidades</a></li>
						<li><a href="./index.php#projetos">Projetos</a></li>
						<li><a href="./index.php#contato">Entrar em contato</a></li>
						<li><a href="">Login</a></li>
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
						<li><a href="./index.php#contato" class="button big">Entrar em contato</a></li>
					</ul>
				</section>

				<!-- Footer -->
				<footer id="footer">
					<p class="copyright">&copy; 2025 Desenvolvido por | Jonas Fabricio</p>
				</footer>

			</div>
		</div>

	</div>


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



	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
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
			width: 300px;
			padding: 15px;
			color: #fff;
			border-radius: 5px;
			font-size: 14px;
			z-index: 1000;
			box-shadow: 0 0 10px #0003;
		}
	</style>
</body>

</html>