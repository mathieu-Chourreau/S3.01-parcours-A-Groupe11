<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edu'Cook</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo.png" alt="Logo Edu'Cook">
        </div>
        <h1>Mon En-Tête</h1>
    </header>

    <section class="section">
        <div class="preference">
            <p>Mes préférences : </p>
        </div>
        <div class="recherche_default">
            <ul>Liste d'ingredient : </ul>
            <input type="button" value="Défaut" onclick="reinitialiserPref();" />
            <form action="sale.php" method="post">

                <?php
                /**
                 * @file    index.php
                 * @author  Mathieu,Nathan
                 * @brief   La page index.php permet à l'utilisateur de remplir le formulaire
                 * @version 0.1
                 * @date    17/01/2024
                 */

                include 'bd.php'; 
                /**
                 * @brief   Récupère les catégories d'ingrédients depuis la base de données
                 * @details Utilise une requête SQL pour obtenir les catégories d'ingrédients uniques
                 * @return  array Tableau contenant les catégories d'ingrédients
                 */
                $sql = "SELECT categorie FROM categorieingredient GROUP BY categorie";

                $result = $conn->query($sql);
                /**
                 * @brief   Initialise un tableau à vide
                 */
                $listeCategoriesStocks = [];

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Ajoute chaque catégorie au tableau
                        $listeCategoriesStocks[] = $row["categorie"];
                    }
                }
                
                /**
                 * @details Utilise une boucle pour afficher les catégories et une requête SQL pour obtenir les ingrédients par catégorie
                 */
                for ($i = 0; $i < count($listeCategoriesStocks); $i++) { 
                    echo '<h3>' . $listeCategoriesStocks[$i] . '</h3>';
                    $sql = "SELECT nom, categorie FROM ingredient JOIN categorieingredient ON ingredient.identifiantC = categorieingredient.identifiant WHERE categorie ='{$listeCategoriesStocks[$i]}'";
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
                }
                $conn->close();
                ?>
                <button id="btnSuivant">Suivant</button>
            </form>
        </div>
    </section>
    <script>
    /**
     * @brief   Gère les événements de clic sur le bouton Suivant
     * @details Récupère les valeurs des préférences d'ingrédients sélectionnées par l'utilisateur
     */
    document.getElementById("btnSuivant").addEventListener("click", function() {
        var boutonsViandes = document.querySelectorAll('input[type="radio"]');
        var valeursPref = {};

        boutonsViandes.forEach(function(bouton) {
            if (bouton.checked) {
                var nomIngredient = bouton.name;
                var valeur = parseFloat(bouton.value); 
                valeursPref[nomIngredient] = valeur;
            }
        });
    });
    
    /**
     * @brief   Réinitialise les préférences d'ingrédients à la valeur par défaut
     * @details Parcourt tous les boutons radio et les réinitialise à la valeur "Sans préférence"
     */
    function reinitialiserPref() {
        var boutonsViandes = document.querySelectorAll('input[type="radio"]');
        
        boutonsViandes.forEach(function(bouton) {
            if (bouton.id.endsWith('sansPreference')) {
                bouton.checked = true; 
            } else {
                bouton.checked = false; 
            }
        });
    }
</script>
</body>
</html>
