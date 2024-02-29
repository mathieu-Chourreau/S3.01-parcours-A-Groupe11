<?php
// Traitement des données du premier formulaire
if(isset($_POST['name']) && isset($_POST['poid']) && isset($_POST['preparation'])) {
    $nom_recette = $_POST['name'];
    $poids = $_POST['poid'];
    $temps_preparation = $_POST['preparation'];
    
    // Faire quelque chose avec les données du premier formulaire, par exemple :
    echo "Nom de la recette : " . $nom_recette . "<br>";
    echo "Poids : " . $poids . "<br>";
    echo "Temps de préparation : " . $temps_preparation . "<br>";
} else {
    echo "Les données du premier formulaire ne sont pas complètes.";
}

// Traitement des données du deuxième formulaire
if(isset($_POST['difficulte']) && isset($_POST['categorie'])) {
    $difficulte = $_POST['difficulte'];
    $categorie = $_POST['categorie'];
    
    // Faire quelque chose avec les données du deuxième formulaire, par exemple :
    echo "Difficulté : " . $difficulte . "<br>";
    echo "Catégorie : " . $categorie . "<br>";
} else {
    echo "Les données du deuxième formulaire ne sont pas complètes.";
}
?>