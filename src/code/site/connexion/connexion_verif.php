<?php
session_start();
include '../bd.php';

$_SESSION['connecter'] = false;

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    date_default_timezone_set('UTC');
    $dateCreation = date('y-m-d h:i:s');

    $conn = connexionBd();
    $sql = "SELECT mdp, role FROM utilisateur WHERE pseudo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword, $role);
    $stmt->fetch();

    // Vérification du mdp
    if(password_verify($password, $hashedPassword)) {
        if ($role == 1) {
            header("Location: ../backOffice/back_office.php");
            deconnexionBd($stmt);
            deconnexionBd($conn);
            exit;
        }
        deconnexionBd($stmt);
        $sql = "UPDATE utilisateur SET date_connexion = ? WHERE pseudo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss",$dateCreation, $username);
        $stmt->execute();
        $_SESSION['login_username'] = $username;
        $_SESSION['connecter'] = true;
        deconnexionBd($stmt);
        deconnexionBd($conn);
        header("Location: ../index.php");
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
