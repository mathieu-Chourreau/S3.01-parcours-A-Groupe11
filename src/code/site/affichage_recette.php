<?php include 'main.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Détails de la recette</title>
    <link rel="stylesheet" href="resultat_formulaire.css">
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
   
    <section class="s_recherche">
        <?php
        include 'bd.php';

        $topIngredients = array_slice($lRecettePoint, 0, 5);

        var_dump($topIngredients);

        /*$myString = implode(",", $topIngredients);

       

        $recetteValide = "SELECT r.identifiant, r.nom AS nom_recette, r.image AS imageR, r.instruction AS instruction, cr.gout AS categorie_recette, r.temps_min_ AS temps, r.niveau_difficulte AS dif
        FROM recette r
        JOIN appartenirrc a ON a.identifiantR = r.identifiant
        JOIN categorierecette cr ON a.identifiantC = cr.identifiant
        WHERE r.nom IN (?)";

        // Préparation de la requête
        $stmt = $conn->prepare($recetteValide);

        // Liaison des paramètres
        $stmt->bind_param("s", $myString);

        $stmt->execute();

        $result = $stmt->get_result();*/

        foreach ($topIngredients as $key => $recette) {
            # code...
            // Faire quelque chose avec chaque résultat
            echo '<div class="card-grid">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="image-container">';
            echo '<img src="' . $recette['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . $recette['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $recette['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $recette['instruction'] . '</p>';
            echo '<p class="card-text"><b>Niveau de difficulté : </b>' . $recette['dif'] . '</p>';
            echo '<p class="card-text"><b>Temps : </b>' . $recette['temps'] . '</p>';
            echo '<a href="details.php?recipeName=' . urlencode($recette['nom_recette']) . '&recipeCategory=' . urlencode($recette['categorie_recette']) . '&recipeDescription=' . urlencode($recette['instruction']) . '&recipeImageSrc=' . urlencode($recette['imageR']) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
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

</body>
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
    const menuHamburger = document.getElementById("burger");
    const navLinks = document.querySelector(".divdeux");
    menuHamburger.addEventListener('click', () => { navLinks.classList.toggle('mobile-menu') });
</script>
</html>