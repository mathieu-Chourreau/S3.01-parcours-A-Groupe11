<?php
session_start();
include 'bd.php';

$_SESSION['connecter'] = false;

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    $sql = "SELECT mdp FROM utilisateur WHERE pseudo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    // Vérification du mdp
    if(password_verify($password, $hashedPassword)) {
        $_SESSION['login_username'] = $username;
        $_SESSION['connecter'] = true;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_username_deco'] = $username;
        header("Location: connexion.php?erreur=1");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: connexion.php");
    exit;
}
?>
