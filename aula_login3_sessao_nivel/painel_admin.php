<?php
session_start();
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    die("Acesso negado.");
}

$stmt = $conn->prepare("SELECT * FROM anuncios WHERE status = 'pendente'");
$stmt->execute();
$result = $stmt->get_result();

while ($anuncio = $result->fetch_assoc()) {
    echo "<h3>{$anuncio['titulo']}</h3>";
    echo "<form action='aprovar_anuncio.php' method='post'>
            <input type='hidden' name='id' value='{$anuncio['id']}'>
            <button type='submit'>Aprovar</button>
          </form>";
    echo "<form action='rejeitar_anuncio.php' method='post'>
            <input type='hidden' name='id' value='{$anuncio['id']}'>
            <button type='submit'>Rejeitar</button>
          </form>";
}
$stmt->close();
?>