<?php
require 'config.php'; 
require 'verifica.php'; 
include('header.php');

if ($_SESSION['tipo'] !== 'admin') {
    header('Location: menu.php'); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $anuncio_id = $_POST['anuncio_id'];
    $acao = $_POST['acao'];

    $novo_status = ($acao === 'aprovar') ? 'aprovado' : 'rejeitado';

    $query = "UPDATE anuncio SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $novo_status, $anuncio_id);

    if ($stmt->execute()) {
        echo "Anúncio atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar anúncio: " . $stmt->error;
    }

    $stmt->close();
}

$query = "SELECT * FROM anuncio WHERE status = 'pendente'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Anúncios</title>
</head>
<body>
    <h1>Gerenciar Anúncios</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        <?php
        while ($anuncio = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$anuncio['id']}</td>
                    <td>{$anuncio['titulo']}</td>
                    <td>{$anuncio['descricao']}</td>
                    <td><img src='{$anuncio['imagem']}' alt='Imagem do Anúncio' width='100'></td>
                    <td>
                        <form method='POST'>
                            <input type='hidden' name='anuncio_id' value='{$anuncio['id']}'>
                            <button type='submit' name='acao' value='aprovar'>Aprovar</button>
                            <button type='submit' name='acao' value='rejeitar'>Rejeitar</button>
                        </form>
                    </td>
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
