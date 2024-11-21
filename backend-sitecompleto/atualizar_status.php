<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
$conn = new mysqli('localhost', 'root', '', 'meu_banco_de_dados');

// Verifica se o usuário está logado
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    
    $sql = "UPDATE usuarios SET status_ativo = 0, ultima_vez_visto = NOW() WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['sucesso' => true, 'mensagem' => 'Status atualizado']);

    } else {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar status']);
    }

    $stmt->close();
}
$conn->close();
?>
