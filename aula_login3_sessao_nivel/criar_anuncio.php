<form action="criar_anuncio.php" method="post" enctype="multipart/form-data">
    <input type="text" name="titulo" placeholder="Título" required>
    <textarea name="descricao" placeholder="Descrição" required></textarea>
    <input type="file" name="imagem" accept="image/*" required>
    <button type="submit">Criar Anúncio</button>
</form>

<?php
session_start();
require 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Você precisa estar logado para criar anúncios.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $usuario_id = $_SESSION['usuario_id'];
    
    // Processar a imagem
    $imagem = $_FILES['imagem'];
    $imagem_nome = time() . '_' . $imagem['name'];
    move_uploaded_file($imagem['tmp_name'], "uploads/$imagem_nome");
    
    $stmt = $conn->prepare("INSERT INTO anuncios (titulo, descricao, imagem, usuario_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $descricao, $imagem_nome, $usuario_id);
    $stmt->execute();
    $stmt->close();
    
    echo "Anúncio criado com sucesso!";
}
?>