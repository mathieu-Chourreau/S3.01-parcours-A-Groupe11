<?php
session_start();

$searchText = isset($_GET['barreDeRecherche']) ? $_GET['barreDeRecherche'] : '';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="recherche.css">
    <link rel="stylesheet" href="../commun/commun.css">
    <title>Edu'Cook</title>
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

    <div class="search">
        <input type="text" id="searchInput" value="<?php echo htmlspecialchars($searchText); ?>" placeholder="Rechercher une recette...">
    </div>

    <div class="conditions">
        <select id="timeDropdown" class="form-select">
            <option value="0">Temps de préparation (min)</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
        </select>
        <select id="difDropdown" class="form-select">
            <option value="rien">Difficulté de la recette</option>
            <option value="Facile">Facile</option>
            <option value="Moyen">Moyen</option>
            <option value="Difficile">Difficile</option>
        </select>
        <input type="text" id="inputPrix" placeholder="Prix maximum">
    </div>


    <div class="bouttonveg">
        <h3>Afficher uniquement les recettes végétariennes</h3>
        <label class="switch">
            <input type="checkbox" id="vegBouton" onclick="veg()">
            <span class="slider"></span>
        </label>
    </div>

    <section class="s_recherche">
        <?php
        include 'touteRecette.php';

        $conn = connexionBd();

        $recetteValide = "SELECT r.identifiant AS ID, r.nom AS nom_recette, r.image AS imageR, r.instruction AS instruction, cr.gout AS categorie_recette, r.temps_min_ AS temps, r.niveau_difficulte AS dif
        FROM recette r
        JOIN appartenirrc a ON a.identifiantR = r.identifiant
        JOIN categorierecette cr ON a.identifiantC = cr.identifiant
        ORDER BY r.identifiant;";

        $resultRecette = $conn->query($recetteValide);

        foreach ($resultRecette as $rec) {
            echo '<div class="card-grid">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="image-container">';
            echo '<img src="../' . $rec['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . $rec['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $rec['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $rec['instruction'] . '</p>';
            echo '<p class="dif"><b>Niveau de difficulté : </b>' . $rec['dif'] . '</p>';
            echo '<p class="tempsP"><b>Temps : </b>' . $rec['temps'] . ' min</p>';
            echo '<p class="prixP"><b>Prix : </b>' . $listeRecette[$rec['nom_recette']] . ' €</p>';
            if(isset($rec['imageR'])){
                echo '<a href="details.php?recipeName=' . urlencode($rec['nom_recette']) . '&recipeCategory=' . urlencode($rec['categorie_recette']) . '&recipeDescription=' . urlencode($rec['instruction']) . '&recipeImageSrc=' . urlencode($rec['imageR']) . '&recipePrix=' . urlencode($listeRecette[$rec['nom_recette']]) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
            }
            if(!(isset($rec['imageR']))){
                echo '<a href="details.php?recipeName=' . urlencode($rec['nom_recette']) . '&recipeCategory=' . urlencode($rec['categorie_recette']) . '&recipeDescription=' . urlencode($rec['instruction']) . '&recipePrix=' . urlencode($listeRecette[$rec['nom_recette']]) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        deconnexionBd($conn);
        ?>

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
        var boutton = document.getElementsByClassName("bouttonveg");
        function filterRecipes() {
            var searchText = document.getElementById('searchInput').value.toLowerCase();
            var isVegetarian = document.getElementById("vegBouton").checked;
            var selectedTime = parseInt(document.getElementById('timeDropdown').value);
            var inputPrix = document.getElementById('inputPrix').value;
            var selectedDif = document.getElementById('difDropdown').value

            console.log(selectedDif);

            var recipes = document.querySelectorAll('.card');

            recipes.forEach(function(recipe) {    
                var recipeName = recipe.querySelector('.card-title').textContent.toLowerCase();
                var recipeType = recipe.querySelector('.typeP').textContent.toLowerCase();
                var recipeTime = recipe.querySelector('.tempsP').textContent.substring(8, 10);
                var recipeDif = recipe.querySelector('.dif').textContent.substring(23);
                var recipePrixP = recipe.querySelector('.prixP').textContent;
                var Prix = recipePrixP.substring(7, recipePrixP.length - 2);

                console.log(recipeDif);

                var showRecipe = true;

                if ((searchText !== '' && !recipeName.includes(searchText)) ||
                    (isVegetarian && !recipeType.includes("végétarien")) ||
                    (selectedTime !== 0 && recipeTime > selectedTime) ||
                    (inputPrix !== '' && inputPrix < Prix) ||
                    (selectedDif !== 'rien' && selectedDif !== recipeDif)) {
                    showRecipe = false;
                }

                recipe.style.display = showRecipe ? 'block' : 'none';
            });
        }
        
        document.addEventListener("DOMContentLoaded", filterRecipes);
        document.getElementById('searchInput').addEventListener('input', filterRecipes);
        document.getElementById('vegBouton').addEventListener('change', filterRecipes);
        document.getElementById('timeDropdown').addEventListener('change', filterRecipes);
        document.getElementById('inputPrix').addEventListener('input', filterRecipes);
        document.getElementById('difDropdown').addEventListener('change', filterRecipes);

    </script>
</body>

</html>