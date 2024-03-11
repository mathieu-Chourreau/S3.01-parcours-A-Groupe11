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
    <nav id="nav">
        <div id="divun">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
            <div class="hame">
                <label class="burger" id="burger" for="burger">
                    <input type="checkbox" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="divdeux">
            <ul id="menu">
                <li><a href="#" class="link">Accueil</a></li>
                <li><a href="#" class="link active">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
                <li><a href="#" class="link">Proposer votre recette</a></li>
                <li><a href="#" class="link">Se connecter</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn">Se connecter</button>
        </div>
    </nav>

    <?php

    include 'bd.php';

    $sql = "SELECT categorie FROM categorieingredient GROUP BY categorie";

    $result = $conn->query($sql);

    $listeCategoriesStocks = [];
    $lCategorieAvecTous = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ajoute chaque catégorie au tableau
            $listeCategoriesStocks[] = $row["categorie"];
            $lCategorieAvecTous[] = $row["categorie"];
        }
    }

    function trierSansSensibleCase($a, $b)
    {
        return strcasecmp(strtolower($a), strtolower($b));
    }

    usort($lCategorieAvecTous, "trierSansSensibleCase");
    array_unshift($lCategorieAvecTous, "Toutes les catégories");

    ?>

    <form id="example" method="POST" class="table table-striped" action="sale.php">
        <div class="container">
            <div id="choix_categorie">
                <div class="custom-select" id="custom-select">
                    <div class="triangleGauche" id="triangleGauche"></div>
                    <div class="selected-option" id="selected-option">Choisissez une catégorie</div>
                    <div class="options" id="options">
                        <?php
                        foreach ($lCategorieAvecTous as $categorie) {
                            echo '<div class="option" onclick="selectOption(\'' . $categorie . '\')">' . $categorie . '</div>';
                        }
                        ?>
                    </div>
                    <div class="triangleDroit" id="triangleDroit"></div>
                </div>

            </div>

            <div class="recherche_aliment">
                <label for="categories">Trouver votre aliment :</label>
                <input type="text" id="input_recherche" placeholder="Recherche d'ingrédient...">
            </div>

            <div class="formulaire">
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
                            echo '<td> <input type="radio" id="' . $categorie . 'jamais" name="' . $categorie . '" value ="0"> </td>';
                            echo '<td> <input type="radio" id="' . $categorie . 'aimePas" name="' . $categorie . '" value ="0.5"> </td>';
                            echo '<td> <input type="radio" id="' . $categorie . 'sansPreference" name="' . $categorie . '" value ="1" checked> </td>';
                            echo '<td> <input type="radio" id="' . $categorie . 'aime" name="' . $categorie . '" value ="1.5"> </td>';
                            echo '<td> <input type="radio" id="' . $categorie . 'adore" name="' . $categorie . '" value ="2"> </td>';
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
            <button class="modal-btn modal-trigger3" id="preferenceBtn" type="button">Réinitialiser vos
                préférences</button>
        </div>
        <div class="boutons_form">

            <div>
                <button class="modal-btn modal-trigger" id="annulerBtn" type="button">Annuler</button>
                <button class="modal-btn modal-trigger2" id="validerBtn" type="submit">Valider</button>
            </div>

        </div>
    </form>


    <div class="modal-annuler">
        <div class="overlay modal-trigger"></div>
        <div class="modal">
            <button class="close-modal modal-trigger">X</button>
            <div class="modal-title">
                <h1>Êtes-vous sûr de vouloir annuler ?</h1>
            </div>
            <div class="modal-text">
                <p>Vous vous apprêtez à annuler toutes vos modifications, et vous serez redirigé vers la page
                    d'accueil.</p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir annuler ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger">Retour</button>
                <button class="btn-annuler-modal" onclick="window.location.href='index.html'">Annuler</button>
            </div>

        </div>
    </div>

    <div class="modal-préférence">
        <div class="overlay modal-trigger3"></div>
        <div class="modalPref">
            <button class="close-modal modal-trigger3">X</button>
            <div class="modal-title">
                <h1>Êtes-vous sûr de vouloir Réinitialiser vos préférences ?</h1>
            </div>
            <div class="modal-text">
                <p>Vous vous apprêtez à réinitialiser toutes vos préférences par défault, c'est-à-dire à "Sans
                    préférence".</p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir réinitialiser ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger3">Retour</button>
                <button class="btn-reinitialiser-modal" onclick="reinitialiserPref()">Réinitialiser</button>
            </div>

        </div>
    </div>


    <!-- <div class="modal-valider">
        <div class="overlay modal-trigger2"></div>
        <div class="modal">
            <button class="close-modal modal-trigger2">X</button>
            <div class="modal-title">
                <h1> Etes-vous prêt à voir votre sélection ?</h1>
            </div>
            <div class="modal-text">
                <p style="margin-right: 40px;">Vous vous appretez à valider votre formulaire et vous allez être redirigé
                    vers la page contenant
                    notre
                    sélection de recettes.
                </p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir continuer ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger2">Retour</button>
                <a href="#" class="btn-annuler-modal" onclick="submitForm()">Continuer</a>
            </div>

        </div>
    </div> -->

    <script>

        $(document).ready(function () {
            sortByCategoryAndIngredient();

            // Définir la catégorie sélectionnée au démarrage de la page
            var selectedCategory = "Toutes les catégories";
            // Exécuter la fonction sortByCategory avec la catégorie sélectionnée
            sortByCategory(selectedCategory);


        });

        //document.addEventListener("DOMContentLoaded",(event)=>{sortByCategory(selectedCategory)})

        $(document).ready(function () {

            $("#input_recherche").prop("disabled", true);

            // Attacher un événement de saisie à l'élément de recherche
            $("#input_recherche").on("input", function () {
                var searchText = $(this).val();
                filterTableBySearch(searchText);
            });
        });

        // Ajouter un écouteur d'événements sur les clics des options
        document.querySelectorAll('.option').forEach(option => {
            option.addEventListener('click', function () {
                var selectedCategory = this.textContent;
                sortByCategory(selectedCategory);
            });
        });

        function sortByCategoryAndIngredient() {
            var rows = $("#table_formulaire tbody tr").get();
            var sortedRowsByCategory = {};

            // Séparer les lignes par catégorie
            rows.forEach(function (row) {
                var category = $(row).find("td:nth-child(2)").text().trim().toLowerCase();
                if (!sortedRowsByCategory[category]) {
                    sortedRowsByCategory[category] = [];
                }
                sortedRowsByCategory[category].push(row);
            });

            // Trier les catégories par ordre alphabétique
            var sortedCategories = Object.keys(sortedRowsByCategory).sort();

            // Réinitialiser le tableau avant de réinsérer les lignes triées
            $("#table_formulaire tbody").empty();

            // Traiter chaque catégorie triée et trier les lignes correspondantes
            sortedCategories.forEach(function (category) {
                var rowsWithCategoryName = [];
                var rowsWithoutCategoryName = [];

                // Séparer les lignes en deux groupes : celles avec le même nom d'ingrédient que la catégorie et celles sans
                sortedRowsByCategory[category].forEach(function (row) {
                    var ingredient = $(row).find("td:first").text().trim().toLowerCase();
                    if (ingredient === category) {
                        rowsWithCategoryName.push(row);
                    } else {
                        rowsWithoutCategoryName.push(row);
                    }
                });

                // Trier les lignes avec le même nom d'ingrédient que la catégorie en premier
                rowsWithCategoryName.sort(function (a, b) {
                    return 0; // Conserver l'ordre d'origine pour ces lignes
                });

                // Trier les autres lignes par ordre alphabétique de l'ingrédient
                rowsWithoutCategoryName.sort(function (a, b) {
                    var ingredientA = $(a).find("td:first").text().trim().toLowerCase();
                    var ingredientB = $(b).find("td:first").text().trim().toLowerCase();
                    return ingredientA.localeCompare(ingredientB);
                });

                // Réunir les deux groupes triés
                var sortedRows = rowsWithCategoryName.concat(rowsWithoutCategoryName);

                // Réinsérer les lignes triées dans le tableau
                sortedRows.forEach(function (row) {
                    $("#table_formulaire tbody").append(row);
                });
            });
        }





        function filterTableBySearch(searchText) {
            var selectedCategory = $("#selected-option").text().trim();


            $("#example tbody tr").each(function () {
                var rowText = $(this).find("td:first").text().toLowerCase();
                var rowCategory = $(this).find("td:nth-child(2)").text().trim();

                var regex = new RegExp('^' + searchText.toLowerCase());

                if ((!regex.test(rowText) && rowCategory === selectedCategory) || rowCategory !== selectedCategory) {
                    $(this).hide();
                } else {
                    // Vérifier les autres lignes avec la même catégorie et le même ingrédient
                    var currentIngredient = rowText;
                    var currentCategory = rowCategory;
                    var currentRow = $(this);

                    $("#example tbody tr").not(currentRow).each(function () {
                        var otherRowText = $(this).find("td:first").text().toLowerCase();
                        var otherRowCategory = $(this).find("td:nth-child(2)").text().trim();

                        if (otherRowText === currentIngredient && otherRowCategory === currentCategory && category === ingredient) {
                            $(this).hide();
                        }
                    });

                    if ($(this).is(":hidden")) {
                        $(this).show();
                    }
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

            modalContainer3.classList.toggle("active")

            // Définir la catégorie sélectionnée au démarrage de la page
            var selectedCategory = "Toutes les catégories";
            // Exécuter la fonction sortByCategory avec la catégorie sélectionnée
            sortByCategory(selectedCategory);

            $("#selected-option").text(selectedCategory);

        }

        const modalContainer = document.querySelector(".modal-annuler");
        // const modalContainer2 = document.querySelector(".modal-valider");
        const modalContainer3 = document.querySelector(".modal-préférence");
        const modalTriggers = document.querySelectorAll(".modal-trigger");
        // const modalTriggers2 = document.querySelectorAll(".modal-trigger2");
        const modalTriggers3 = document.querySelectorAll(".modal-trigger3");

        modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal))
        // modalTriggers2.forEach(trigger => trigger.addEventListener("click", toggleModal2))
        modalTriggers3.forEach(trigger => trigger.addEventListener("click", toggleModal3))

        function toggleModal() {
            modalContainer.classList.toggle("active")
        }

        // function toggleModal2() {
        //     modalContainer2.classList.toggle("active")
        // }

        function toggleModal3() {
            modalContainer3.classList.toggle("active")
        }

        function submitForm() {

            // modalContainer2.classList.toggle("active");

            // Sélectionner le formulaire par son ID
            var form = document.getElementById("example");

            console.log(form)

            // Soumettre le formulaire

            form.submit();
        }


        function selectOption(option) {
            document.getElementById('selected-option').textContent = option;
            closeOptions();
            toggleTriangleDirection();
        }

        function toggleOptions() {
            console.log("Fonction toggleModal appelée.");
            $('#options').toggle();
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
            var colonne = $("#table_formulaire tbody td").get();

            // Parcourir toutes les lignes du tableau
            rows.forEach(function (row) {
                // Récupérer la catégorie de chaque ligne
                var category = $(row).find("td:nth-child(2)").text().trim();
                var ingredient = $(row).find("td:nth-child(1)").text().trim();
                var ingredientCells = document.querySelectorAll('#table_formulaire th:first-child, #table_formulaire td:first-child');
                var categoryCells = document.querySelectorAll('#table_formulaire th:nth-child(2), #table_formulaire td:nth-child(2)');

                if (selectedCategory === "Toutes les catégories") {
                    // Si la catégorie sélectionnée est "Toutes les catégories"
                    $("#input_recherche").attr("placeholder", "Sélectionnez une catégorie avant de rechercher...");
                    $("#input_recherche").prop("disabled", true);

                    // Afficher ou masquer les cellules en fonction de la sélection de catégorie
                    ingredientCells.forEach(function (cell) {
                        cell.style.display = 'none';
                    });
                    categoryCells.forEach(function (cell) {
                        cell.style.display = 'table-cell';
                    });

                    // Afficher la ligne si la catégorie correspond à l'ingrédient
                    if (category === ingredient) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                } else if (category === selectedCategory) {
                    // Si une catégorie spécifique est sélectionnée
                    $("#input_recherche").attr("placeholder", "Ex: Courge ...");
                    $("#input_recherche").prop("disabled", false);

                    // Afficher la ligne si la catégorie correspond à la catégorie sélectionnée
                    $(row).show();

                    // Afficher ou masquer les cellules en fonction de la sélection de catégorie
                    categoryCells.forEach(function (cell) {
                        cell.style.display = 'none';
                    });
                    ingredientCells.forEach(function (cell) {
                        cell.style.display = 'table-cell';
                    });

                    // Sortir de la boucle une fois la première ligne trouvée
                    return false;
                } else {
                    // Cacher la ligne si la catégorie ne correspond pas
                    $(row).hide();
                }
            });

            $(".formulaire").scrollTop(0);

            // Appeler la fonction pour mettre en surbrillance la première ligne correspondante
            highlightFirstRow(selectedCategory);
        }

        function highlightFirstRow(selectedCategory) {
            // Récupérer toutes les lignes du tableau
            var rows = $("#table_formulaire tbody tr").get();

            // Retirer la classe highlight-row de toutes les lignes
            $("#table_formulaire tbody tr").removeClass("highlighted");

            // Parcourir toutes les lignes du tableau
            for (var i = 0; i < rows.length; i++) {
                var row = rows[i];
                var category = $(row).find("td:nth-child(2)").text().trim();
                if (selectedCategory === category) {
                    // Si la catégorie de la ligne correspond à la catégorie sélectionnée,
                    // ajouter la classe highlight-row et sortir de la boucle
                    $(row).addClass("highlighted");
                    break;
                }
            }
        }



        $(document).ready(function () {
            $('#selected-option').on('click', function () {
                console.log("Click");
                toggleTriangleDirection();
                toggleOptions();
            });
        });

        $(document).ready(function () {
            // Ajoutez un gestionnaire d'événements pour les changements de valeur des boutons radio
            $('input[type="radio"]').change(function () {
                // Obtenez la valeur sélectionnée du bouton radio
                var selectedValue = $(this).val();
                // Obtenez l'identifiant de l'ingrédient associé
                var ingredientId = $(this).attr('name');
                // Obtenez la catégorie de la ligne
                var categoryBtnChange = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                // Obtenez l'ingrédient de la ligne
                var ingredient = $(this).closest('tr').find('td:first').text().trim();

                // Affichez la valeur sélectionnée, l'identifiant de l'ingrédient et la catégorie de la ligne dans la console à des fins de débogage
                console.log("Nouvelle valeur sélectionnée pour " + ingredientId + ": " + selectedValue);
                console.log("Catégorie de la ligne: " + categoryBtnChange);
                console.log("Ingrédient de la ligne: " + ingredient);

                // Si la catégorie et l'ingrédient de la ligne correspondent à celle de la ligne du bouton radio, appelez la fonction pour changer les autres boutons radio
                if (ingredient === categoryBtnChange) {
                    changerValeurBoutons(selectedValue, categoryBtnChange);
                }
            });
        });

        function changerValeurBoutons(selectedValue, categoryBtnChange) {
            // Sélectionnez tous les boutons radio avec le même identifiant d'ingrédient
            $('input[value="' + selectedValue + '"]').each(function () {

                var category = $(this).closest('tr').find('td:nth-child(2)').text().trim();
                // Obtenez l'ingrédient de la ligne
                var ingredient = $(this).closest('tr').find('td:first').text().trim();

                if (ingredient != category) {
                    if (categoryBtnChange === category) {
                        if ($(this).val() === selectedValue) {
                            $(this).prop('checked', true);
                        } else {
                            $(this).prop('checked', false);
                        }
                    }
                }
            });
        }

        const menuHamburger = document.getElementById("burger");
        const navLinks = document.querySelector(".divdeux");
        menuHamburger.addEventListener('click', () => { navLinks.classList.toggle('mobile-menu') });

        function toggleTriangleDirection() {
            var triangleDroit = document.getElementById("triangleDroit");
            var triangleGauche = document.getElementById("triangleGauche");

            triangleDroit.classList.toggle("down");
            triangleGauche.classList.toggle("down");
        }


    </script>

</body>

</html>