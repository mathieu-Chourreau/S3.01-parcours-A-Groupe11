<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="recherche.css">
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

        <div>
            <form>
                <input type="submit" name="" value="Toutes les recettes">
                <input type="submit" name="" value="Végétarien">
            </form>
            <section>
            <a href="couronne.php"><img class="section" src="1.jpg"></a>
            <div class="texteSection">
                <p>Un texte est une série orale ou écrite de mots perçus comme constituant un ensemble cohérent, porteur de sens et utilisant les structures propres à une langue (conjugaisons, construction et association des phrases…). Un texte n'a pas de longueur déterminée sauf dans le cas de poèmes à forme fixe comme le sonnet ou le haïku.</p>
                <a href="couronne.php"><button>Voici nos couronnes</button></a>
            </div>
            <?php
            /*
            include 'bd.php';

            $recetteValide = "SELECT identifiant, nom 
            FROM RECETTE;";

            $resultRecette = $conn->query($recetteValide);
            
            foreach ($resultRecette as $rec) {
                echo $rec["nom"];  
            }
            */
            ?>
            </section>
        </div>
    </div>
    
    <footer class="footer">
    </footer>

</body>
</html>