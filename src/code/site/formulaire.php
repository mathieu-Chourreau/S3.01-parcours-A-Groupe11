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

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Ajoute chaque catégorie au tableau
            $listeCategoriesStocks[] = $row["categorie"];
        }
    }
    ?>
    <div class="parametre_form">
        <div id="choix_categorie">
            <label for="categories">Choisissez une catégorie :</label>
            <select id="select_categorie">
                <option value="all">Toutes les catégories</option>
                <?php
                // Afficher les options de catégorie
                foreach ($listeCategoriesStocks as $categorie) {
                    echo '<option value="' . str_replace(" ", "-", $categorie) . '">' . $categorie . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="recherche_aliment">
            <label for="categories">Trouver votre aliment :</label>
            <input type="text" id="input_recherche" placeholder="Recherche d'ingrédient...">
        </div>
    </div>

    <div class="container">

        <form id="example" class="table table-striped">
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

            <button type="submit" value="Valider">

        </form>
    </div>

    <input type="button" value="Réinitialiser vos préférences" onclick="reinitialiserPref();"
        style="margin:1%; margin-left: 8.1vw;" />

    <script>
        $(document).ready(function () {
            // Filtrer le tableau lorsqu'une catégorie est sélectionnée
            $("#select_categorie").change(function () {
                var selectedCategory = $(this).val();
                filterTable(selectedCategory);
            });

            // Filtrer le tableau lorsqu'un texte est saisi dans la barre de recherche
            $("#searchInput").on("keyup", function () {
                var searchText = $(this).val().toLowerCase();
                filterTableBySearch(searchText);
            });
        });

        function filterTable(category) {
            if (category === "all") {
                // Afficher toutes les lignes si "Toutes les catégories" est sélectionné
                $("#example tbody tr").show();
            } else {
                // Masquer toutes les lignes, puis afficher uniquement celles de la catégorie sélectionnée
                $("#example tbody tr").hide();
                $("." + category).show();
            }
        }

        function filterTableBySearch(searchText) {
            $("#example tbody tr").each(function () {
                var rowText = $(this).find("td:first").text().toLowerCase();
                if (!rowText.startsWith(searchText.toLowerCase())) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            }); F
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
    </script>
</body>

</html>