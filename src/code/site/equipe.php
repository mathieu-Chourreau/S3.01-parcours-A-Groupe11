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
    <link rel="stylesheet" href="equipe.css">
    <title>Edu'Cook</title>
</head>
<body>
    
    <div class="wrapper">
        <nav class="na">
            <div class="log">
                <a href="index.php">
                    <img class="img_log" src="image/logo.png">
                </a>
            </div>
            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="index.php" class="link">Accueil</a></li>
                    <li><a href="#" class="link">Rechercher</a></li>
                    <li><a href="#" class="link">Formulaire</a></li>
                    <li><a href="#" class="link">L'équipe</a></li>
                    <li><a href="proposRecette.php" class="link active">Proposer votre recette</a></li>
                </ul>
            </div>
            <div class="nav-button">
                <?php if($_SESSION['connecter'] == false){ ?>
                <button class="btn white-btn" id="loginBtn"><a href="connexion.php" id="lien_se_connecter">Se connecter</a></button>
                <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
            </div>
        </nav>
    </div>
    <div class="flou"></div>
    <h1 class="phraseProp">Présentation de l'équipe Edu'Cook</h1>

    <div class="bigbox">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="image/mathieu.jpeg" alt="Mathieu Chourreau">
                <div class="card-body">
                    <h3>Présentation :</h3>
                    <p class="card-text">Je suis un étudiant de 19 ans vivant à Toulouse et étudiant à Anglet. Je pratique le triathlon depuis l’âge de 5 ans. Ma détermination et ma combativité sont des traits de caractère qui me définissent. Grâce à ma passion pour le triathlon, j'ai développé une forte motivation pour atteindre mes objectifs personnels et sportifs. </p>
                </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="image/nathan.jpeg" alt="Nathan Piel ">
                <div class="card-body">
                    <h3>Présentation :</h3>
                    <p class="card-text">Étudiant de 19 ans vivant à Anglet pour mes études mais originaire de Bordeaux. Je me suis dirigé vers l’informatique car c’est un secteur qui sera beaucoup sollicité dans le futur. J'ai fait de la musique pendant 7 ans et je pratique le tennis. J’apprécie beaucoup cette formation car je vois la programmation comme un jeu.</p>
                </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="image/leo.jpeg" alt="Léo Fermé">
                <div class="card-body">
                    <h3>Présentation :</h3>
                    <p class="card-text">Étudiant de 19 ans vivant à Anglet pour mes études mais originaire de Bordeaux. Je me suis dirigé vers l’informatique car c’est un secteur qui sera beaucoup sollicité dans le futur. J'ai fait de la musique pendant 7 ans et je pratique le tennis. J’apprécie beaucoup cette formation car je vois la programmation comme un jeu.</p>
                </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="image/souleymen.jpeg" alt="Souleymen Zaza">
                <div class="card-body">
                    <h3>Présentation :</h3>
                    <p class="card-text">J’ai 19 ans, je suis un étudiant du BUT informatique à l’IUT d’Anglet. J’ai un profil plus scientifique que littéraire ce qui m’a poussé à continuer mes études dans l’informatique car c’est la spécialité que je préférais. Le fait que je ne sois pas très scolaire me pose problème dans certaines matières mais malgré ça je m’en sors plutôt bien. </p>
                </div>
        </div>
    </div>
    <footer class="footer"> 
    </footer>

</body>
</html>