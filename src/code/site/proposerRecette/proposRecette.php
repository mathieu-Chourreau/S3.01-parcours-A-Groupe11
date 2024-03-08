<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="proposRecette.css">
    link:j
    <title>Edu'Cook</title>
</head>
<body>
    
    <div class="wrapper">
        <nav class="nav">
            <div class="logo">
                <a href="index.php">
                    <img class="img_logo" src="image/logo.png">
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
    <?php
    if ($_SESSION['connecter'] == true) {
    ?>
    <div class="flou"></div>
    <h1 class="phraseProp">Proposer votre recette !</h1>

    <div class="bigbox">
    <form id="formulaireUnique" action="traiter.php" method="post">
        <div class="box">
            <input id="nom" type="text" name="nom" placeholder="Nom de la recette" required>
            <input id="description" type="textarea" rows="5" cols="33" name="description" placeholder="Description" required>
            <input id="poid" type="number" name="poid" placeholder="Poids" min ="0" onkeyup="if(this.value<0){this.value= this.value * -1}">
            <input id="preparation" type="number" name="tpsPreparation" placeholder="Temps de préparation" min ="0" onkeyup="if(this.value<0){this.value= this.value * -1}">
        </div>
        <div class="box2">
            <select class="difficulte" name="difficulte" id="niveau">
                <option value="0" selected disabled>Choisir la difficulté :</option>
                <option value="Facile">Facile</option>
                <option value="Moyen">Moyen</option>
                <option value="Difficile">Difficile</option>
            </select>
            <input id="categorie" type="text" name="categorie" placeholder="Catégorie de la recette">
            <button class="valid annuler" id="annuler" type="button">Annuler</button>
            <input class = "valid valider" type="submit" value = "valider" id = "validerTout">
        </div>
    </form>
    </div>
    <script type="text/javascript" src="proposRecette.js"></script>
    <?php }else {
        header("Location: ../connexion/connexion.php");
        exit;
    } ?>
    <footer class="footer">
    </footer>

</body>
</html>