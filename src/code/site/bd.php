<?php
/**
 * @file    bd.php
 * @author  Mathieu,Leo,Nathan,Souleymen
 * @brief   Connexion à la base de donnée
 * @version 0.1
 * @date    17/01/2024
 */

// Connexion à la base de données MySQL

/**
 * @brief   Nom du serveur MySQL
 * @var string
 */
$servername = "lakartxela.iutbayonne.univ-pau.fr";

/**
 * @brief   Nom d'utilisateur pour la connexion MySQL
 * @var string
 */
$username = "mchourreau_bd"; 

/**
 * @brief   Mot de passe pour la connexion MySQL
 * @var string
 */
$password = "mchourreau_bd";

/**
 * @brief   Nom de la base de données MySQL
 * @var string
 */
$dbname = "mchourreau_bd";

// Connexion à la base de données avec MySQLi

/**
 * @brief   Objet de connexion MySQLi
 * @var mysqli
 */
$conn = new mysqli($servername, $username, $password, $dbname);

/**
 * @brief   Vérifie la connexion à la base de données
 * @details Termine le script en cas d'échec de la connexion et affiche un message d'erreur
 */
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
