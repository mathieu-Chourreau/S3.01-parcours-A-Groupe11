<?php
// Connexion à la base de données MySQL
$servername = "lakartxela.iutbayonne.univ-pau.fr"; // Remplacez ceci par votre nom de serveur
$username = "szaza001_bd"; // Remplacez ceci par votre nom d'utilisateur
$password = "szaza001_bd"; // Remplacez ceci par votre mot de passe
$dbname = "szaza001_bd"; // Remplacez ceci par le nom de votre base de données

// Connexion à la base de données avec MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
