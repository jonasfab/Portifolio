<?php
session_start();
include('../dados/db.php');

if (!isset($_POST['id'])) {
    $_SESSION['messageErro'] = "Erro: dados incompletos.";
    header("Location: email.php");
    exit;
}

$id = $_POST['id'];
$email = $_POST['email_envio'];
$pass = $_POST['password'];

$sql = "UPDATE email_envio SET email_envio=?, password=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $email, $pass, $id);

if ($stmt->execute()) {
    $_SESSION['messagesSucesso'] = "Dados atualizados com sucesso!";
} else {
    $_SESSION['messageErro'] = "Erro ao atualizar.";
}

header("Location: email.php");
exit;
