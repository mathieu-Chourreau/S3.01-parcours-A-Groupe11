<?php
session_start();
$_SESSION['connecter'] = false;
header("Location: index.php");
?>