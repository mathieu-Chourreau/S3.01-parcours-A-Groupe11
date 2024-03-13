<?php

include_once '../bd.php';

$conn = connexionBd();

$recetteValide = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette
        FROM RECETTE r
        JOIN CONTENIR c ON r.identifiant = c.recette_id  
        JOIN INGREDIENT i ON c.ingredient_id = i.nom
        ORDER BY r.identifiant;";

// executer la requete avec la condition
$resultRecette = $conn->query($recetteValide);

// Ajouter l'objet à la liste de Recette
$listeRecette = array();


foreach ($resultRecette as $rec) {
    // recuperer et creer les Ingredients de la recette
    $ingredientDeRecette = "SELECT i.nom as nom_ingr, i.prixKG as prix, ci.categorie as categorie, c.quantite as quantite
                    FROM ingredient i
                    JOIN categorieingredient ci on i.identifiantC = ci.identifiant
                    JOIN contenir c ON i.nom = c.Ingredient_id
                    JOIN recette r ON c.Recette_id = r.identifiant
                    WHERE r.identifiant =" . $rec['identifiant_recette'] . ";";

    $resultIngredient = $conn->query($ingredientDeRecette);

    $listeIngr = array();

    $prix = 0;

    if ($resultIngredient && $resultIngredient->num_rows > 0) {
        while ($row = $resultIngredient->fetch_assoc()) {
            $qte = $row['quantite'];
            if($qte<10){
                $qte = $qte * 0.1;
            }
            if($qte<100 && $qte>=10){
                $qte = $qte * 0.01;
            }
            if($qte<1000 && $qte>=100){
                $qte = $qte * 0.001;
            }

            
            $prix += $row['prix'] * $qte;
            // $nomIngredient = "" . $row['nom_ingr'];
            // $nomIngredient = str_replace(' ', '_', $nomIngredient);
            // $listeIngr[$nomIngredient] = $row['quantite'];
        }
    }

    $listeRecette[$rec['nom_recette']] = $prix;
}

deconnexionBd($conn);


?>