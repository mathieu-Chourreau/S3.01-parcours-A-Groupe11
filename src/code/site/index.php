<?php
session_start();
if (!isset($_SESSION['connecter'])) {
    $_SESSION['connecter'] = false;
}
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = false;
}
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
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="commun/commun.css">
    <title>Edu'Cook</title>
</head>
<body>
    <nav id="nav">
        <div id="imgLogoNav">
            <a href="#"><img class="img_logo" src="image/logo.png"></a>
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
                <li><a href="#" class="link active">Accueil</a></li>
                <li><a href="recherche/recherche.php" class="link">Rechercher</a></li>
                <li><a href="formulaire/formulaire.php" class="link">Formulaire</a></li>
                <li><a href="equipe/equipe.php" class="link">L'équipe</a></li>
                <li><a href="proposerRecette/proposRecette.php" class="link">Proposer votre recette</a></li>
                <?php if($_SESSION['admin'] == false){ ?>
                <?php }elseif ($_SESSION['admin'] == true) {echo "<li><a href='backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";} ?>
            </ul>
        </div>
        <div class="boutonConnexion">
            <?php if($_SESSION['connecter'] == false){ ?>
                <a href="connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se connecter</button></a>
            <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
        </div>
    </nav>

    <div class="flou"></div>
    <h1 class="titre">C'est l'heure de manger mieux pour très peu !</h1>

    <div class="box">
        <form action="recherche/recherche.php" method="GET">
            <input type="text" name="barreDeRecherche" placeholder="Ex: Pâtes à la carbonara">
            <input type="submit" name="" value="Rechercher">
        </form>
    </div>
    
    <footer class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="region region-footer1">
                        <section id="block-block-1" class="block block-block clearfix">
                            <p>@&nbsp;Equipe Edu'Cook<br />
                                Tous droits réservés<br />
                                <a class="lien" href="newsletter/politique_confidentialite.html">Politique de confidentialité</a>
                            </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 news">
                    <div class="region region-footer2">
                        <section id="block-block-2" class="block block-block clearfix">
                            <p>Notre Newsletter : </p>
                            <a class="btn_footer" href="newsletter/newsletter.html">Accès au Newsletter</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="commun/commun.js"></script>

</body>
</html>