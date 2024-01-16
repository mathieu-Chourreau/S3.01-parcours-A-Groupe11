<?php
include 'bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $currentCategory = $_POST['category'];

    echo "Catégorie Actuelle: " . $currentCategory;
    echo "<br><br>";
    // Charger les ingrédients de la nouvelle catégorie
    $sql = "SELECT nom, categorie FROM ingredient JOIN categorieIngredient ON ingredient.identifiantC = categorieIngredient.identifiant WHERE categorie ='{$currentCategory}'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<p id="type_pref">Je n\'en veux pas | Je n\'aime pas | Sans préférence | J\'aime | J\'adore</p>';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="ingredient">';
            echo '<label for="' . $row["nom"] . '">' . $row["nom"] . '</label>';
            echo '<input type="radio" id="'. $row["nom"].'jamais" name="' . $row["nom"] . '" value ="0">';
            echo '<input type="radio" id="'. $row["nom"].'aimePas" name="' . $row["nom"] . '" value ="0.5">';
            echo '<input type="radio" id="'. $row["nom"].'sansPreference" name="' . $row["nom"] . '" value ="1" checked>';
            echo '<input type="radio" id="'. $row["nom"].'aime" name="' . $row["nom"] . '" value ="1.5">';
            echo '<input type="radio" id="'. $row["nom"].'adore" name="' . $row["nom"] . '" value ="2">';
            echo '</div>';
        }
    } else {
        echo "Aucun ingrédient trouvé";
    }

    $conn->close();
} else {
    echo "Erreur : catégorie non spécifiée";
}

?>