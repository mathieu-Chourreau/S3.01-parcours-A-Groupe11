<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="recherche.css">
    <title>Edu'Cook</title>
</head>
<body>


    <nav id="nav">
        <div id="divun">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
        </div>
        <div class="divdeux">
            <ul id="menu">
                <li><a href="#" class="link active">Accueil</a></li>
                <li><a href="#" class="link">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
            </ul>
        </div>
        <div class="ham">
            <div class="line" id="un"></div>
            <div class="line" id="deux"></div>
            <div class="line" id="trois"></div>
        </div>
        <div id="rien"></div>
        <img id="burger" src="image/fleur1.jpg">
    </nav>

    <div class="bouttonveg">
        <h3>Afficher uniquement les recettes végétariennes</h3>
        <label class="switch">
            <input type="checkbox" onclick="veg()">
            <span class="slider"></span>
        </label>
    </div>

    <section class="">
        <div class="grid">
            <div class="secun">
                <img src="image/fleur3.jpg" class="img-fluid rounded-start">
            </div>
            <div class="secdeux">
                <h5 class="card-title">test</h5>
                <p class="typeP">Acide</p>
                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
            </div>
        </div>

        <?php
        include 'bd.php';

        $recetteValide = "SELECT identifiant, nom 
        FROM RECETTE;";

        $resultRecette = $conn->query($recetteValide);
        
        foreach ($resultRecette as $rec) {
            echo '<div class="card" style="max-width: 50vw;">';
            echo '<div class="row g-0">';
            echo '<div class="col-md-4">';
            echo '<img src="image/fleur3.jpg" class="img-fluid rounded-start" alt="...">';
            echo '</div>';
            echo '<div class="col-md-8">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' .$rec["nom"]. '</h5>';
            echo '<p class="typeP">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>';
            echo '<p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

<div class="card" style="max-width: 50vw;">
            <div class="row g-0">
            <div class="col-md-4">
            <img src="image/fleur3.jpg" class="img-fluid rounded-start" alt="...">
            </div>';
            <div class="col-md-8">
            <div class="card-body">
            <h5 class="card-title">test</h5>
            <p class="typeP">Acide</p>
            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
            </div>
            </div>
            </div>
            </div>
    </section>

    <footer class="footer">
    </footer>

    <script>
        const menuHamburger = document.getElementById("burger");
        const navLinks = document.querySelector(".divdeux");
        menuHamburger.addEventListener('click',()=>{navLinks.classList.toggle('mobile-menu')});

        var boutton = document.getElementsByClassName("bouttonveg");
        function veg(){
            var classCard = document.getElementsByClassName("card");
            for(var i=0;i<classCard.length;i++){
                if(document.getElementsByClassName("typeP")[i].textContent === "Acide"){
                    document.querySelectorAll('.card')[i].classList.toggle('hidden');
                }
            }
        }
    </script>

</body>
</html>