<?php
session_start();
require 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    die("Acesso negado.");
}

$id = $_POST['id'];
$stmt = $conn->prepare("UPDATE anuncios SET status = 'aprovado' WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

echo "Anúncio aprovado!";
?>