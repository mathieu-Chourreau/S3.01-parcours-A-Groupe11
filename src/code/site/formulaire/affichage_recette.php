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

    <?php
    if ($_SESSION['connecter'] == true) {
    ?>

    <div class="background"></div>
    <h1 class="titre"> Voici nos meilleurs recettes pour vous ! </h1>
    <section class="s_recherche">
        <?php
        include '../bd.php';

        $conn = connexionBd();

        $topIngredients = array_slice($lRecettePoint, 0, 5);

        //$myString = "'" . implode("','", array_column($topIngredients, 'recette')) . "'";

        $recetteValide = "SELECT r.identifiant, r.nom AS nom_recette, r.image AS imageR, r.instruction AS instruction, cr.gout AS categorie_recette, r.temps_min_ AS temps, r.niveau_difficulte AS dif
        FROM recette r
        JOIN appartenirrc a ON a.identifiantR = r.identifiant
        JOIN categorierecette cr ON a.identifiantC = cr.identifiant
        WHERE r.nom IN (?, ?, ?, ?, ?)";

        // Préparation de la requête
        $stmt = $conn->prepare($recetteValide);

        // Liaison des paramètres
        $stmt->bind_param("sssss",  $topIngredients[0]['recette'], $topIngredients[1]['recette'], $topIngredients[2]['recette'], $topIngredients[3]['recette'], $topIngredients[4]['recette']);

        $stmt->execute();

        $result = $stmt->get_result();
        $indice = 0;

            

        while ($row = $result->fetch_assoc()) {
            
            echo '<div class="card-grid">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="image-container">';
            echo '<img src="' . $row['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<p><b>Points : </b>' .$topIngredients[$indice]['point'] . '</p>';
            echo '<h4 class="card-title">' . $row['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $row['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $row['instruction'] . '</p>';
            echo '<p class="card-text"><b>Niveau de difficulté : </b>' . $row['dif'] . '</p>';
            echo '<p class="card-text"><b>Temps : </b>' . $row['temps'] . '</p>';
            echo '<a href="details.php?recipeName=' . urlencode($row['nom_recette']) . '&recipeCategory=' . urlencode($row['categorie_recette']) . '&recipeDescription=' . urlencode($row['instruction']) . '&recipeImageSrc=' . urlencode($row['imageR']) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            $indice = $indice + 1;

        }

        deconnexionBd($conn);
        ?>

    </section>
    <?php }else {
        header("Location: ../connexion/connexion.php");
        exit;
    } ?>

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