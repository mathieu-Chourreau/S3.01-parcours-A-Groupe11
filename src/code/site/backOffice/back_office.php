<?php
// Connexion à la base de données
include '../bd.php';
$conn = connexionBd();

// Requête SQL pour sélectionner toutes les colonnes de la table recetteavalider
$sql = "SELECT * FROM recetteavalider";
$result = $conn->query($sql);

// Vérifier s'il y a des résultats
if ($result->num_rows > 0) {
    // Afficher les données de chaque ligne
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. "<br>";
        echo "Nom: " . $row["nom"]. "<br>";
        echo "Description: " . $row["description"]. "<br>";
        echo "Grammage: " . $row["grammage"]. "<br>";
        echo "Temps de préparation: " . $row["tempsPreparation"]. "<br>";
        echo "Difficulté: " . $row["difficulte"]. "<br>";
        echo "Catégorie: " . $row["categorie"]. "<br>";
        
        echo '<form action="traiter_recette.php" method="post">';
        echo '<input type="hidden" name="recette_id" value="' . $row["id"] . '">';
        echo '<input type="hidden" name="nom_recette" value="' . $row["nom"] . '">';
        echo '<input type="submit" name="action" value="Ajouter">';
        echo '<input type="submit" name="action" value="Supprimer">';
        echo '</form>';
        
        echo "<br><br>";
    }
} else {
    echo "0 résultats";
}

// Fermer la connexion à la base de données
$conn->close();
?>
