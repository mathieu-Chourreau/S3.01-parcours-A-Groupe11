<?php

function connexionBd() {
    $servername = "lakartxela.iutbayonne.univ-pau.fr";
    $username = "lferme001_bd";
    $password = "lferme001_bd";
    $dbname = "lferme001_bd"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    return $conn;
}

function deconnexionBd($conn) {
    $conn->close();
}

?>