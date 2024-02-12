<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css">
    <title>Page de connexion</title>
</head>

<header>
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
        </nav>
    </div>
</header>
<body>
    <div class="container">
    <form action="traitement_connexion.php" method="post">
        <h1>Se connecter</h1>        
        <div class="inputs">
          <input type="text" id="email" name="email" placeholder="Email" />
          <input type="text" id="password" name="password" placeholder="Mot de passe">
        </div>
        
        <div align="center">
          <button class="connecter" type="submit">Se connecter</button>
          <div class="compte"><a href="creeCompte.html">Creer mon compte</a></div>
        </div>
    </form>
    </div>
</body>

</html>
