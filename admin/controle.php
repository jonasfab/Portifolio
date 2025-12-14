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

/* PAGINAÇÃO */
$results_per_page = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

$total_result = $conn->query("SELECT COUNT(*) AS total FROM formularia_contato")->fetch_assoc()['total'];
$total_pages = ceil($total_result / $results_per_page);

if ($page < 1) $page = 1;
if ($page > $total_pages) $page = $total_pages;

$start = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM formularia_contato ORDER BY id DESC LIMIT $start, $results_per_page";
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

    <!-- jQuery (somente 1 vez) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body class="is-preload">

    <!-- Mensagens flutuantes -->
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


    <!-- Wrapper geral -->
    <div id="wrapper">

        <!-- Conteúdo principal -->
        <div id="main">
            <div class="inner">

                <header id="header">
                    <a href="" class="logo"><strong>Olá</strong> - <?= $_SESSION['username'] ?></a>
                </header>

                <section id="contato">
                    <header class="major" id="projeto_sites">
                        <h2>Formulários de Contato</h2>
                    </header>

                    <!-- Tabela com scroll lateral -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Data</th>
                                    <th>Nome</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th>Descrição</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($user = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td>
                                            <?php if ($user['status'] == 1): ?>
                                                <a href="#" class="abrirModal"
                                                    data-nome="<?= htmlspecialchars($user['nome']) ?>"
                                                    data-telefone="<?= htmlspecialchars($user['telefone']) ?>"
                                                    data-email="<?= htmlspecialchars($user['email']) ?>"
                                                    data-descricao="<?= htmlspecialchars($user['descricao']) ?>"
                                                    data-status="<?= $user['status'] ?>"
                                                    data-id="<?= $user['id'] ?>">
                                                    <i class="fa-solid fa-circle-check" style="color:#2ecc71;font-size:20px;"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="#" class="abrirModal"
                                                    data-nome="<?= htmlspecialchars($user['nome']) ?>"
                                                    data-telefone="<?= htmlspecialchars($user['telefone']) ?>"
                                                    data-email="<?= htmlspecialchars($user['email']) ?>"
                                                    data-descricao="<?= htmlspecialchars($user['descricao']) ?>"
                                                    data-status="<?= $user['status'] ?>"
                                                    data-id="<?= $user['id'] ?>">
                                                    <i class="fa-solid fa-circle-exclamation" style="color:#e1b12c;font-size:20px;"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>



                                        <td><?= $user['dataEnvio'] ? date('d/m/Y H:i', strtotime($user['dataEnvio'])) : 'Nunca' ?></td>
                                        <td><?= htmlspecialchars($user['nome']) ?></td>
                                        <td><?= htmlspecialchars($user['telefone']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['descricao']) ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=1">Primeira</a>
                            <a href="?page=<?= $page - 1 ?>">« Anterior</a>
                        <?php endif; ?>

                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);

                        for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?= $page + 1 ?>">Próxima »</a>
                            <a href="?page=<?= $total_pages ?>">Última</a>
                        <?php endif; ?>
                    </div>


                    <!-- Modal -->
                    <div id="meuModal" class="modal-bg" style="
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(2px);
    justify-content:center;
    align-items:center;
