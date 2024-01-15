<?php

session_start();

if (!isset($_SESSION['ingredientsPreferencesPageSale'])) {
    $_SESSION['ingredientsPreferencesPageSale'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferencesPageSale'][$nomIngredient] = $valeur;
    }

    echo "<h2>Préférences des ingrédients (depuis la session) :</h2>";
    echo "<ul>";
    foreach ($_SESSION['ingredientsPreferences'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
    echo "<h2>Préférences des ingrédients (Page Sale) :</h2>";
    echo "<ul>";
    foreach ($_SESSION['ingredientsPreferencesPageSale'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
