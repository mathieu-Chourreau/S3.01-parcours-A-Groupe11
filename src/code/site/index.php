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

        <!-- Affichage dynamique de la catégorie -->
        <div id="categoryContent"></div>

        <!-- Balise category -->
        <input type="hidden" id="category" name="category" value="..." />

            <?php
            include 'bd.php';

            // Récupérer la catégorie actuelle (par défaut, la première catégorie)
            $sql = "SELECT categorie FROM categorieIngredient GROUP BY categorie";
            $result = $conn->query($sql);

            $listeCategoriesStocks = [];

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Ajoutez la catégorie à la fin du tableau
                    $listeCategoriesStocks[] = $row["categorie"];
                }
            }

            $listeCategoriesStocks = array_reverse($listeCategoriesStocks);
            $currentCategory = $listeCategoriesStocks[0];
            $currentIndex = (in_array($currentCategory, $listeCategoriesStocks) ? array_search($currentCategory, $listeCategoriesStocks) : 0);

            echo '<script>';
            echo 'var categories = ' . json_encode($listeCategoriesStocks) . ';';
            echo 'var currentIndex = ' . $currentIndex . ';';
            echo '</script>';

            /*Afficher uniquement la catégorie actuelle lors du premier chargement
            echo '<div id="staticFormContainer">';

            echo '<p>Catégorie actuelle : ' . $currentCategory . '</p>';

            echo '  <input type="hidden" id="category" name="category" value="' . $currentCategory . '" />';
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
            echo '</div>';
            */
            echo '<div id="categoryContent"></div>';
            $conn->close();
            
        echo '</div>';
        
        $precedentButtonClass = $currentIndex > 0 ? 'visible' : 'invisible';

        // Afficher le bouton "Précédent" avec la classe appropriée
        echo '<button id="btnPrecedent" type="button" class="' . $precedentButtonClass . '" onclick="CategoriePrecedente()">Précédent</button>';
        echo '<button type="button" onclick="CategorieSuivante()">Suivant</button>';
        echo '<button type="button">Enregistrer</button>';
        ?>
    </form>
    
</div>
</section>

<script>


    
    // JavaScript pour soumettre le formulaire
    function loadRecipes() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Mise à jour du contenu de la balise div avec la réponse de la requête
                document.getElementById("categoryContent").innerHTML = xhr.responseText;
            } else {
                console.error('Error loading recipes. Status: ' + xhr.status);
                console.log(xhr.responseText); // Affiche la réponse complète dans la console
            }
        }
    };

    // Récupération de la valeur de la catégorie actuelle
    var currentCategory = document.getElementById("category").value;

    // Création de la requête AJAX
    xhr.open("POST", "ajax_handler.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("category=" + currentCategory);
    }

    // JavaScript pour gérer le bouton Suivant
    function CategorieSuivante() {

        if(currentIndex >= categories.length - 1){
            window.location.href = 'sale.php';
        }

        currentIndex = (currentIndex + 1);
        document.getElementById("category").value = categories[currentIndex];

        // Afficher ou cacher le bouton "Précédent" en fonction de currentIndex
        var precedentButton = document.getElementById("btnPrecedent");
        if (currentIndex === 0) {
            precedentButton.classList.add("invisible");
        } else {
            precedentButton.classList.remove("invisible");
        }

        hideStaticForm();

        
        // Afficher la catégorie suivante
        loadRecipes();
    }   

    function CategoriePrecedente() {
    currentIndex = (currentIndex - 1);
    document.getElementById("category").value = categories[currentIndex];

    hideStaticForm();
    var precedentButton = document.getElementById("btnPrecedent");
        if (currentIndex === 0) {
            precedentButton.classList.add("invisible");
        } else {
            precedentButton.classList.remove("invisible");
        }
    loadRecipes();
    };

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




    // Fonction pour cacher ou supprimer la balise statique
    function hideStaticForm() {
        var staticFormContainer = document.getElementById("staticFormContainer");
        if (staticFormContainer) {
            // Cacher ou supprimer la balise statique
            staticFormContainer.remove();
        }
    }
</script>
</body>
</html>