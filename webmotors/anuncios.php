<?php
session_start();
require 'config.php';
include('header.php');

$order = "data_criacao DESC";

if (isset($_GET['ordem'])) {
    switch ($_GET['ordem']) {
        case 'recentes':
            $order = "data_criacao DESC";
            break;
        case 'antigos':
            $order = "data_criacao ASC";
            break;
        case 'az':
            $order = "titulo ASC";
            break;
        case 'za':
            $order = "titulo DESC";
            break;
    }
}

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchTerm = $conn->real_escape_string($searchTerm);
}


$query = "SELECT * FROM anuncio WHERE status = 'aprovado'";

// Adicionar o termo de pesquisa à query, se houver
if (!empty($searchTerm)) {
    $query .= " AND titulo LIKE '%$searchTerm%'";
}

// Adicionar ordenação
$query .= " ORDER BY $order";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros Anunciados</title>
</head>
<body>
    <h1>Carros Anunciados</h1>

    <!-- Barra de Pesquisa -->
    <form method="GET" action="anuncios.php">
        <label for="search">Pesquisar por título:</label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Digite o nome do carro">
        <button type="submit">Pesquisar</button>

        <!-- Filtros de Ordenação -->
        <label for="ordem">Ordenar por:</label>
        <select name="ordem" id="ordem" onchange="this.form.submit()">
            <option value="recentes" <?= isset($_GET['ordem']) && $_GET['ordem'] == 'recentes' ? 'selected' : '' ?>>Mais recentes</option>
            <option value="antigos" <?= isset($_GET['ordem']) && $_GET['ordem'] == 'antigos' ? 'selected' : '' ?>>Mais antigos</option>
            <option value="az" <?= isset($_GET['ordem']) && $_GET['ordem'] == 'az' ? 'selected' : '' ?>>A-Z</option>
            <option value="za" <?= isset($_GET['ordem']) && $_GET['ordem'] == 'za' ? 'selected' : '' ?>>Z-A</option>
        </select>
    </form>

    <!-- Exibição dos anúncios -->
    <table border="1">
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Imagem</th>
            <th>Data de Criação</th>
        </tr>
        <?php
        // Verificar se existem anúncios
        if ($result->num_rows > 0) {
            // Loop pelos anúncios
            while ($anuncio = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$anuncio['titulo']}</td>
                        <td>{$anuncio['descricao']}</td>
                        <td><img src='{$anuncio['imagem']}' alt='Imagem do Anúncio' width='100'></td>
                        <td>{$anuncio['data_criacao']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum anúncio encontrado.</td></tr>";
        }
        ?>
    </table>

    <?php
    // Fechar a conexão com o banco de dados
    $conn->close();
    ?>
</body>
</html>
