<?php

session_start();
session_unset();
session_destroy();
echo "<script>alert('Voc� saiu!');top.location.href='login.php';</script>";
?>