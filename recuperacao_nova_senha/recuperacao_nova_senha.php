<?php
include('../dados/db.php');
session_start();

if (!isset($_GET['token'])) {
	die("Token inválido.");
}

$token = $_GET['token'];
$mensagem = "";


// Verifica se o token existe e ainda é válido
$sql_token = "SELECT * FROM reset_senhas WHERE token = ? AND expira_em > NOW()";
$stmt_token = $conn->prepare($sql_token);
$stmt_token->bind_param("s", $token);
$stmt_token->execute();
$result_token = $stmt_token->get_result();

if ($result_token->num_rows === 0) {
	die("Token inválido ou expirado.");
}

$reset = $result_token->fetch_assoc();
$user_id = $reset['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$nova_senha = trim($_POST['senha']);
	$confirmar_senha = trim($_POST['confirmar_senha']);

	if ($nova_senha !== $confirmar_senha) {
		$mensagem = "As senhas não são idênticas! Tente novamente.";
	} elseif (strlen($nova_senha) < 8) {
		$mensagem = "A senha deve ter pelo menos 8 caracteres.";
	} elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/', $nova_senha)) {
		$mensagem = "A senha deve conter ao menos uma letra, número e um caractere especial.";
	} else {
		$senha_cripto = password_hash($nova_senha, PASSWORD_DEFAULT);

		$sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";
		$stmt_update = $conn->prepare($sql_update);
		$stmt_update->bind_param("si", $senha_cripto, $user_id);

		if ($stmt_update->execute()) {
			// Opcional: deletar o token após uso
			$sql_delete = "DELETE FROM reset_senhas WHERE token = ?";
			$stmt_delete = $conn->prepare($sql_delete);
			$stmt_delete->bind_param("s", $token);
			$stmt_delete->execute();

			$_SESSION['messagesSucesso'] = "Senha Alterada com sucesso! Faça login.";
			header('Location: ../login.php');
			exit;
		} else {
			$mensagem = "Erro ao alterar a senha. Tente novamente.";
		}
	}
}

// Mensagens de sucesso ou erro

$mensagem2 = '';

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
	<title>Portfólio | nome usuario</title>
	<link rel="stylesheet" href="../assets/css/styles11.css" />

	<link rel="shortcut icon" href="../images/logo.png">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	<!-- jQuery (somente 1 vez) -->
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
					<a href="index.html" class="logo"><strong>nome usuario </strong>- Desenvolvedor Web</a>
					<ul class="icons">
						<li><a target="_blank" href="https://github.com/jonasfab" class="icon brands fa-github"><span
									class="label">Github</span></a></li>
						<li><a target="_blank" href="https://www.linkedin.com/in/jonas-fabricio-dos-santos-2734b4236/"
								class="icon brands fa-linkedin"><span class="label">linkedin</span></a>
						</li>
						<li><a target="_blank" href="https://www.instagram.com/jonasfab.dossantos.5/"
								class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
					</ul>
				</header>



				<!-- Section -->
				<section id="contato">
					<header class="major" id="projeto_sites">
						<h2>Nova Senha</h2>
					</header>

					<p>Defina uma nova senha para acessar.<br>
						A senha deve conter no mínimo 8 caracteres e incluir letra, número e um caractere especial.</p>

					<form method="post" action="#">
						<div class="row gtr-uniform">


							<div class="col-6 col-12-xsmall input-group" style="display: flex; align-items: center; position: relative;">
								<input type="password" id="senha1" name="senha" required onpaste="return false" placeholder="Nova Senha">
								<a style="position: absolute; right: 5px; top: 30px; cursor: pointer;" id="toggleSenha1">👁</a>
							</div>

							<script>
								document.getElementById('toggleSenha1').addEventListener('click', function() {
									var senhaInput = document.getElementById('senha1');
									senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
								});
							</script>



							<div class="col-6 col-12-xsmall input-group" style="display: flex; align-items: center; position: relative;">
								<input type="password" id="senha2" name="confirmar_senha" onpaste="return false" placeholder="Confirmar Senha">
								<a style="position: absolute; right: 5px; top: 30px; cursor: pointer;" id="toggleSenha2">👁</a>
							</div>
							<script>
								document.getElementById('toggleSenha2').addEventListener('click', function() {
									var senhaInput = document.getElementById('senha2');
									senhaInput.type = senhaInput.type === 'password' ? 'text' : 'password';
								});
							</script>


							<!-- Break -->
							<div class="col-12">
								<ul class="actions">
									<li><input type="submit" value="Salvar" class="primary" /></li>
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
						<li><a href="../index.html#habilidades">Habilidades</a></li>
						<li><a href="../index.html#projetos">Projetos</a></li>
						<li><a href="../index.html#contato">Entrar em contato</a></li>
						<li><a href="../login.php">Login</a></li>
					</ul>
				</nav>


				<!-- Section -->
				<section>
					<header class="major">
						<h2>Layout</h2>
					</header>
					<div class="mini-posts">
						<article>
							<a class="image"><img src="../images/pic00.png" alt="" /></a>
							<p>Design em Desktop e Notebook.</p>
						</article>
						<article>
							<a class="image"><img src="../images/pic01.png" alt="" /></a>
							<p>Design em Tablets.</p>
						</article>
						<article>
							<a class="image"><img src="../images/pic02.png" alt="" /></a>
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
						<li><a href="./index.html#contato" class="button big">Entrar em contato</a></li>
					</ul>
				</section>

				<!-- Footer -->
				<footer id="footer">
					<p class="copyright">&copy; 2025 Desenvolvido por | nome usuario</p>
				</footer>

			</div>
		</div>

	</div>





	<!-- Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/browser.min.js"></script>
	<script src="../assets/js/breakpoints.min.js"></script>

	<script src="../assets/js/main.js"></script>


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

	<style>
		* {
			scroll-behavior: smooth;
		}

		.alt {


			display: flex;
			justify-content: center;
			align-items: center;
			gap: 6px;
		}

		.alt p {
			font-size: 20px;
			color: #444;
		}

		.features i {
			font-size: 50px;
			position: relative;
			top: 12px;
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