<?php
session_start();
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

$currentCategory = $listeCategoriesStocks[0];
echo '<input type="hidden" id="category" name="category" value="' . $currentCategory . '" />';
$currentIndex = (in_array($currentCategory, $listeCategoriesStocks) ? array_search($currentCategory, $listeCategoriesStocks) : 0);

echo '<script>';
echo 'var categories = ' . json_encode($listeCategoriesStocks, JSON_HEX_QUOT | JSON_HEX_APOS) . ';';
echo 'var currentIndex = ' . $currentIndex . ';';
echo '</script>';

$conn->close();

echo '</div>';

$precedentButtonClass = $currentIndex > 0 ? 'visible' : 'invisible';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edu'Cook</title>
    
</head>
<body onload="loadRecipes()">
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
        
        </div>

        <button id="btnPrecedent" type="button" class="<?php echo ($currentIndex > 0 ? 'visible' : 'invisible'); ?>" onclick="CategoriePrecedente()">Précédent</button>
        <button type="button" onclick="CategorieSuivante()">Suivant</button>
        <button type="button">Enregistrer</button>

    </section>

    <script>

        // Fonction appelée lorsque la page a fini de se charger
        document.addEventListener('DOMContentLoaded', function() {
            loadRecipes(); // Appeler loadRecipes ici, car la page est maintenant chargée
        });

        // JavaScript pour soumettre le formulaire
        function loadRecipes() {
        console.log("Current Category: " + document.getElementById("category").value);
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
            if (currentIndex >= categories.length - 1) {
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
            // Sauvegarder les préférences
            savePreferences();

            // Afficher la catégorie suivante
            loadRecipes();
        } 

        function CategoriePrecedente() {
        currentIndex = (currentIndex - 1);
        document.getElementById("category").value = categories[currentIndex];

        //hideStaticForm();
        var precedentButton = document.getElementById("btnPrecedent");
            if (currentIndex === 0) {
                precedentButton.classList.add("invisible");
            } else {
                precedentButton.classList.remove("invisible");
            }

        // Sauvegarder les préférences
        savePreferences();

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

        function savePreferences() {
        var ingredients = document.querySelectorAll('.ingredient');

        ingredients.forEach(function (ingredient) {
            var nom = ingredient.getAttribute('data-nom');
            var checkedRadio = ingredient.querySelector('input[type="radio"]:checked');

            if (checkedRadio) {
                var value = checkedRadio.value;
                console.log(nom + ': ' + value);
            }
            });
        }


        /* Fonction pour cacher ou supprimer la balise statique
        function hideStaticForm() {
            var staticFormContainer = document.getElementById("staticFormContainer");
            if (staticFormContainer) {
                // Cacher ou supprimer la balise statique
                staticFormContainer.remove();
            }
        }*/
    </script>
</body>
</html>