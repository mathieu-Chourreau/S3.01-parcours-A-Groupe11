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
    <title>Edu'Cook</title>
</head>

<body>
    <nav id="nav">
        <div id="divun">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
        </div>
        <div class="divdeux">
            <ul id="menu">
                <li><a href="#" class="link active">Accueil</a></li>
                <li><a href="#" class="link">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
            </ul>
        </div>
        <div class="ham">
            <div class="line" id="un"></div>
            <div class="line" id="deux"></div>
            <div class="line" id="trois"></div>
        </div>
        <div id="rien"></div>
        <img id="burger" src="image/fleur1.jpg">
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

    <section class="">
        <?php
        include 'bd.php';

        $recetteValide = "SELECT r.nom AS nom_recette, r.image AS imageR, r.instruction as instruction, cr.gout AS categorie_recette
        FROM recette r
        JOIN appartenirrc a ON a.identifiantR = r.identifiant
        JOIN categorierecette cr ON a.identifiantC = cr.identifiant
        ORDER BY nom_recette;";

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
            echo '<a href="details.php?recipeName=' . urlencode($rec['nom_recette']) . '&recipeCategory=' . urlencode($rec['categorie_recette']) . '&recipeDescription=' . urlencode($rec['instruction']) . '&recipeImageSrc=' . urlencode($rec['imageR']) . '" class="btn-details">Voir les détails</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </section>

    <footer class="footer">
    </footer>

    <script>
        const menuHamburger = document.getElementById("burger");
        const navLinks = document.querySelector(".divdeux");
        menuHamburger.addEventListener('click', () => { navLinks.classList.toggle('mobile-menu') });

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