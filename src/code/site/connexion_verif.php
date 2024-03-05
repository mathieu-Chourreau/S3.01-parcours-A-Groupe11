<?php
session_start();
include 'bd.php';

$_SESSION['connecter'] = false;

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $conn = connexionBd();
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
        deconnexionBd($stmt);
        deconnexionBd($conn);
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['login_username_deco'] = $username;
        deconnexionBd($stmt);
        deconnexionBd($conn);
        header("Location: connexion.php?erreur=1");
        exit;
    }

} else {
    header("Location: connexion.php");
    exit;
}
?>
