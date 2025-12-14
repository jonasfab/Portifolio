<?php
include('../dados/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Mensagens
if (isset($_SESSION['messagesSucesso'])) {
    $mensagem2 = $_SESSION['messagesSucesso'];
    unset($_SESSION['messagesSucesso']);
}
if (isset($_SESSION['messageErro'])) {
    $mensagem = $_SESSION['messageErro'];
    unset($_SESSION['messageErro']);
}

$sql = "SELECT * FROM email_envio ORDER BY id DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <title>Painel Admin</title>

    <link rel="stylesheet" href="../assets/css/styles11.css" />
    <link rel="shortcut icon" href="../images/logo.png">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body class="is-preload">

    <!-- Mensagens -->
    <?php if (!empty($mensagem)): ?>
        <div id="sos" class="mensagem-fixa" style="background:#ee5252;">
            <?= $mensagem ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensagem2)): ?>
        <div id="sos" class="mensagem-fixa" style="background:#32be39;">
            <?= $mensagem2 ?>
        </div>
    <?php endif; ?>



    <div id="wrapper">

        <div id="main">
            <div class="inner">

                <header id="header">
                    <a href="" class="logo"><strong>Olá</strong> - <?= $_SESSION['username'] ?></a>
                </header>

                <section id="contato">
                    <header class="major">
                        <h2>Controle de E-mail</h2>
                    </header>

                    <div class="table-container">

                        <?php while ($user = $result->fetch_assoc()) { ?>

                            <label>E-mail:</label>
                            <div class="col-6 col-12-xsmall">
                                <input type="text" value="<?= htmlspecialchars($user['email_envio']) ?>" readonly>
                            </div>
                            <br>

                            <label>Senha de 16 caracteres:</label>
                            <div class="col-6 col-12-xsmall">
                                <input type="text" value="<?= htmlspecialchars($user['password']) ?>" readonly>
                            </div>

                            <br>

                            <a href="#"
                                class="abrirModal"
                                data-id="<?= $user['id'] ?>"
                                data-email="<?= htmlspecialchars($user['email_envio']) ?>"
                                data-pass="<?= htmlspecialchars($user['password']) ?>"
                                style="color:#007bff; text-decoration:underline; cursor:pointer;">
                                Editar
                            </a>

                            <hr><br>

                        <?php } ?>

                    </div>


                    <!-- MODAL DE EDIÇÃO -->
                    <div id="meuModal" class="modal-bg" style="
                        display:none;
                        position:fixed;
                        top:0; left:0;
                        width:100%; height:100%;
                        background:rgba(0,0,0,0.6);
                        backdrop-filter:blur(2px);
                        justify-content:center;
                        align-items:center;
                        z-index:9999;
                    ">
                        <div class="modal-box" style="
                            background:white;
                            padding:20px;
                            border-radius:10px;
                            width:90%;
                            max-width:400px;
                            box-shadow:0 0 20px rgba(0,0,0,0.3);
                        ">

                            <h3>Editar Dados de Envio</h3>
                            <br>

                            <form method="POST" action="atualizar_email.php">

                                <input type="hidden" name="id" id="modalId">

                                <label>Email:</label>
                                <input type="text" name="email_envio" id="modalEmail" required>

                                <label>Senha de App (16 caracteres):</label>
                                <input type="text" name="password" id="modalPass" required>

                                <br><br>

                                <div style="display:flex; gap:10px; justify-content:flex-end;">
                                    <button type="button" id="fecharModal" style="
                                        padding:8px 15px;
                                        background:#777;
                                        color:white;
                                        border:none;
                                        border-radius:5px;
                                        cursor:pointer;">
                                        Cancelar
                                    </button>

                                    <button type="submit" style="
                                        padding:8px 15px;
                                        background:#2ecc71;
                                        color:white;
                                        border:none;
                                        border-radius:5px;
                                        cursor:pointer;">
                                        Salvar
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>


                    <script>
                        document.querySelectorAll(".abrirModal").forEach(btn => {
                            btn.addEventListener("click", function(e) {
                                e.preventDefault();

                                document.getElementById("modalId").value = this.dataset.id;
                                document.getElementById("modalEmail").value = this.dataset.email;
                                document.getElementById("modalPass").value = this.dataset.pass;

                                document.getElementById("meuModal").style.display = "flex";
                            });
                        });

                        document.getElementById("fecharModal").addEventListener("click", () => {
                            document.getElementById("meuModal").style.display = "none";
                        });

                        document.getElementById("meuModal").addEventListener("click", function(e) {
                            if (e.target === this) {
                                this.style.display = "none";
                            }
                        });
                    </script>

                </section>
            </div>
        </div>


        <!-- Sidebar -->
        <div id="sidebar">
            <div class="inner">

                <section class="alt">
                    <p>Painel Admin</p>
                </section>

                <nav id="menu">
                    <header class="major">
                        <h2>Menu</h2>
                    </header>
                    <ul>
                        <li><a href="./controle.php">Formulários de Contato</a></li>
                        <li><a href="./email.php">Controle de e-mail</a></li>
                        <li>
                            <p style="background-color: #e96060; color: white; padding: 2px 8px;">
                                <a href="../dados/logout.php">Sair</a>
                            </p>
                        </li>
                    </ul>
                </nav>

                <footer id="footer">
                    <p class="copyright">&copy; 2025 Desenvolvido por | Usuário</p>
                </footer>

            </div>
        </div>


    </div>


    <style>
        /* Layout */
        #wrapper {
            display: flex;
            width: 100%;
            overflow: hidden;
        }

        #main {
            flex: 1 1 auto;
            min-width: 0;
        }

        .table-container {
            width: 100%;
        }

        .mensagem-fixa {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 280px;
            padding: 12px;
            border-radius: 5px;
            color: #fff;
            z-index: 99999;
        }
    </style>

    <script>
        setTimeout(() => {
            let msg = document.getElementById("sos");
            if (msg) msg.style.display = "none";
        }, 6000);
    </script>

</body>

</html>