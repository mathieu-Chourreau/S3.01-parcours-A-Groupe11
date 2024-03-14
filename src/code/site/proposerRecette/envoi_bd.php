<?php
session_start();
include '../bd.php'; 
if(isset($_SESSION['nom']) && isset($_SESSION['Instruction']) && isset($_SESSION['tpsPreparation']) && isset($_SESSION['difficulte']) && isset($_SESSION['ingredients'])) {
    $nom = $_SESSION['nom'];
    $temps_preparation = $_SESSION['tpsPreparation'];
    $description = $_SESSION['Instruction'];
    $difficulte = $_SESSION['difficulte'];
    $ingredients = $_SESSION['ingredients']; 

    $conn = connexionBd();
    $resultat = $conn->query("SELECT MAX(id) AS max_id FROM recetteAValider");
    $row = $resultat->fetch_assoc();
    $prochain_id = $row['max_id'] + 1;  
    
    $requete = $conn->prepare("INSERT INTO recetteAValider (id, nom, description, tempsPreparation, difficulte) VALUES (?, ?,?,?,?)");

    if ($requete === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $requete->bind_param("issis", $prochain_id, $nom, $description, $temps_preparation, $difficulte);
    
    $requete->execute();

    foreach ($_SESSION['ingredients'] as $ingredient) {
        $ingredientSA = str_replace(" ", "-", $ingredient);
        $grammage = $_POST['grammage_' . $ingredientSA];
        $stmt = $conn->prepare("INSERT INTO contenirAValider (Ingredient_id, Recette_id, quantite) VALUES (?, ?,?)");
        $stmt->bind_param("sii", $ingredient, $prochain_id, $grammage);
        $stmt->execute();
    }

    if ($requete->affected_rows > 0) {
        echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
    } else {
        echo "Erreur lors de l'insertion des données : " . $requete->error;
        deconnexionBd($conn);
    }
    deconnexionBd($conn);


    } else {
        echo "Les données du formulaire ne sont pas complètes.";
    }
?>