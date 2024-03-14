<?php

session_start();

include_once '../bd.php';

// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si l'utilisateur est connecté
    if ($_SESSION['connecter'] == true) {

        if ($_POST['num_form'] == 2) {
            // Récupérer les valeurs du formulaire 2
            $vege = $_POST['vege'];
            $prix = $_POST['zone_prix'];
            $temps = $_POST['zone_temps'];
            $user_id = $_SESSION['login_username'];

            $conn = connexionBd();

            // Supprimer toutes les lignes pour cet utilisateur
            $sql_delete = "DELETE FROM preferencesComplementaires WHERE nom_utilisateur = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("s", $_SESSION['login_username']);
            $stmt_delete->execute();

            deconnexionBd($stmt_delete);
            deconnexionBd($conn);


            $conn = connexionBd();
            
            $stmt = $conn->prepare("INSERT INTO preferencesComplementaires (nom_utilisateur, vege_pref, budget, tempsCuisine) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sddi", $user_id, $vege, $prix, $temps);
            $stmt->execute();

            deconnexionBd($stmt);
            deconnexionBd($conn);

        }
    } else {
        header("Location: ../connexion/connexion.php"); // Redirige l'utilisateur vers la page de connexion si non connecté
        exit;
    }

    include_once 'main.php';
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <li><a href="../recherche/recherche.php" class="link">Recherche</a></li>
                <li><a href="../formulaire/formulaire.php" class="link active">Formulaire</a></li>
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

        <div class="background"></div>
        <h1 class="titre"> Voici nos meilleurs recettes pour vous ! </h1>
        <section class="s_recherche">
            <?php
            include_once '../recherche/touteRecette.php';

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
            $stmt->bind_param("sssss", $topIngredients[0]['recette'], $topIngredients[1]['recette'], $topIngredients[2]['recette'], $topIngredients[3]['recette'], $topIngredients[4]['recette']);

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
                echo '<p><b>Correspondance avec vos préférences : </b>' . ($topIngredients[$indice]['point'])/2 . '%</p>';
                echo '<h4 class="card-title">' . $row['nom_recette'] . '</h4>';
                echo '<p class="typeP"><b>Catégorie : </b>' . $row['categorie_recette'] . '</p>';
                echo '<p class="card-text"><b>Description : </b>' . $row['instruction'] . '</p>';
                echo '<p class="card-text"><b>Niveau de difficulté : </b>' . $row['dif'] . '</p>';
                echo '<p class="card-text"><b>Temps : </b>' . $row['temps'] . ' min</p>';
                echo '<p class="card-text"><b>Prix : </b>' . $listeRecette[$row['nom_recette']] . ' €</p>';
                echo '<a href="../recherche/details.php?recipeName=' . urlencode($row['nom_recette']) . '&recipeCategory=' . urlencode($row['categorie_recette']) . '&recipeDescription=' . urlencode($row['instruction']) . '&recipeImageSrc=' . urlencode($row['imageR']) . '&recipePrix=' . urlencode($listeRecette[$rec['nom_recette']]) . '" class="btn-details"><button class="btn white-btn">Voir les détails</button></a>';
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
    <?php } else {
    header("Location: ../connexion/connexion.php");
    exit;
} ?>
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