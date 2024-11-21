<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'meu_banco_de_dados');

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sqlAlter = "DELETE FROM logins WHERE user_name = '$email'";
    $conn->query($sqlAlter);
    // Atualizar o status para inativo
    $sql = "UPDATE usuarios SET status_ativo = 0, ultima_vez_visto = NOW() WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
}
session_destroy(); 
header("Location: ../../LOGIN/login.html?Fazer Login De novo!"); 
exit();
?>
