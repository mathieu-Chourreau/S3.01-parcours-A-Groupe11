<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="recherche.css">
    <link rel="stylesheet" href="commun/commun.css">
    <title>Edu'Cook</title>
</head>

<body>
    <nav id="nav">
        <div id="imgLogoNav">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
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
                <li><a href="#" class="link">Accueil</a></li>
                <li><a href="#" class="link active">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
                <li><a href="#" class="link">Proposer votre recette</a></li>
                <li><a href="#" class="link">Se connecter</a></li>
            </ul>
        </div>
        <div class="boutonConnexion">
            <button class="btn white-btn" id="loginBtn">Se connecter</button>
        </div>
    </nav>

    <div class="search">
        <input type="text" id="searchInput" placeholder="Rechercher une recette...">
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
        include 'bd.php';
        $conn = connexionBd();

        $recetteValide = "SELECT r.identifiant, r.nom AS nom_recette, r.image AS imageR, r.instruction AS instruction, cr.gout AS categorie_recette, r.temps_min_ AS temps, r.niveau_difficulte AS dif
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
            echo '<img src="' . $rec['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . $rec['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $rec['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $rec['instruction'] . '</p>';
            echo '<p class="card-text"><b>Niveau de difficulté : </b>' . $rec['dif'] . '</p>';
            echo '<p class="card-text"><b>Temps : </b>' . $rec['temps'] . '</p>';
            echo '<a href="details.php?recipeName=' . urlencode($rec['nom_recette']) . '&recipeCategory=' . urlencode($rec['categorie_recette']) . '&recipeDescription=' . urlencode($rec['instruction']) . '&recipeImageSrc=' . urlencode($rec['imageR']) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
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
                <div class="col-md-6 col-sm-12">
                    <div class="region region-footer1">
                        <section id="block-block-1" class="block block-block clearfix">
                            <p>@&nbsp;Equipe Edu'Cook<br />
                                Tous droits réservés<br />
                                <a class="lien" href="politique_confidentialite.html">Politique de confidentialité</a>
                            </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 news">
                    <div class="region region-footer2">
                        <section id="block-block-2" class="block block-block clearfix">
                            <p>Notre Newsletter : </p>
                            <a class="btn_footer" href="newsletter.html">Accès au Newsletter</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="commun/commun.js"></script>

    <script>
        var boutton = document.getElementsByClassName("bouttonveg");
        function veg() {
            var checkbox = document.getElementById("vegBouton");
            var classCard = document.querySelectorAll(".card");

            if (checkbox.checked) {
                for (var cards of classCard) {
                    if (!(cards.querySelector(".typeP").textContent.includes("Végétarien"))) {
                        cards.style.display = 'none';
                    }
                    if (cards.querySelector(".typeP").textContent.includes("Végétarien")) {
                        cards.style.display = 'block';
                    }
                }
            } else {
                for (var cards of classCard) {
                    cards.style.display = 'block';
                }
            }
        }

        function filterRecipes() {
            var searchText = document.getElementById('searchInput').value.toLowerCase();
            var recipes = document.querySelectorAll('.card');

            recipes.forEach(function (recipe) {
                var recipeName = recipe.querySelector('.card-title').textContent.toLowerCase();

                if (recipeName.includes(searchText)) {
                    recipe.style.display = 'block';
                } else {
                    recipe.style.display = 'none';
                }
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterRecipes);

    </script>
</body>

</html>