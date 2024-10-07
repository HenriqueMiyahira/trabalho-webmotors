<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>
    <form action="cadastro.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>

        <label for="tipo">Tipo de Usuário:</label>
        <select name="tipo" id="tipo" required>
            <option value="comum">Usuário Comum</option>
            <option value="admin">Administrador</option>
        </select><br><br>

        <button type="submit">Cadastrar</button>
    </form>
    <br><br><br> 
    <a> já é cadastrado:  </a>
    <a href="login.php"> LOGUE-SE </a>
</body>
</html>

<?php
require 'config.php'; // Conexão com o banco de dados
include('header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se o campo tipo foi definido
    if (isset($_POST['tipo']) && !empty($_POST['tipo'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo']; // Captura o tipo de usuário selecionado

        // Criptografando a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Preparar a consulta para inserir os dados no banco
        $query = "INSERT INTO usuario (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";

        // Preparar a instrução SQL para evitar SQL Injection
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nome, $email, $senha_hash, $tipo);

        // Executar a consulta e verificar se o usuário foi cadastrado com sucesso
        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
            header('Location: login.php');
            exit();
        } else {
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }

        // Fechar a instrução e a conexão com o banco
        $stmt->close();
        $conn->close();
    } else {
        // Caso o campo "tipo" não tenha sido enviado corretamente
        echo "Por favor, selecione um tipo de usuário.";
    }
}
?>
