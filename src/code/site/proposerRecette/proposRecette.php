<?php
session_start();
include '../bd.php'
    ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="proposRecette.css">
    <link rel="stylesheet" href="../commun/commun.css">
    <title>Edu'Cook</title>
</head>

<body>
    <div class="flou"></div>
    
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
                <li><a href="../proposerRecette/proposRecette.php" class="link active">Propose ta recette</a></li>
                <?php if($_SESSION['admin'] == true) {echo "<li><a href='../backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";} ?>
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

    <?php
    if ($_SESSION['connecter'] == true) {
        ?>
        <h1 class="phraseProp">Proposer votre recette !</h1>
        <div class="parent">
            <div class="bigbox">
                <form id="formulaireUnique" action="traiter.php" method="post">
                    <div class="tout">
                        <div class="box">
                            <label for="nom" class="etape"><b>Etape 1 :</b> Nom de la recette</label>
                            <input id="nom" type="text" name="nom" placeholder="Nom de la recette" required>
                            <label for="Instruction" class="etape"><b>Etape 2 :</b> Instruction de la recette</label>
                            <input id="Instruction" type="textarea" rows="5" cols="33" name="Instruction"
                                placeholder="Instruction" required>
                            <label for="preparation" class="etape"><b>Etape 3 :</b> Temps de préparation de la
                                recette</label>
                            <input id="preparation" type="number" name="tpsPreparation"
                                placeholder="Temps de préparation(minute)" min="0"
                                onkeyup="if(this.value<0){this.value= this.value * -1} required">
                        </div>
                        <div class="box2">
                            <label for="difficulte" class="etape"><b>Etape 4 :</b> Difficulté de la recette</label>
                            <select class="difficulte" name="difficulte" id="niveau" required>
                                <option value="0" selected disabled>Choisir la difficulté :</option>
                                <option value="Facile">Facile</option>
                                <option value="Moyen">Moyen</option>
                                <option value="Difficile">Difficile</option>
                            </select>
                            <div id="searchContainer_ingr">
                                <label for="searchInput" class="etape"><b>Etape 5 :</b> Ajouter les ingrédients pour la
                                    recette</label>
                                <input type="text" id="searchInput" placeholder="Rechercher un ingredient...">
                            </div>
                            <div id="checkboxContainer">
                                <?php
                                $conn = connexionBd();
                                // Requête SQL pour récupérer les ingrédients
                                $sql = "SELECT nom, prixKg FROM ingredient";
                                $result = $conn->query($sql);

                                // HTML des cases à cocher
                                $checkboxesHTML = '';

                                // Vérifier s'il y a des résultats
                                if ($result->num_rows > 0) {
                                    // Récupérer chaque ligne de résultat
                                    while ($row = $result->fetch_assoc()) {
                                        $checkboxesHTML .= '<label class="ingredient-checkbox"><input type="checkbox" name="ingredients[]" value="' . $row["nom"] . '">' . $row["nom"] . '</label><br>';
                                    }
                                }

                                // Fermer la connexion à la base de données
                                $conn->close();

                                echo $checkboxesHTML;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="boutons_form">
                        <button class="valid annuler" id="annuler" type="button">Annuler</button>
                        <input class="valid valider" type="submit" value="valider" id="validerTout">
                    </div>
                </form>
            </div>
        </div>

        <script src="../commun/commun.js"></script>

        <script type="text/javascript" src="proposRecette.js"></script>
    <?php } else {
        header("Location: ../connexion/connexion.php");
        exit;
    } ?>

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