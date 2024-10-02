<form action="anuncios_publicos.php" method="get">
    <select name="status">
        <option value="aprovado">Aprovados</option>
        <option value="pendente">Pendentes</option>
    </select>
    <input type="date" name="data_inicio">
    <input type="date" name="data_fim">
    <input type="text" name="palavra-chave" placeholder="Palavras-chave">
    <button type="submit">Filtrar</button>
</form>

<?php
require 'config.php';

$status = $_GET['status'] ?? 'aprovado';
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';
$palavra_chave = $_GET['palavra-chave'] ?? '';

$query = "SELECT * FROM anuncios WHERE status = ?";
$params = [$status];

if ($data_inicio) {
    $query .= " AND data_criacao >= ?";
    $params[] = $data_inicio;
}

if ($data_fim) {
    $query .= " AND data_criacao <= ?";
    $params[] = $data_fim;
}

if ($palavra_chave) {
    $query .= " AND (titulo LIKE ? OR descricao LIKE ?)";
    $params[] = "%$palavra_chave%";
    $params[] = "%$palavra_chave%";
}

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

while ($anuncio = $result->fetch_assoc()) {
    echo "<h3>{$anuncio['titulo']}</h3>";
    echo "<p>{$anuncio['descricao']}</p>";
    echo "<img src='uploads/{$anuncio['imagem']}' alt='Imagem do anúncio'>";
}
$stmt->close();
?>
