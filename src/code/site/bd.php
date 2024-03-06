<?php

function connexionBd() {
    $servername = "localhost:3306/sae3.01";
    $username = "root";
    $password = "";
    $dbname = "sae3.01"; 

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