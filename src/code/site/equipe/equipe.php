<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="equipe.css">
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
                <li><a href="../recherche/recherche.php" class="link">Recherche</a></li>
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



    <h1 class="phraseProp">Présentation de l'équipe Edu'Cook</h1>

    <div class="bigbox row">
        <div class="card col-md-6 col-lg-3 mb-3">
            <img class="card-img-top" src="../image/mathieu.jpeg" alt="Mathieu Chourreau">
            <div class="card-body">
                <h3>Mathieu Chourreau</h3>
                <p class="card-text">Je suis un étudiant de 19 ans vivant à Toulouse et étudiant à Anglet. Je pratique le triathlon depuis l’âge de 5 ans. Ma détermination et ma combativité sont des traits de caractère qui me définissent. Grâce à ma passion pour le triathlon, j'ai développé une forte motivation pour atteindre mes objectifs personnels et sportifs. </p>
            </div>
        </div>
        <div class="card col-md-6 col-lg-3 mb-3">
            <img class="card-img-top" src="../image/nathan.jpeg" alt="Nathan Piel ">
            <div class="card-body">
                <h3>Nathan Piel</h3>
                <p class="card-text">Étudiant de 19 ans cherchant encore sa vocation dans toutes les branches que dispose l’informatique, je touche un peu a tout dans tous les domaines. Je suis toujours présent quand il s’agit de travailler et de mener à bien une mission qui m’est donnée et n'hésite pas à donner son avis même s’il est négatif afin de faire avancer l’équipe dans le bon sens. </p>
            </div>
        </div>
        <div class="card col-md-6 col-lg-3 mb-3">
            <img class="card-img-top" src="../image/leo.jpeg" alt="Léo Fermé">
            <div class="card-body">
                <h3>Léo Fermé</h3>
                <p class="card-text">Étudiant de 19 ans vivant à Anglet pour mes études mais originaire de Bordeaux. Je me suis dirigé vers l’informatique car c’est un secteur qui sera beaucoup sollicité dans le futur. J'ai fait de la musique pendant 7 ans et je pratique le tennis. J’apprécie beaucoup cette formation car je vois la programmation comme un jeu.</p>
            </div>
        </div>
        <div class="card col-md-6 col-lg-3 mb-3">
            <img class="card-img-top" src="../image/souleymen.jpeg" alt="Souleymen Zaza">
            <div class="card-body">
                <h3>Souleymen Zaza</h3>
                <p class="card-text">J’ai 19 ans, je suis un étudiant du BUT informatique à l’IUT d’Anglet. J’ai un profil plus scientifique que littéraire ce qui m’a poussé à continuer mes études dans l’informatique car c’est la spécialité que je préférais. Le fait que je ne sois pas très scolaire me pose problème dans certaines matières mais malgré ça je m’en sors plutôt bien. </p>
            </div>
        </div>
    </div>
    
    <script src="../commun/commun.js"></script>

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
                        <a class="lien" href="equipe.php">En savoir plus sur l'équipe !</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
