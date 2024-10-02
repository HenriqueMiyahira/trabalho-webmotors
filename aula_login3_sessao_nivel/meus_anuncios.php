<?php
session_start();
require 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para ver seus anúncios.");
}

$usuario_id = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT * FROM anuncios WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

while ($anuncio = $result->fetch_assoc()) {
    echo "<h3>{$anuncio['titulo']}</h3>";
    echo "<p>{$anuncio['descricao']}</p>";
    echo "<img src='uploads/{$anuncio['imagem']}' alt='Imagem do anúncio'>";
    echo "<p>Status: {$anuncio['status']}</p>";
    // Links para editar ou deletar anúncios podem ser adicionados aqui
}
$stmt->close();
?>