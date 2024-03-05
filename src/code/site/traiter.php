<?php
include 'bd.php'; 
if(isset($_POST['nom']) && isset($_POST['poid']) && isset($_POST['description']) && isset($_POST['tpsPreparation']) && isset($_POST['difficulte']) && isset($_POST['categorie'])) {
    $nom = $_POST['nom'];
    $poids = intval($_POST['poid']);
    $temps_preparation = intval($_POST['tpsPreparation']);
    $description = $_POST['description'];
    $difficulte = $_POST['difficulte'];
    $categorie = $_POST['categorie'];

    $conn = connexionBd();
    $resultat = $conn->query("SELECT MAX(id) AS max_id FROM recetteAValider");
    $row = $resultat->fetch_assoc();
    $prochain_id = $row['max_id'] + 1;  
    
    $requete = $conn->prepare("INSERT INTO recetteAValider (id, nom, description, grammage, tempsPreparation, difficulte, categorie) VALUES (?, ?, ?, ?,?,?,?)");

    if ($requete === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $requete->bind_param("issiiss", $prochain_id, $nom, $description, $poid, $temps_preparation, $difficulte, $categorie);


    $requete->execute();

    if ($requete->affected_rows > 0) {
        echo "Données insérées avec succès.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $requete->error;
    }
    deconnexionBd($conn);

} else {
    echo "Les données du formulaire ne sont pas complètes.";
}
?>