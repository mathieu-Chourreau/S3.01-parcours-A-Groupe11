<?php
// Connexion à la base de données MySQL
$servername = ""; // Remplacez ceci par votre nom de serveur
$username = "szaza001_bd"; // Remplacez ceci par votre nom d'utilisateur
$password = "szaza001_bd"; // Remplacez ceci par votre mot de passe
$dbname = "szaza001_bd"; // Remplacez ceci par le nom de votre base de données

// Connexion à la base de données avec MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}


/*
// Connexion à la base de données MySQL
$servername = "localhost:3306/sae3.01"; // Remplacez ceci par votre nom de serveur
$username = "root"; // Remplacez ceci par votre nom d'utilisateur
$password = ""; // Remplacez ceci par votre mot de passe
$dbname = "sae3.01"; // Remplacez ceci par le nom de votre base de données
*/

?>