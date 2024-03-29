<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="recherche.css">
    <link rel="stylesheet" href="../commun/commun.css">
    <title>Détails de la recette</title>
</head>

<body>
    <div class="background"></div>
    
<nav id="nav">
        <div id="imgLogoNav">
            <a href="../index.php"><img class="img_logo" src="../image/logo.png"></a>
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
                <li><a href="../recherche/recherche.php" class="link active">Recherche</a></li>
                <li><a href="../formulaire/formulaire.php" class="link">Formulaire</a></li>
                <li><a href="../proposerRecette/proposRecette.php" class="link">Propose ta recette</a></li>
                <?php if($_SESSION['admin'] == true) {echo "<li><a href='../backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";} ?>
            </ul>
        </div>
        <div class="boutonConnexion">
            <?php if($_SESSION['connecter'] == false){ ?>
                <a href="../connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se connecter</button></a>
            <?php } elseif ($_SESSION['connecter'] == true) { ?>
                <div class="user-info" style="padding-right: 50px;">
                    <div class="dropdown"style="padding-right: 10px;">
                        <div class="user-circle">
                            <i class="fas fa-user" style="color: black;" onclick="toggleDropdown()"></i>
                        </div>
                        <div class="dropdown-content" id="dropdownContent">
                            <a href="../connexion/deconnexion.php">Se déconnecter</a>
                        </div>
                    </div>
                    <span style="color: white;"><?php echo $_SESSION['login_username']; ?></span>
                </div>
            <?php } ?>
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

                    include '../bd.php';
                    $conn=connexionBd();

                    $temps = "SELECT temps_min_ as temps
                        FROM recette
                        WHERE nom = '$recipeName'";

                    $resultTps = $conn->query($temps);

                    foreach ($resultTps as $tps) {
                        echo '<p><b>Temps de préparation : </b>' . $tps['temps'] . ' min</p>';
                    }

                    $dif = "SELECT niveau_difficulte as dif
                        FROM recette
                        WHERE nom = '$recipeName'";

                    $resultDif = $conn->query($dif);

                    foreach ($resultDif as $dif) {
                        echo '<p><b>Difficulté : </b>' . $dif['dif'] . '</p>';
                    }

                    echo '<p id="recipe-prix" class="recipe-prix"></p>';

                    echo '<button class="btn white-btn" onclick="goBack()">Liste des recettes</button>';

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

                    deconnexionBd($conn);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="region region-footer1">
                    <section id="block-block-1" class="block block-block clearfix">
                        <p>@&nbsp;Equipe Edu'Cook<br />
                            Tous droits réservés<br />
                            <a class="lien" href="../newsletter/politique_confidentialite.html">Politique de confidentialité</a>
                        </p>
                    </section>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 news">
                <div class="region region-footer2">
                    <section id="block-block-2" class="block block-block clearfix">
                        <p>Notre Newsletter : </p>
                        <a class="btn_footer" href="../newsletter/newsletter.html">Accès au Newsletter</a>
                    </section>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 news">
                <div class="region region-footer3">
                    <section id="block-block-3" class="block block-block clearfix">
                        <p>L'équipe :<br />
                        <a class="lien" href="../equipe/equipe.php">En savoir plus sur l'équipe !</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</footer>

    <script src="../commun/commun.js"></script>

    <script>
        function goBack() {
            window.history.back();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const recipeName = urlParams.get('recipeName');
            const recipeCategory = urlParams.get('recipeCategory');
            const recipeDescription = urlParams.get('recipeDescription');
            const recipeImageSrc = urlParams.get('recipeImageSrc');
            const recipePrix = urlParams.get('recipePrix');

            document.getElementById('recipe-name').textContent = recipeName;
            document.getElementById('recipe-category').innerHTML = "<b>Catégorie : </b>" + recipeCategory;
            document.getElementById('recipe-description').innerHTML = "<b>Description : </b>" + recipeDescription;
            document.getElementById('recipe-image').src = "../" + recipeImageSrc;
            document.getElementById('recipe-prix').innerHTML = "<b>Prix : </b>" + recipePrix + " €";
        });
    </script>
</body>

</html>