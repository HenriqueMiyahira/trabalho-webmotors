<?php
require('verifica.php'); // Verifica se o usuário está logado
include('header.php'); // Inclui o cabeçalho com nome de usuário e link para a página de anúncios

// Verifica se o nome do usuário está definido na sessão
if (!isset($_SESSION["nome"])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {margin-top: 40px;
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br>
    <!-- Exibe o nome do usuário logado -->
    <font size="7" color="red">Logado como <?php echo $_SESSION["nome"]; ?></font>
    <br><br> 
    <!-- Links para cadastrar anúncios e para ver o relatório dos anúncios -->
    <a href="anuncio.php">Cadastrar</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <br><br> 
    <a href="meus_anuncios.php">Relatório</a>
    <br><br> 
    <a href="gerenciar_anuncios.php">Gerenciar</a>
    <br><br><br> 
    <a href="logout.php">Sair</a>
</body>
</html>
