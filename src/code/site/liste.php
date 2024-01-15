<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferences'][$nomIngredient] = $valeur;
    }

    echo "<h2>Préférences des ingrédients (depuis la session) :</h2>";
    echo "<ul>";
    foreach ($_SESSION['ingredientsPreferences'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>
