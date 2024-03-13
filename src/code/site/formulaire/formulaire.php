<?php
session_start();

include '../bd.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'utilisateur est connecté
        echo "<script>alert('formulaire soumis');</script>";
        // Connexion à la base de données
        $conn = connexionBd();
        echo "<script>alert('connexion');</script>";
        // Préparer la requête d'insertion
        $sql = "INSERT INTO preferences_utilisateur (nom_utilisateur, nom_ingredient, preference) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        echo "<script>alert('Preparation');</script>";

        // Récupérer l'identifiant de l'utilisateur connecté
        $id_utilisateur =  $_SESSION['login_username'] ;

        echo "<script>alert('utilisateur');</script>";
        // Parcourir les données du formulaire

        echo "<script>alert('debut parcours');</script>";
        foreach ($_POST as $nom_ingredient => $preference) {
            // Exécuter la requête d'insertion pour chaque ligne du formulaire
            $stmt->bind_param("ssi", $id_utilisateur, $nom_ingredient, $preference);
            $stmt->execute();
        }

        echo "<script>alert('Fin');</script>";

        deconnexionBd($stmt);
        deconnexionBd($conn);
    }


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link rel="stylesheet" href="formulaire.css">
    <link rel="stylesheet" href="../commun/commun.css">

    <title>Edu'Cook</title>
