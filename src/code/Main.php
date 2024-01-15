<?php

// Include des classes Recette et Ingredient
include 'Recette.php';
include 'Ingredient.php';

// Création d'une recette
$recette = new Recette("poulet", 10.5, "facile", "sucre", 25);

// Création d'ingrédients
$ingredient1 = new Ingredient("Poulet", 10, "viandeBlanche");
$ingredient2 = new Ingredient("fritte", 2, "Autre");

// Liaison des ingrédients à la recette
$recette->ajouterIngredient($ingredient1, 10);
$recette->ajouterIngredient($ingredient2, 5);

// Affichage des détails de la recette
echo "Nom de la recette: " . $recette->getNom() . "<br>";

echo "Temps de préparation: " . $recette->getTemps() . "<br>";
echo "Difficulté: " . $recette->getDifficulte() . "<br>";
echo "Catégorie: " . $recette->getCategorie() . "<br>";
echo "Prix: " . $recette->getPrix() . "<br>";

// Affichage des ingrédients de la recette
echo "<br>Ingrédients de la recette:<br>";
foreach ($recette->getMesIngredients() as $pair) {
    echo $pair[0]->getNom() . " - Quantité(g): " . $pair[1] . "<br>";
}

echo "<br> Recette de poulet:<br>";
foreach ($ingredient1->getLesRecette() as $rec) {
    echo $rec->getNom() . "<br>";
}

$ingredient1->retirerRecette($recette);
echo $ingredient1->retirerRecette($recette) . "<br>";

foreach ($recette->getMesIngredients() as $pair) {
    echo $pair[0]->getNom() . " - Quantité(g): " . $pair[1] . "<br>";
}

echo "<br> Recette de poulet:<br>";
foreach ($ingredient1->getLesRecette() as $rec) {
    echo $rec->getNom() . "<br>";
}

?>