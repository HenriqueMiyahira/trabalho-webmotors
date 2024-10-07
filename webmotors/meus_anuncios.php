<?php
require 'config.php';
require 'verifica.php';
include('header.php');

$usuario_id = $_SESSION['user_id'];

$query = "SELECT * FROM anuncio WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h2>Relátorio</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Imagem</th>
                <th>Status</th>
                <th>Data de Criação</th>
            </tr>";


    while ($anuncio = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$anuncio['id']}</td>
                <td>{$anuncio['titulo']}</td>
                <td>{$anuncio['descricao']}</td>
                <td><img src='{$anuncio['imagem']}' alt='Imagem do Anúncio' width='100'></td>
                <td>{$anuncio['status']}</td>
                <td>{$anuncio['data_criacao']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<h2>Você ainda não cadastrou nenhum anúncio.</h2>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Anúncios</title>
</head>
<body>
</body>
</html>
