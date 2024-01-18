<?php
include 'bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $currentCategory = $_POST['category'];

    echo "Catégorie Actuelle: " . $currentCategory;
    echo "<br><br>";

    // Liste pour stocker les noms d'ingrédients et les valeurs des boutons radio
    $ingredientsList = array();

    // Charger les ingrédients de la nouvelle catégorie
    $sql = "SELECT nom, categorie FROM ingredient JOIN categorieIngredient ON ingredient.identifiantC = categorieIngredient.identifiant WHERE categorie ='{$currentCategory}'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '<p id="type_pref">Je n\'en veux pas | Je n\'aime pas | Sans préférence | J\'aime | J\'adore</p>';
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="ingredient" data-nom="' . $row["nom"] . '">';
                    echo '<label for="' . $row["nom"] . '">' . $row["nom"] . '</label>';
                    echo '<input type="radio" name="' . $row["nom"] . '" value="0">';
                    echo '<input type="radio" name="' . $row["nom"] . '" value="0.5">';
                    echo '<input type="radio" name="' . $row["nom"] . '" value="1" checked>';
                    echo '<input type="radio" name="' . $row["nom"] . '" value="1.5">';
                    echo '<input type="radio" name="' . $row["nom"] . '" value="2">';
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