</head>
<?php
if ($_SESSION['connecter'] == true) {
    ?>

    <body>
        <div class="background"></div>
        <nav id="nav">
            <div id="imgLogoNav">
                <a href="#"><img class="img_logo" src="../image/logo.png"></a>
                <div class="boutonHamburger">
                    <label class="burger" id="burger" for="burger">
                        <input type="checkbox" id="burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="titreMenu">
                <ul id="menu">
                    <li><a href="../index.php" class="link">Accueil</a></li>
                    <li><a href="../recherche/recherche.php" class="link">Rechercher</a></li>
                    <li><a href="formulaire.php" class="link active">Formulaire</a></li>
                    <li><a href="../equipe/equipe.php" class="link">L'équipe</a></li>
                    <li><a href="../proposerRecette/proposRecette.php" class="link">Proposer votre recette</a></li>
                    <?php if ($_SESSION['admin'] == false) { ?>
                    <?php } elseif ($_SESSION['admin'] == true) {
                        echo "<li><a href='../backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";
                    } ?>
                </ul>
            </div>
            <div class="boutonConnexion">
                <?php if ($_SESSION['connecter'] == false) { ?>
                    <a href="connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se
                            connecter</button></a>
                <?php } elseif ($_SESSION['connecter'] == true) {
                    echo "<button class='btn white-btn' id='loginBtn'><a href='../connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";
                } ?>
            </div>
        </nav>

        <?php


        $conn = connexionBd();

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

        <h1 class="titre_Form">Bienvenu dans votre formulaire de préférence !</h1>

        <h2 class="aide_categorie">Sélectionnez une catégorie parmi celles proposées :</h2>

        <form id="form_pref" method="POST" onsubmit="submitForm()" action="sale.php">
            <div class="container_form">
                <div id="choix_categorie">
                    <div id="navBar">
                        <?php foreach ($lCategorieAvecTous as $categorie) {
                            echo '<a href="#" class="navLink" id="navLink' . str_replace(" ", "", $categorie) . '">' . $categorie . '</a>';
                        } ?>
                    </div>

                </div>

                <h2 class="aide_preference">Cochez vos préférences :</h2>

                <div class="recherche_aliment">
                    <label for="categories">Vous pouvez également rechercher votre aliment :</label>
                    <input type="text" id="input_recherche" placeholder="Recherche d'ingrédient...">
                </div>

                <div class="div_formulaire">
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

                            $sql = "SELECT nom, categorie FROM ingredient 
                        JOIN categorieingredient ON ingredient.identifiantC = categorieingredient.identifiant 
                        WHERE categorie = ?";

                            $stmt = $conn->prepare($sql);

                            for ($i = 0; $i < count($listeCategoriesStocks); $i++) {
                                $stmt->bind_param("s", $categorie);
                                $categorie = $listeCategoriesStocks[$i];
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr class="' . str_replace(" ", "-", $row['categorie']) . '">';
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
                                echo '<tr class="' . str_replace(" ", "-", $categorie) . '">';
                                echo '<td>' . $categorie . '</td>';
                                echo '<td>' . $categorie . '</td>';
                                echo '<td> <input type="radio" id="' . $categorie . 'jamais" name="' . $categorie . '" value ="0"> </td>';
                                echo '<td> <input type="radio" id="' . $categorie . 'aimePas" name="' . $categorie . '" value ="0.5"> </td>';
                                echo '<td> <input type="radio" id="' . $categorie . 'sansPreference" name="' . $categorie . '" value ="1" checked> </td>';
                                echo '<td> <input type="radio" id="' . $categorie . 'aime" name="' . $categorie . '" value ="1.5"> </td>';
                                echo '<td> <input type="radio" id="' . $categorie . 'adore" name="' . $categorie . '" value ="2"> </td>';
                                echo '</tr>';
                            }
                            deconnexionBd($stmt);
                            deconnexionBd($conn);
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
                            var rows = $("#form_pref tbody tr").get();
                            // Trier les lignes en fonction du contenu de la première colonne (ingredient)
                            rows.sort(function (rowA, rowB) {
                                var ingredientA = $(rowA).find("td:first").text().toUpperCase();
                                var ingredientB = $(rowB).find("td:first").text().toUpperCase();
                                return (ingredientA < ingredientB) ? -1 : (ingredientA > ingredientB) ? 1 : 0;
                            });
                            // Réinsérer les lignes triées dans le tableau
                            $.each(rows, function (index, row) {
                                $("#form_pref tbody").append(row);
                            });
                        </script>

                    </table>

                </div>
                <button class="modal-btn modal-trigger3" id="preferenceBtn" type="button">Réinitialiser vos
                    préférences</button>
            </div>
            <div class="boutons_form">
                <button class="modal-btn modal-trigger" id="annulerBtn" type="button">Annuler</button>
                <button id="validerBtn" type="submit">Suivant</button>
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

    <?php } else {
    header("Location: ../connexion/connexion.php");
    exit;
} ?>
    <footer class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="region region-footer1">
                        <section id="block-block-1" class="block block-block clearfix">
                            <p>@&nbsp;Equipe Edu'Cook<br />
                                Tous droits réservés<br />
                                <a class="lien" href="../newsletter/politique_confidentialite.html">Politique de
                                    confidentialité</a>
                            </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 news">
                    <div class="region region-footer2">
                        <section id="block-block-2" class="block block-block clearfix">
                            <p>Notre Newsletter : </p>
                            <a class="btn_footer" href="../newsletter/newsletter.html">Accès au Newsletter</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="../commun/commun.js"></script>

    <script>

        $(document).ready(function () {

            $("#navLinkTouteslescatégories").addClass("active");

            sortByCategoryAndIngredient();

            // Définir la catégorie sélectionnée au démarrage de la page
            var selectedCategory = "Toutes les catégories";
            // Exécuter la fonction sortByCategory avec la catégorie sélectionnée
            sortByCategory(selectedCategory);

            $(".recherche_aliment").hide();

            // Attacher un événement de saisie à l'élément de recherche
            $("#input_recherche").on("input", function () {
                var searchText = $(this).val();
                filterTableBySearch(searchText);
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

        $("#navBar a").click(function () {

            // Supprimer la classe 'active' de tous les liens de catégorie
            $("#navBar a").removeClass("active");

            // Ajouter la classe 'active' uniquement au lien cliqué
            $(this).addClass("active");


            // Appeler la fonction pour filtrer les données en fonction de la catégorie sélectionnée
            var selectedCategory = $(this).text().trim();
            sortByCategory(selectedCategory);

            if (selectedCategory !== "Toutes les catégories") {
                // Afficher l'élément de recherche
                $(".recherche_aliment").show();
            } else {
                // Sinon, cacher l'élément de recherche
                $(".recherche_aliment").hide();
            }
        });


        function filterTableBySearch(searchText) {
            var selectedCategory = $(".navLink.active").text().trim();
            console.log("Selected Category:", selectedCategory);

            $("#form_pref tbody tr").each(function () {
                var rowText = $(this).find("td:first").text().toLowerCase();
                var rowCategory = $(this).find("td:nth-child(2)").text().trim();

                var regex = new RegExp(searchText.toLowerCase()); // Modifier l'expression régulière pour rechercher n'importe où dans le texte

                if ((!regex.test(rowText) && rowCategory === selectedCategory) || rowCategory !== selectedCategory) {
                    $(this).hide();
                } else {
                    // Afficher les lignes qui correspondent à la recherche
                    $(this).show();
                }
            });
        }


        $(document).ready(function () {
            // Récupérer l'URL de la page
            var currentUrl = window.location.href;

            // Parcourir tous les liens de la barre de navigation
            $("#menu li").each(function () {
                var link = $(this).find("a").attr("href");

                // Vérifier si l'URL de la page correspond à l'un des liens de la barre de navigation
                if (currentUrl.indexOf(link) !== -1) {
                    // Ajouter la classe "active" à l'élément parent du lien correspondant
                    $(this).addClass("active");
                }
            });
        });



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

        }

        const modalContainer = document.querySelector(".modal-annuler");
        const modalContainer3 = document.querySelector(".modal-préférence");

        const modalTriggers = document.querySelectorAll(".modal-trigger");
        const modalTriggers3 = document.querySelectorAll(".modal-trigger3");

        modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal))
        modalTriggers3.forEach(trigger => trigger.addEventListener("click", toggleModal3))

        function toggleModal() {
            modalContainer.classList.toggle("active")
        }

        function toggleModal3() {
            modalContainer3.classList.toggle("active")
        }

        function submitForm() {

            var form = document.getElementById("form_pref");

            console.log(form)
            alert("Soumission");
            form.submit();
        }

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

            $(".div_formulaire").scrollTop(0);

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


    </script>

</body>

</html>