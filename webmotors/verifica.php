<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['tipo'])) {
    header('Location: login.php');
    exit();
}
?>
