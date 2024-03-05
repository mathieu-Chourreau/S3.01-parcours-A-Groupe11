<?php
session_start();
if (!isset($_SESSION['connecter'])) {
    $_SESSION['connecter'] = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="index.css">
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
                <?php if($_SESSION['connecter'] == false){ ?>
                <button class="btn white-btn" id="loginBtn"><a href="connexion.php" id="lien_se_connecter">Se connecter</a></button>
                <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
            </div>
        </nav>
    </div>


    <h1 class="titre">C'est l'heure de manger mieux pour très peu !</h1>

    <div class="box">
        <form>
            <input type="text" name="" placeholder="Ex: Pâtes à la carbonara">
            <input type="submit" name="" value="Rechercher">
        </form>
    </div>
    <footer class="footer">
    </footer>

</body>
</html>