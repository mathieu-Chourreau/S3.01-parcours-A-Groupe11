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
    <link rel="stylesheet" href="back_office.css">
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
                <li><a href="../recherche/recherche.php" class="link">Rechercher</a></li>
                <li><a href="../formulaire/formulaire.php" class="link">Formulaire</a></li>
                <li><a href="../equipe/equipe.php" class="link">L'équipe</a></li>
                <li><a href="../proposerRecette/proposRecette.php" class="link">Proposer votre recette</a></li>
                <?php if($_SESSION['admin'] == false){ ?>
                <?php }elseif ($_SESSION['admin'] == true) {echo "<li><a href='back_office.php' class='link active'>Gerer les recettes</a></li>";} ?>
            </ul>
        </div>
        
        <div class="boutonConnexion">
            <?php if($_SESSION['connecter'] == false){ ?>
                <a href="../connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se connecter</button></a>
            <?php }elseif ($_SESSION['connecter'] == true) {echo "<button class='btn white-btn' id='loginBtn'><a href='../connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";} ?>
        </div>
    </nav>
    <div class="container_back_office">
    <?php
    // Connexion à la base de données
    include '../bd.php';
    $conn = connexionBd();

    // Requête SQL pour sélectionner toutes les colonnes de la table recetteavalider
    $sql = "SELECT * FROM recetteavalider";
    $result = $conn->query($sql);

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        // Afficher les données de chaque ligne
        while($row = $result->fetch_assoc()) {
            echo '<div class="card-grid">';
                echo '<div class="card">';
                    echo '<div class="card-content">';
                        echo '<div class="image-container">';
                            echo '<img src="../image/logo.png" class="imageCard" alt=une image>';
                        echo '</div>';
                        echo '<div class="contenu_back_office">';
                            echo "<b>ID:</b> " . $row["id"]. "<br>";
                            echo "<b>Nom: </b>" . $row["nom"]. "<br>";
                            echo "<b>Description: </b>" . $row["description"]. "<br>";
                            echo "<b>Grammage: </b>" . $row["grammage"]. "<br>";
                            echo "<b>Temps de préparation:</b> " . $row["tempsPreparation"]. "<br>";
                            echo "<b>Difficulté:</b> " . $row["difficulte"]. "<br>";
                            echo "<b>Catégorie:</b> " . $row["categorie"]. "<br>";
                            
                            // Boutons Ajouter et Supprimer
                            echo '<form action="traiter_recette.php" method="post">';
                                echo '<div class="boutons_back_office">';
                                    echo '<input type="hidden" name="recette_id" value="' . $row["id"] . '">';
                                    echo '<input type="hidden" name="nom_recette" value="' . $row["nom"] . '">';
                                    echo '<input type="submit" name="action" value="Ajouter">';
                                    echo '<input type="submit" name="action" value="Supprimer">';
                                echo '</div>';
                            echo '</form>';
                        echo '</div>';
                        echo "<br><br>";
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    } else {
        echo "O recette dans la table recette a valider";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>
    </div>
    <script src="../commun/commun.js"></script>

    <footer class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="region region-footer1">
                        <section id="block-block-1" class="block block-block clearfix">
                            <p>@&nbsp;Equipe Edu'Cook<br />
                                Tous droits réservés<br />
                                <a class="lien" href="../newsletter/politique_confidentialite.html">Politique de confidentialité</a>
                            </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 news">
                    <div class="region region-footer2">
                        <section id="block-block-2" class="block block-block clearfix">
                            <p>Notre Newsletter : </p>
                            <a class="btn_footer" href="../newsletter/newsletter.html">Accès au Newsletter</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
