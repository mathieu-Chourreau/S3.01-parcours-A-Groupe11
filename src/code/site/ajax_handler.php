<?php
include 'bd.php';
session_start();

// Initialisation de $_SESSION['preferences'] si elle n'existe pas encore
if (!isset($_SESSION['preferences'])) {
    $_SESSION['preferences'] = array();
}

// Vérifier la catégorie reçue
if (isset($_POST['category'])) {
    $currentCategory = $_POST['category'];

    // Vérifiez si la session existe
    if (isset($_SESSION['preferences'])) {
        // Vérifiez si les préférences de cette catégorie existent pour l'utilisateur
        if (isset($_SESSION['preferences'][$currentCategory]) && !empty($_SESSION['preferences'][$currentCategory])) {
            $userPreferences = $_SESSION['preferences'][$currentCategory];

            // Charger les ingrédients de la nouvelle catégorie
            $sql = "SELECT nom, categorie FROM ingredient JOIN categorieIngredient ON ingredient.identifiantC = categorieIngredient.identifiant WHERE categorie ='{$currentCategory}'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ingredientName = $row["nom"];

                    // Initialiser $preferenceValue à une valeur par défaut (par exemple, 1)
                    $preferenceValue = isset($userPreferences[$ingredientName]) ? $userPreferences[$ingredientName] : 1;

                    echo '<div class="ingredient" data-nom="' . $ingredientName . '">';
                    echo '<label for="' . $ingredientName . '">' . $ingredientName . '</label>';

                    // Génération des boutons radio en utilisant $preferenceValue pour déterminer quel bouton est coché
                    echo '<input type="radio" name="' . $ingredientName . '" value="0" ' . ($preferenceValue == 0 ? 'checked' : '') . '>';
                    echo '<input type="radio" name="' . $ingredientName . '" value="0.5" ' . ($preferenceValue == 0.5 ? 'checked' : '') . '>';
                    echo '<input type="radio" name="' . $ingredientName . '" value="1" ' . ($preferenceValue == 1 ? 'checked' : '') . '>';
                    echo '<input type="radio" name="' . $ingredientName . '" value="1.5" ' . ($preferenceValue == 1.5 ? 'checked' : '') . '>';
                    echo '<input type="radio" name="' . $ingredientName . '" value="2" ' . ($preferenceValue == 2 ? 'checked' : '') . '>';
                    echo '</div>';
                }
            } else {
                echo "Aucun ingrédient trouvé";
            }
        } else {
            // ... (le reste du code reste inchangé)
        }
    } else {
        // Affiche un message indiquant que la session n'existe pas
        echo "Erreur";
    }
} else {
    // Affiche un message indiquant que la catégorie n'est pas spécifiée
    echo "La catégorie n'est pas spécifiée.";
}

$conn->close();
?>
