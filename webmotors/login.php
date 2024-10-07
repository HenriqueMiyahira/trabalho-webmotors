<?php
session_start();
require 'config.php';
include('header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM usuario WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['tipo'] = $usuario['tipo']; 
            $_SESSION['nome'] = $usuario['nome']; 
            var_dump($_SESSION); 
            
            header('Location: menu.php'); 
            exit();
        } else {
            echo "Email ou senha incorretos.";
        }
    } else {
        echo "Email ou senha incorretos.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>

        <button type="submit">Entrar</button>

        
    <br><br><br> 
    <a> ainda não tem cadastro:  </a>
    <a href="cadastro.php"> CADASTRE-SE </a>
    </form>
</body>
</html>
