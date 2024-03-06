<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Détails de la recette</title>
    <link rel="stylesheet" href="recherche.css">
</head>
<body>
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

    <section class="s_details">
        <div class="recettes">
            <div class="card_detail">
                <div class="imgCard">
                    <h5>Vidéo explicative :</h5>
                    <img id="recipe-image" class="recipe-image" src="" alt="Image de la recette">
                </div>
                
                <div class="detail_recette">
                    <h4 id="recipe-name" class="recipe-name"></h4>
                    <p id="recipe-category" class="recipe-category"></p>
                    <p id="recipe-description" class="recipe-description"></p>

                    <?php
                        $recipeName = $_GET['recipeName'];

                        include 'bd.php';

                        $temps = "SELECT temps_min_ as temps
                        FROM recette
                        WHERE nom = '$recipeName'";

                        $resultTps = $conn->query($temps);

                        foreach ($resultTps as $tps) {
                            echo '<p><b>Temps de préparation : </b>' . $tps['temps'] . '</p>';
                        }

                        $dif = "SELECT niveau_difficulte as dif
                        FROM recette
                        WHERE nom = '$recipeName'";

                        $resultDif = $conn->query($dif);

                        foreach ($resultDif as $dif) {
                            echo '<p><b>Difficulté : </b>' . $dif['dif'] . '</p>';
                        }

                        echo '</div>';
                        echo '<div class="ingredients">';
                        echo '<p><b>Ingrédients nécessaires :</b></p>';

                        $ingredient = "SELECT i.nom AS nom_ingredient, c.quantite AS quantite
                        FROM ingredient i
                        JOIN contenir c ON i.nom = c.Ingredient_id
                        JOIN recette r ON c.Recette_id = r.identifiant
                        WHERE r.nom = '$recipeName';";

                        $resultIng = $conn->query($ingredient);

                        echo '<ul>';
                        foreach ($resultIng as $ing) {
                            echo '<li>' . $ing['nom_ingredient'] . ' : ' . $ing['quantite'] . ' g</li>';
                        }
                        echo '</ul>';
                    ?>
                </div>
            </div>
        </div>
    </section>

    
    

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const recipeName = urlParams.get('recipeName');
            const recipeCategory = urlParams.get('recipeCategory');
            const recipeDescription = urlParams.get('recipeDescription');
            const recipeImageSrc = urlParams.get('recipeImageSrc');

            document.getElementById('recipe-name').textContent = recipeName;
            document.getElementById('recipe-category').innerHTML = "<b>Catégorie : </b>" + recipeCategory;
            document.getElementById('recipe-description').innerHTML = "<b>Description : </b>" + recipeDescription;
            document.getElementById('recipe-image').src = recipeImageSrc;
        });

        const menuHamburger = document.getElementById("burger");
        const navLinks = document.querySelector(".divdeux");
        menuHamburger.addEventListener('click', () => { navLinks.classList.toggle('mobile-menu') });

    </script>
</body>
</html>