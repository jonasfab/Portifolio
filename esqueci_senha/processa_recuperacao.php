<?php
session_start();
include('../dados/db.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Verifica se o e-mail existe
    $sql = "SELECT id, nome FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['messageErro'] = "E-mail não encontrado!";
        header("Location: esqueci_senha.php");
        exit;
    }

    $usuario = $result->fetch_assoc();
    $user_id = $usuario['id'];
    $nome = $usuario['nome'];

    // Verifica se já existe um token válido para esse usuário
    $sql_token_existente = "SELECT * FROM reset_senhas WHERE user_id = ? AND expira_em > NOW()";
    $stmt_token_existente = $conn->prepare($sql_token_existente);
    $stmt_token_existente->bind_param("i", $user_id);
    $stmt_token_existente->execute();
    $result_token_existente = $stmt_token_existente->get_result();

    if ($result_token_existente->num_rows > 0) {
        $_SESSION['messageErro'] = "Um link de redefinição de senha já foi enviado para este e-mail. Verifique sua caixa de entrada.";
        header("Location: esqueci_senha.php");
        exit;
    }

    // Criar token único e salvar no banco
    $token = bin2hex(random_bytes(32));
    $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $sql_token = "INSERT INTO reset_senhas (user_id, token, expira_em) VALUES (?, ?, ?) 
                  ON DUPLICATE KEY UPDATE token=?, expira_em=?";
    $stmt_token = $conn->prepare($sql_token);
    $stmt_token->bind_param("issss", $user_id, $token, $expira, $token, $expira);
    $stmt_token->execute();

    // Configuração do remetente
    $queryEnvio = $conn->query("SELECT email_envio, password FROM email_envio LIMIT 1");
    $dadosEnvio = $queryEnvio->fetch_assoc();
    $email_remetente = $dadosEnvio['email_envio'];
    $senha_remetente = $dadosEnvio['password'];

    // Montar link de redefinição
    $link = "http://localhost/Portif%C3%B3lio/recuperacao_nova_senha/recuperacao_nova_senha.php?token=$token";

    // Envio de e-mail
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

        $mail->setFrom($email_remetente, 'Recuperação de Senha');
        $mail->addAddress($email, $nome);
        $mail->isHTML(true);
        $mail->Subject = 'Redefinição de Senha';

        // Corpo do e-mail profissional
        $mail->Body = "
        <html>
        <head>
      <style>
    body { 
        font-family: Arial, sans-serif; 
        background-color:#f4f4f7; 
        padding:0; margin:0; 
    }
    .container { 
        max-width:600px; 
        margin:50px auto; 
        background:#fff; 
        padding:30px; 
        border-radius:10px; 
        box-shadow:0 2px 10px rgba(0,0,0,0.1); 
        text-align: center; /* centraliza conteúdo */
    }
    h2 { 
        color:#333; 
    }
    p { 
        color:#555; 
        font-size:16px; 
        line-height:1.5; 
    }
    .btn { 
        display:inline-block; 
        padding:12px 25px; 
        margin:20px auto; /* margem automática centraliza horizontalmente */
        font-size:16px; 
        color:#fff; 
        background-color:#007BFF; 
        text-decoration:none; 
        border-radius:5px; 
    }
    .footer { 
        font-size:12px; 
        color:#999; 
        text-align:center; 
        margin-top:30px; 
    }
</style>

        </head>
        <body>
            <div class='container'>
                <h2>Olá, $nome!</h2>
                <p>Recebemos uma solicitação para redefinir sua senha.</p>
                <p>Clique no botão abaixo para criar uma nova senha. Este link é válido por 1 hora.</p>
                <a href='$link' class='btn'>CRIAR NOVA SENHA</a>
                <p>Se você não solicitou esta ação, ignore este e-mail.</p>
                <div class='footer'>&copy; " . date('Y') . " Desenvolvedor | Jonas Fabricio.</div>
            </div>
        </body>
        </html>
        ";
        $mail->AltBody = "Olá, $nome! Recebemos uma solicitação para redefinir sua senha. Use o link a seguir (válido por 1 hora): $link";

        $mail->send();
        $_SESSION['messagesSucesso'] = "Um link de recuperação foi enviado para seu e-mail.";
    } catch (Exception $e) {
        $_SESSION['messageErro'] = "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }

    header("Location: esqueci_senha.php");
    exit;
}
