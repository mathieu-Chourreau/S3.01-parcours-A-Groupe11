<?php
session_start();
include '../bd.php'
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="proposRecette.css">
    <link rel="stylesheet" href="../commun/commun.css">    
    <title>Edu'Cook</title>
</head>
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
                <li><a href="../recherche/recherche.php" class="link">Rechercher</a></li>
                <li><a href="../formulaire/formulaire.php" class="link">Formulaire</a></li>
                <li><a href="../equipe/equipe.php" class="link">L'équipe</a></li>
                <li><a href="#" class="link active">Proposer votre recette</a></li>
                <?php if($_SESSION['admin'] == false){ ?>
                <?php }elseif ($_SESSION['admin'] == true) {echo "<li><a href='../backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";} ?>
            </ul>
        </div>
        <div class="boutonConnexion">
            <?php if($_SESSION['connecter'] == false){ ?>
                <a href="../connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se connecter</button></a>
            <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='../connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
        </div>
    </nav>

    <?php
    if ($_SESSION['connecter'] == true) {
    ?>
    <div class="flou"></div>
    <h1 class="phraseProp">Proposer votre recette !</h1>

    <div class="bigbox">
        <form id="formulaireUnique" action="traiter.php" method="post">
            <div class="box">
                <label for="nom">Nom de la recette</label>
                <input id="nom" type="text" name="nom" placeholder="Nom de la recette" required>
                <label for="description">Nom de la recette</label>
                <input id="description" type="textarea" rows="5" cols="33" name="description" placeholder="Description" required>
                <label for="preparation">Nom de la recette</label>
                <input id="preparation" type="number" name="tpsPreparation" placeholder="Temps de préparation(minute)" min ="0" onkeyup="if(this.value<0){this.value= this.value * -1}">
            </div>
            <div class="box2">
                <select class="difficulte" name="difficulte" id="niveau">
                    <option value="0" selected disabled>Choisir la difficulté :</option>
                    <option value="Facile">Facile</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Difficile">Difficile</option>
                </select>
                <div id="searchContainer">
                    <input type="text" id="searchInput" placeholder="Rechercher un ingrédient...">
                </div>
                <div id="checkboxContainer">
                <?php
                    $conn = connexionBd();
                    // Requête SQL pour récupérer les ingrédients
                    $sql = "SELECT nom, prixKg FROM ingredient";
                    $result = $conn->query($sql);

                    // HTML des cases à cocher
                    $checkboxesHTML = '';

                    // Vérifier s'il y a des résultats
                    if ($result->num_rows > 0) {
                        // Récupérer chaque ligne de résultat
                        while($row = $result->fetch_assoc()) {
                            $checkboxesHTML .= '<label class="ingredient-checkbox"><input type="checkbox" name="ingredients[]" value="' . $row["nom"] . '">' . $row["nom"] . '</label><br>';
                        }
                    }

                    // Fermer la connexion à la base de données
                    $conn->close();

                    echo $checkboxesHTML;
                ?>
                </div>
                <button class="valid annuler" id="annuler" type="button">Annuler</button>
                <input class = "valid valider" type="submit" value = "valider" id = "validerTout">
            </div>
        </form>
    </div>

    <script src="../commun/commun.js"></script>

    <script type="text/javascript" src="proposRecette.js"></script>
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

</body>
</html>