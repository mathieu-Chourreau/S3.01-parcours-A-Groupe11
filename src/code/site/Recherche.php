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

    <div class="search">
        <input type="text" id="searchInput" placeholder="Rechercher une recette...">
    </div>
    
    <div class="bouttonveg">
        <h3>Afficher uniquement les recettes végétariennes</h3>
        <label class="switch">
            <input type="checkbox" onclick="veg()">
            <span class="slider"></span>
        </label>
    </div>

    <section class="">
        <?php
        include 'bd.php';

        $recetteValide = "SELECT r.nom AS nom_recette, r.image AS imageR, r.instruction as instruction, cr.gout AS categorie_recette
        FROM recette r
        INNER JOIN categorierecette cr ON r.identifiant = cr.identifiant
        ORDER BY categorie_recette;";

        $resultRecette = $conn->query($recetteValide);
        
        foreach ($resultRecette as $rec) {
            echo '<div class="card-grid">';
            echo '<div class="card">';
            echo '<div class="card-content">';
            echo '<div class="image-container">';
            echo '<img src="' . $rec['imageR'] . '" class="imageCard">';
            echo '</div>';
            echo '<div class="text-container">';
            echo '<div class="card-body">';
            echo '<h4 class="card-title">' . $rec['nom_recette'] . '</h4>';
            echo '<p class="typeP"><b>Catégorie : </b>' . $rec['categorie_recette'] . '</p>';
            echo '<p class="card-text"><b>Description : </b>' . $rec['instruction'] . '</p>';
            echo '<a href="details.php?recipeName=' . urlencode($rec['nom_recette']) . '&recipeCategory=' . urlencode($rec['categorie_recette']) . '&recipeDescription=' . urlencode($rec['instruction']) . '&recipeImageSrc=' . urlencode($rec['imageR']) . '" class="btn-details">Voir les détails</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

    </section>

    <footer class="footer">
    </footer>

    <script>
        const menuHamburger = document.getElementById("burger");
        const navLinks = document.querySelector(".divdeux");
        menuHamburger.addEventListener('click',()=>{navLinks.classList.toggle('mobile-menu')});

        

        var boutton = document.getElementsByClassName("bouttonveg");
        function veg(){
            var classCard = document.querySelectorAll(".card");
            for(var cards of classCard){
                if(!(cards.querySelector(".typeP").textContent.includes("Végétarien"))){
                    cards.classList.toggle('hidden');
                }
            }
        }

        // Fonction pour filtrer les recettes en fonction du texte de recherche
        function filterRecipes() {
            var input, filter, cards, cardTitle, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cards = document.querySelectorAll(".card");

            for (i = 0; i < cards.length; i++) {
                cardTitle = cards[i].querySelector(".card-title");
                txtValue = cardTitle.textContent || cardTitle.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
        }


        // Ajouter un écouteur d'événements pour détecter les changements dans la barre de recherche


    </script>
</body>
</html>