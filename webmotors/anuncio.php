<?php
require 'config.php'; 
require 'verifica.php';
include('header.php');


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem'];

    $status = 'pendente';

    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($imagem['name']);

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($imagem['tmp_name'], $upload_file)) {
        $query = "INSERT INTO anuncio (titulo, descricao, imagem, status, usuario_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $usuario_id = $_SESSION['user_id'];

        $stmt->bind_param("ssssi", $titulo, $descricao, $upload_file, $status, $usuario_id);

        if ($stmt->execute()) {
            echo "Anúncio criado com sucesso! O status do anúncio é 'pendente'.";
        } else {
            echo "Erro ao criar anúncio: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}

$query = "SELECT * FROM anuncio WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Anúncios</title>
</head>
<body>
    <h1>Cadastrar Anúncio</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>
        <br>
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required></textarea>
        <br>
        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" accept="image/*" required>
        <br>
        <button type="submit">Criar Anúncio</button>
    </form>

    <h2>Meus Anúncios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Imagem</th>
            <th>Status</th>
        </tr>
        <?php

        while ($anuncio = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$anuncio['id']}</td>
                    <td>{$anuncio['titulo']}</td>
                    <td>{$anuncio['descricao']}</td>
                    <td><img src='{$anuncio['imagem']}' alt='Imagem do Anúncio' width='100'></td>
                    <td>{$anuncio['status']}</td>
                  </tr>";
        }
        ?>
    </table>

    <?php

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
