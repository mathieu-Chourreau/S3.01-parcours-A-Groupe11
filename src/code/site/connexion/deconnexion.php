<?php
session_start();
//$_SESSION['connecter'] = false;
session_unset();
session_destroy();
header("Location: ../index.php");
?>