">
                        <div class="modal-box" style="
        background:white;
        padding:20px;
        border-radius:10px;
        width:90%;
        max-width:400px;
        box-shadow:0 0 20px rgba(0,0,0,0.3);
    ">
                            <h3>Detalhes</h3>
                            <p><strong>Data:</strong> <span id="modalNome"></span></p>
                            <p><strong>Nome:</strong> <span id="modalNome"></span></p>
                            <p><strong>Telefone:</strong> <span id="modalTelefone"></span></p>
                            <p><strong>E-mail:</strong> <span id="modalEmail"></span></p>
                            <p><strong>Descrição:</strong> <span id="modalDescricao"></span></p>

                            <br>

                            <!-- BOTÕES -->
                            <div style="display:flex; gap:10px; justify-content:flex-end;">
                                <a id="fecharModal" style="
                padding:8px 15px!important;
                background:#2ecc71!important;
                color:white!important;
                border:none!important;
                border-radius:5px!important;
                cursor:pointer!important;">
                                    Fechar
                                </a>

                                <!-- Botão Finalizar (aparece só quando status = 0) -->
                                <a id="btnFinalizar" href="#" style="
                padding:8px 15px;
                background:#2ecc71;
                color:white;
                border:none;
                border-radius:5px;
                cursor:pointer;
                text-decoration:none;
                display:none;">
                                    Finalizar
                                </a>
                            </div>
                        </div>
                    </div>




                    <script>
                        document.querySelectorAll(".abrirModal").forEach(btn => {
                            btn.addEventListener("click", function(e) {
                                e.preventDefault();

                                document.getElementById("modalNome").innerText = this.dataset.nome;
                                document.getElementById("modalTelefone").innerText = this.dataset.telefone;
                                document.getElementById("modalEmail").innerText = this.dataset.email;
                                document.getElementById("modalDescricao").innerText = this.dataset.descricao;

                                const status = this.dataset.status;
                                const id = this.dataset.id;

                                const btnFinalizar = document.getElementById("btnFinalizar");

                                if (status == "0") {
                                    btnFinalizar.style.display = "inline-block";
                                    btnFinalizar.href = "concluir.php?id=" + id;
                                } else {
                                    btnFinalizar.style.display = "none";
                                }

                                document.getElementById("meuModal").style.display = "flex";
                            });
                        });

                        // Fecha o modal
                        document.getElementById("fecharModal").addEventListener("click", () => {
                            document.getElementById("meuModal").style.display = "none";
                        });

                        // Fechar clicando fora da caixa
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
                    <svg width="30" height="30" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="22" fill="url(#gradient-main)" stroke="currentColor" stroke-width="2" />
                        <path d="M16 18L12 24L16 30" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M32 18L36 24L32 30" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                        <path d="M28 16L20 32" stroke="white" stroke-width="2.5" />
                        <defs>
                            <linearGradient id="gradient-main" x1="0" y1="0" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#7823e7" />
                                <stop offset="100%" stop-color="#333" />
                            </linearGradient>
                        </defs>
                    </svg>
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
                            <p
                                style="
                    background-color: #e96060ff;
                    color: white;
                    padding: 2px 8px;
                  ">
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


    <!-- Scripts -->
    <script>
        setTimeout(() => {
            let msg = document.getElementById("sos");
            if (msg) msg.style.display = "none";
        }, 6000);
    </script>


    <!-- CSS COMPLETO -->
    <style>
        /* ====== Correção do layout (sidebar não some) ====== */
        #wrapper {
            display: flex;
            width: 100%;
            overflow: hidden;
            /* impede conteúdo de empurrar o menu */
        }

        #main {
            flex: 1 1 auto;
            min-width: 0;
            /* ESSENCIAL para evitar quebra */
        }

        /* ====== Scroll lateral da tabela ====== */
        .table-container {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            display: block;
            -webkit-overflow-scrolling: touch;
        }

        table {
            border-collapse: collapse;
            min-width: 900px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            white-space: nowrap;
            padding: 8px;
            text-align: left;
        }

        .table-container::-webkit-scrollbar {
            height: 6px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #7823e7;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #ddd;
        }

        /* Paginação */
        .pagination {
            margin-top: 20px;
            display: flex;
            gap: 8px;
        }

        .pagination a {
            padding: 8px 12px;
            background: #ddd;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .pagination a.active {
            background: #7823e7;
            color: #fff;
        }

        /* Mensagem */
        .mensagem-fixa {
            position: fixed;
            bottom: 10px;
            right: 10px;
            width: 280px;
            padding: 12px;
            border-radius: 5px;
            color: #fff;
            z-index: 9999;
        }
    </style>

    <!-- Scripts da sua aplicação (corrigidos para o caminho certo) -->
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>

</body>

</html>