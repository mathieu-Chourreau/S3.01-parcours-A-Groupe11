<?php include_once 'main.php';
 ?>
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
    <link rel="stylesheet" href="../commun/commun.css">

</head>
<?php
    if ($_SESSION['connecter'] == true) {
    ?>
<body>
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
                <?php if($_SESSION['admin'] == false){ ?>
                <?php }elseif ($_SESSION['admin'] == true) {echo "<li><a href='../backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";} ?>
            </ul>
        </div>
        <div class="boutonConnexion">
            <?php if($_SESSION['connecter'] == false){ ?>
                <a href="connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se connecter</button></a>
            <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='../connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
        </div>
    </nav>

    <div class="background"></div>
    <h1 class="titre"> Voici nos meilleurs recettes pour vous ! </h1>
    <section class="s_recherche">
        <?php
        include_once '../bd.php';

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
            echo '<img src="../' . $row['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<p><b>Points : </b>' .$topIngredients[$indice]['point'] . '</p>';
            echo '<h4 class="card-title">' . $row['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $row['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $row['instruction'] . '</p>';
            echo '<p class="card-text"><b>Niveau de difficulté : </b>' . $row['dif'] . '</p>';
            echo '<p class="card-text"><b>Temps : </b>' . $row['temps'] . '</p>';
            echo '<a href="../recherche/details.php?recipeName=' . urlencode($row['nom_recette']) . '&recipeCategory=' . urlencode($row['categorie_recette']) . '&recipeDescription=' . urlencode($row['instruction']) . '&recipeImageSrc=' . urlencode($row['imageR']) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            $indice = $indice + 1;

        }
        deconnexionBd($stmt);
        deconnexionBd($conn);
        ?>

    </section>
    <?php }else {
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
                                <a class="lien" href="../newsletter/politique_confidentialite.html">Politique de confidentialité</a>
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