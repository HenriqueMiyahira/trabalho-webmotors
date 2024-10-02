<html>
<body>
<?php
require('verifica.php');

if ($_SESSION["UsuarioNivel"] != "ADM") echo "<script>alert('Você não é Administrador!');top.location.href='menu.php';</script>"; 

?>

<font size=7 color=red> Entrei no Cadastro - <?php echo $_SESSION["nome_usuario"]; ?></font>
</body>
</html>