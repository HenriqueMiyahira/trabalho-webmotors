<?php 
// Inicia sess�es 
session_start(); 

// Verifica se existe os dados da sess�o de login 
if(!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) 
{ 
// Usu�rio n�o logado! Redireciona para a p�gina de login 
header("Location: login.php"); 
exit; 
} 
?> 