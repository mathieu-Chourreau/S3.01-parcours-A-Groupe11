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
                <a href="index.html">
                    <img class="img_logo" src="image/logo.png">
                </a>
            </div>
            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="#" class="link active">Accueil</a></li>
                    <li><a href="#" class="link">Rechercher</a></li>
                    <li><a href="#" class="link">Formulaire</a></li>
                    <li><a href="#" class="link">L'équipe</a></li>
                </ul>
            </div>
            <div class="nav-button">
                <button class="btn white-btn" id="loginBtn" onclick="login()">Se connecter</button>
                <button class="btn" id="registerBtn" onclick="register()">S'enregistrer</button>
            </div>
        </nav>
    </div>

    <h1 class="phraseProp">Proposer votre recette !</h1>

    <div class="bigbox">
        <div class="box">
            <form id= "form1" action = "traiter.php" method ="post">
                <input id = "nom" type="text" name="nom" placeholder="Nom de la recette">
                <input id = "description" type="textaera" rows="5" cols="33" name="description" placeholder="description">
                <input id = "poid" type="text" name="poid" placeholder="poids">
                <input id = "nom" type="text" name="preparation" placeholder="temps de preparation">
            </form>
        </div>
        <div class="box2">
            <form id= "form2" action = "traiter.php" method = "post">
                <select class="difficulte" name="difficulte" id="niveau">
                    <option value="0">Choisir la difficulte :</option>
                    <option value="Facile">Facile</option>
                    <option value="Moyen">Moyen</option>
                    <option value="Difficile">Difficile</option>
                </select>
                <input id = "categorie" type="text" name="" placeholder="categorie de la recette">
                <input type="submit" value="reinitialiser">
            </form>
            <button class = "valid" id="annulert" type="submit">Annuler</button>
            <button class = "valid" id="validerTout" type="submit" form="form1 form2">Valider tout</button>
        </div>
    </div>
    <script type="text/javascript" src="proposRecette.js"></script>
    <footer class="footer">
    </footer>

</body>
</html>