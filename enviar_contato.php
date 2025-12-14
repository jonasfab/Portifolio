<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include('./dados/db.php');
require './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Lógica para cadastrar no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']); // <- DESTINATÁRIO DO E-MAIL
    $descricao = trim($_POST['descricao']);
    $status = trim($_POST['status']);

    // <<< NOVO → DATA E HORA DO ENVIO >>>
    $dataEnvio = date('Y-m-d H:i:s');

    // Validação simples
    if (empty($nome) || empty($telefone) || empty($email)) {
        $_SESSION['messageErro'] = "Preencha todos os campos obrigatórios.";
        header("Location: ./index.php#contato");
        exit();
    }

    // Inserção no banco
    $sql_insert = "INSERT INTO formularia_contato (nome, telefone, email, descricao, status, dataEnvio) 
                 VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssssss", $nome, $telefone, $email, $descricao, $status, $dataEnvio);

    if ($stmt->execute()) {

        //-------------------------------------------------------
        // BUSCAR E-MAIL E SENHA DE ENVIO NO BANCO
        //-------------------------------------------------------
        $queryEnvio = $conn->query("SELECT email_envio, password FROM email_envio LIMIT 1");
        $dadosEnvio = $queryEnvio->fetch_assoc();
        $email_remetente = $dadosEnvio['email_envio'];
        $senha_remetente = $dadosEnvio['password'];

        //-------------------------------------------------------
        // ENVIAR E-MAIL PARA QUEM PREENCHER O FORMULÁRIO
        // E ENVIAR CÓPIA PARA O REMETENTE
        //-------------------------------------------------------
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $email_remetente;
            $mail->Password   = $senha_remetente;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // Remetente
            $mail->setFrom($email_remetente, 'Formulário de Contato');

            // DESTINATÁRIO → USUÁRIO QUE PREENCHER O FORMULÁRIO
            $mail->addAddress($email, $nome);

            // CÓPIA PARA VOCÊ (remetente)
            $mail->addCC($email_remetente, 'Admin');

            // Assunto
            $mail->isHTML(true);
            $mail->Subject = '📩 Recebemos sua mensagem!';

            // Corpo do email
            $mail->Body = "
        <html>
        <head>
        <style>
            body { font-family: Arial; }
            .card {
                background: #f4f4f7;
                padding: 20px;
                border-radius: 10px;
                max-width: 600px;
                margin: auto;
            }
            h2 { color: #333; }
            p { font-size: 15px; color: #444; }
        </style>
        </head>
        <body>
            <div class='card'>
                <h2>Olá, $nome!</h2>
                <p>Recebemos sua mensagem, em breve retornarei o contato.</p>
                <p><strong>Mensagem enviada:</strong><br/> $descricao</p>
                <p><strong>Telefone informado:</strong> $telefone</p>
                <div class='footer'>&copy; " . date('Y') . " Desenvolvedor | Jonas Fabricio.</div>
            </div>
        </body>
        </html>
        ";

            $mail->AltBody = "Olá $nome.\nRecebemos sua mensagem.\nMensagem: $descricao\nTelefone: $telefone\nStatus: $status";

            $mail->send();
        } catch (Exception $e) {
            $_SESSION['messageErro'] = "Contato enviado, mas ocorreu erro ao enviar e-mail: {$mail->ErrorInfo}";
        }

        //-------------------------------------------------------
        // MENSAGEM DE SUCESSO PARA O USUÁRIO
        //-------------------------------------------------------
        $_SESSION['messagesSucesso'] = "Obrigado ( $nome ) por enviar sua mensagem!<br/>
                                        Enviei uma cópia para o seu e-mail e para o administrador.";
    } else {
        $_SESSION['messageErro'] = "Erro ao enviar mensagem. Tente novamente.";
    }

    header("Location: ./index.php#contato");
    exit();
}
