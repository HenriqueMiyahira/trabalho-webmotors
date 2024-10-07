<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}


if (isset($_SESSION['nome'])) {
    $nome_usuario = $_SESSION['nome'];
} else {
    $nome_usuario = "Visitante"; 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema WebMotors</title>
    <style>
        .top-right {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 18px;
        }

        .top-left {
            position: absolute;
            top: 5px;
            left: 840px;
            font-size: 24px;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="top-left">
        <a href="anuncios.php"><strong>WebMotors</strong></a>
    </div>

    <div class="top-right">
        <?php if ($nome_usuario !== "Visitante") : ?>
            Bem-vindo, <a href="menu.php"><?php echo $nome_usuario; ?></a>
        <?php else : ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>
    <hr>
</body>
</html>
