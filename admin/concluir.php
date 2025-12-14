<?php
session_start();
include('../dados/db.php');

// Verifica se recebeu um ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['messageErro'] = "ID inválido!";
    header("Location: controle.php");
    exit;
}

$id = intval($_GET['id']);

// Atualizar o status para 1
$sql = "UPDATE formularia_contato SET status = 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['messagesSucesso'] = "Contato finalizado com sucesso!";
} else {
    $_SESSION['messageErro'] = "Erro ao finalizar o contato.";
}

$stmt->close();
$conn->close();

// Redireciona de volta
header("Location: controle.php");
exit;
