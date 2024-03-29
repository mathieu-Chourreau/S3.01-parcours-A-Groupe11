<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: ../connexion/connexion.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <li><a href="../recherche/recherche.php" class="link">Recherche</a></li>
                <li><a href="../formulaire/formulaire.php" class="link">Formulaire</a></li>
                <li><a href="../proposerRecette/proposRecette.php" class="link">Propose ta recette</a></li>
                <?php if($_SESSION['admin'] == true) {echo "<li><a href='../backOffice/back_office.php' class='link active'>Gerer les recettes</a></li>";} ?>
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
                        echo '<div class="contenu_back_office">';
                            echo "<b>ID:</b> " . $row["id"]. "<br>";
                            echo "<b>Nom: </b>" . $row["nom"]. "<br>";
                            echo "<b>Description: </b>" . $row["description"]. "<br>";
                            echo "<b>Temps de préparation:</b> " . $row["tempsPreparation"]. "<br>";
                            echo "<b>Difficulté:</b> " . $row["difficulte"]. "<br>";
                            
                            // Boutons Ajouter et Supprimer
                            echo '<form action="traiter_recette.php" method="post" enctype="multipart/form-data">';
                                echo '<div class="boutons_back_office">';
                                    echo '<input type="hidden" name="recette_id" value="' . $row["id"] . '">';
                                    echo '<input type="hidden" name="nom_recette" value="' . $row["nom"] . '">';
                                    echo '<input type="submit" name="action" value="Ajouter">';
                                    echo '<input type="submit" name="action" value="Supprimer">';
                                echo '</div>';
                        echo '</div>';
                        echo '<div class="ingredients">';
                            $ingredient = "SELECT i.nom AS nom_ingredient, c.quantite AS quantite
                                FROM ingredient i
                                JOIN contenirAValider c ON i.nom = c.Ingredient_id
                                JOIN recetteAValider r ON c.Recette_id = r.id
                                WHERE r.id = '".$row["id"]."';";
        
                            $resultIng = $conn->query($ingredient);
        
                            echo '<ul>';
                            foreach ($resultIng as $ing) {
                                echo '<li>' . $ing['nom_ingredient'] . ' : ' . $ing['quantite'] . ' g</li>';
                            }
                            echo '</ul>';
                            echo '</div>'; ?>
                        <div class="bigone">
                        <div class="categorie">
                        <select class = "selectCat" name="categorie_recette" id="categorie_recette">
                        <?php
                        // Requête SQL pour sélectionner les catégories de recettes distinctes de la table recette
                        $sql_categories = "SELECT gout FROM categorieRecette";
                        $result_categories = $conn->query($sql_categories);

                        // Vérifier s'il y a des résultats
                        if ($result_categories->num_rows > 0) {
                            // Afficher les catégories de recettes dans le menu déroulant
                            while($row_category = $result_categories->fetch_assoc()) {
                                echo "<option value='" . $row_category["gout"] . "'>" . $row_category["gout"] . "</option>";
                            }
                        } else {
                            echo "<option value=''>Aucune catégorie disponible</option>";
                        }
                        ?>
                        </select>
                        </div> 
                        <div class="upload">  
                        <input type="file" name="<?php $row['nom'] ?>" id="">
                        </div> 
                        </div>
                        </form>
                        <?php echo "<br><br>";
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
                        <a class="lien" href="../equipe/equipe.php">En savoir plus sur l'équipe !</a>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
