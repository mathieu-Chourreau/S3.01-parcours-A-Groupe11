<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="formulaire.css">

    <title>Edu'Cook</title>
</head>

<body>

    <div class="background"></div>
    <div class="wrapper">
        <nav class="nav">
            <div class="logo">
                <a href="index.html">
                    <img class="img_logo" src="image/logo.png">
                </a>
            </div>
            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="#" class="link active">Accueil</a></li>
                    <li><a href="#" class="link">Rechercher</a></li>
                    <li><a href="#" class="link">Formulaire</a></li>
                    <li><a href="#" class="link">L'équipe</a></li>
                </ul>
            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="login()">Se connecter</button>
                <button class="btn" id="registerBtn" onclick="register()">S'enregistrer</button>
            </div>
        </nav>
    </div>

    <?php

    include 'bd.php';

    $sql = "SELECT categorie FROM categorieingredient GROUP BY categorie";

    $result = $conn->query($sql);

    $listeCategoriesStocks = [];
    $lCategorieAvecTous = [];
    $lCategorieAvecTous[] = "Toutes les catégories";

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ajoute chaque catégorie au tableau
            $listeCategoriesStocks[] = $row["categorie"];
            $lCategorieAvecTous[] = $row["categorie"];
        }
    }
    ?>
    <div class="parametre_form">
        <div class="recherche_aliment">
            <label for="categories">Trouver votre aliment :</label>
            <input type="text" id="input_recherche" placeholder="Recherche d'ingrédient...">
        </div>
    </div>
    <form id="example" method="POST" class="table table-striped" action="sale.php">
        <div class="container">
            <div id="choix_categorie">
                <div class="custom-select" id="custom-select">
                    <div class="selected-option" id="selected-option">Toutes les catégories</div>
                    <div class="options" id="options">
                        <?php
                        foreach ($lCategorieAvecTous as $categorie) {
                            echo '<div class="option" onclick="selectOption(\'' . $categorie . '\')">' . $categorie . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <table id="table_formulaire">
                <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Catégorie</th>
                        <th>Je n'en veux pas</th>
                        <th>Je n'aime pas</th>
                        <th>Sans préférence</th>
                        <th>J'aime</th>
                        <th>J'adore</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    for ($i = 0; $i < count($listeCategoriesStocks); $i++) {
                        $sql = "SELECT nom, categorie FROM ingredient JOIN categorieingredient ON ingredient.identifiantC = categorieingredient.identifiant WHERE categorie ='{$listeCategoriesStocks[$i]}'";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr class="' . str_replace(" ", "-", $row['categorie']) . '">'; // Remplacer les espaces par des tirets pour éviter les problèmes de classe CSS
                                echo '<td>' . $row["nom"] . '</td>';
                                echo '<td>' . $row['categorie'] . '</td>';
                                echo '<td> <input type="radio" id="' . $row["nom"] . 'jamais" name="' . $row["nom"] . '" value ="0"> </td>';
                                echo '<td> <input type="radio" id="' . $row["nom"] . 'aimePas" name="' . $row["nom"] . '" value ="0.5"> </td>';
                                echo '<td> <input type="radio" id="' . $row["nom"] . 'sansPreference" name="' . $row["nom"] . '" value ="1" checked> </td>';
                                echo '<td> <input type="radio" id="' . $row["nom"] . 'aime" name="' . $row["nom"] . '" value ="1.5"> </td>';
                                echo '<td> <input type="radio" id="' . $row["nom"] . 'adore" name="' . $row["nom"] . '" value ="2"> </td>';
                                echo '</tr>';
                            }
                        }

                    }

                    foreach ($listeCategoriesStocks as $categorie) {
                        echo '<tr class="' . str_replace(" ", "-", $categorie) . '">'; // Remplacer les espaces par des tirets pour éviter les problèmes de classe CSS
                        echo '<td>' . $categorie . '</td>'; // Cellule pour l'ingrédient
                        echo '<td>' . $categorie . '</td>'; // Cellule pour la catégorie
                        echo '<td> <input type="radio" id="jamais" name="jamais" value ="0"> </td>'; // Radio bouton Je n'en veux pas
                        echo '<td> <input type="radio" id="aimePas" name="aimePas" value ="0.5"> </td>'; // Radio bouton Je n'aime pas
                        echo '<td> <input type="radio" id="sansPreference" name="sansPreference" value ="1" checked> </td>'; // Radio bouton Sans préférence
                        echo '<td> <input type="radio" id="aime" name="aime" value ="1.5"> </td>'; // Radio bouton J'aime
                        echo '<td> <input type="radio" id="adore" name="adore" value ="2"> </td>'; // Radio bouton J'adore
                        echo '</tr>';
                    }

                    $conn->close();
                    ?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Ingredient</th>
                        <th>Catégorie</th>
                        <th>Je n'en veux pas</th>
                        <th>Je n'aime pas</th>
                        <th>Sans préférence</th>
                        <th>J'aime</th>
                        <th>J'adore</th>
                    </tr>
                </tfoot>

                <script>
                    // Sélectionner les lignes du tableau dans tbody
                    var rows = $("#example tbody tr").get();
                    // Trier les lignes en fonction du contenu de la première colonne (ingredient)
                    rows.sort(function (rowA, rowB) {
                        var ingredientA = $(rowA).find("td:first").text().toUpperCase();
                        var ingredientB = $(rowB).find("td:first").text().toUpperCase();
                        return (ingredientA < ingredientB) ? -1 : (ingredientA > ingredientB) ? 1 : 0;
                    });
                    // Réinsérer les lignes triées dans le tableau
                    $.each(rows, function (index, row) {
                        $("#example tbody").append(row);
                    });
                </script>

            </table>

        </div>
        <div class="boutons_form">
            <button onclick="reinitialiserPref()" style="margin:1%; margin-left: 8.1vw;">Réinitialiser vos
                préférences</button>

            <div>
                <button class="modal-btn modal-trigger" id="annulerBtn" type="button">Annuler</button>
                <button class="modal-btn modal-trigger2" id="validerBtn" type="button">Valider</button>

            </div>
        </div>
    </form>


    <div class="modal-container">
        <div class="overlay modal-trigger"></div>
        <div class="modal">
            <button class="close-modal modal-trigger">X</button>

            <h1 class="modal-title"> Vous êtes sûr de vouloir annuler ?</h1>
            <p>Vous vous apprêtez à annuler toutes vos modifications, et vous serez redirigé vers la page d'accueil.
            </p>
            <p>Etes vous sûr de vouloir annuler ?</p>
            <div class="close-modal2">
                <button class="btn-retour-modal modal-trigger">Retour</button>
                <a href="index.html" class="btn-annuler-modal">Annuler</a>
            </div>

        </div>
    </div>


    <div class="modal-container2">
        <div class="overlay modal-trigger2"></div>
        <div class="modal">
            <button class="close-modal modal-trigger2">X</button>

            <h1 class="modal-title"> Etes-vous prêt à voir votre sélection ?</h1>
            <p>Vous vous appretez à valider votre formulaire et vous allez être redirigé vers la page contenant notre
                sélection de recettes.
            </p>
            <p>Etes vous sûr de vouloir continuer ?</p>
            <div class="close-modal2">
                <button class="btn-retour-modal modal-trigger2">Retour</button>
                <a href="#" class="btn-annuler-modal" onclick="submitForm()">Continuer</a>
            </div>

        </div>
    </div>

    <script>

        //document.addEventListener("DOMContentLoaded",(event)=>{sortByCategory(selectedCategory)})

        $(document).ready(function () {

            // Filtrer le tableau lorsqu'un texte est saisi dans la barre de recherche
            $("#input_recherche").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();
                filterTableBySearch(searchText);
            });
        });

        $(document).ready(function() {
            // Définir la catégorie sélectionnée au démarrage de la page
            var selectedCategory = $("#selected-option").text();
            // Exécuter la fonction sortByCategory avec la catégorie sélectionnée
            sortByCategory(selectedCategory);
        });

        // Ajouter un écouteur d'événements sur les clics des options
        document.querySelectorAll('.option').forEach(option => {
            option.addEventListener('click', function() {
                var selectedCategory = this.textContent;
                sortByCategory(selectedCategory);
            });
        });

        function filterTableBySearch(searchText) {
            $("#example tbody tr").each(function () {
                var rowText = $(this).find("td:first").text().toLowerCase();
                if (!rowText.startsWith(searchText.toLowerCase())) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }

        function reinitialiserPref() {
            var boutonsPref = document.querySelectorAll('input[type="radio"]');

            boutonsPref.forEach(function (bouton) {
                if (bouton.id.endsWith('sansPreference')) {
                    bouton.checked = true;
                } else {
                    bouton.checked = false;
                }
            });
        }

        const modalContainer = document.querySelector(".modal-container");
        const modalContainer2 = document.querySelector(".modal-container2");
        const modalTriggers = document.querySelectorAll(".modal-trigger");
        const modalTriggers2 = document.querySelectorAll(".modal-trigger2");

        modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal))
        modalTriggers2.forEach(trigger => trigger.addEventListener("click", toggleModal2))

        function toggleModal() {
            modalContainer.classList.toggle("active")
        }

        function toggleModal2() {
            modalContainer2.classList.toggle("active")
        }

        function submitForm() {
            // Sélectionner le formulaire par son ID
            var form = document.getElementById("example");

            console.log(form)

            // Soumettre le formulaire
            form.submit();
        }


        function selectOption(option) {
            document.getElementById('selected-option').textContent = option;
            closeOptions();
        }

        function toggleOptions() {
            var options = document.getElementById('options');
            options.style.display = options.style.display === 'none' ? 'block' : 'none';
        }

        function closeOptions() {
            document.getElementById('options').style.display = 'none';
        }

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.custom-select')) {
                closeOptions();
            }
        });

        function sortByCategory(selectedCategory) {
            console.log("Catégorie sélectionnée :", selectedCategory);

            // Récupérer toutes les lignes du tableau
            var rows = $("#table_formulaire tbody tr").get();

            // Parcourir toutes les lignes du tableau
            rows.forEach(function(row) {

                // Récupérer la catégorie de chaque ligne
                var category = $(row).find("td:nth-child(2)").text().trim();
                var ingredient = $(row).find("td:nth-child(1)").text().trim();

                // Vérifier si la catégorie correspond à la catégorie sélectionnée
                if (selectedCategory === "Toutes les catégories") {
                    // Afficher la ligne si la catégorie correspond et que selectedCategory est "Toutes les catégories"
                    if(category === ingredient){
                        $(row).show();
                    }
                    else{
                        $(row).hide();
                    }
                } else if (category === selectedCategory) {
                    // Afficher la ligne si la catégorie correspond
                    $(row).show();
                } else {
                    // Cacher la ligne si la catégorie ne correspond pas
                    $(row).hide();
                }
            });
        }

        $(document).ready(function() {
            $('#selected-option').on('click', function() {
                console.log("Click");
                toggleOptions();
            });
        });



    </script>

</body>

</html>