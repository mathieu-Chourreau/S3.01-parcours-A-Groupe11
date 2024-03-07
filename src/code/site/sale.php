<?php
/**
 * @file    sale.php
 * @author  Mathieu
 * @brief   La page Sale permet à l'utilisateur de saisir son prix, son temps et si il veut du salé
 * @version 0.1
 * @date    17/01/2024
 */
session_start();

if (!isset($_SESSION['ingredientsPreferences'])) {
    $_SESSION['ingredientsPreferences'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferences'][$nomIngredient] = $valeur;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu'Cook</title>
    <link rel="stylesheet" href="sale.css">
</head>

<body>


    <div class="background"></div>

    <nav id="nav">
        <div id="divun">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
            <div class="hame">
                <label class="burger" id="burger" for="burger">
                    <input type="checkbox" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="divdeux">
            <ul id="menu">
                <li><a href="#" class="link">Accueil</a></li>
                <li><a href="#" class="link active">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
                <li><a href="#" class="link">Proposer votre recette</a></li>
                <li><a href="#" class="link">Se connecter</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn">Se connecter</button>
        </div>
    </nav>

    <div class="container">
        <section class="section">
            <div class="preference">
                <p>Mes préférences : </p>
            </div>
            <div class="recherche_default">
                <input type="button" value="Défaut" onclick="reinitialiserPref();" />
                <form action="affichage_recette.php" method="post">

                    <div class="sale">
                        <label for="sale">Sale : </label>
                        <input type="radio" id="salenon" name="sale" value="0">
                        <label>NON</label>
                        <input type="radio" id="salesansPreference" name="sale" value="1" checked>
                        <label>Sans préférence</label>
                        <input type="radio" id="saleoui" name="sale" value="2">
                        <label>OUI</label>
                    </div>

                    <div class="prix">
                        <label for="prix">Budget (euros): </label>
                        <input type="text" id="zone_prix" name="zone_prix" pattern="\d+" required
                            title="Il faut que ce soit un nombre">
                    </div>

                    <div class="temps">
                        <label for="temps">Temps (minute): </label>
                        <input type="text" id="zone_temps" name="zone_temps" pattern="\d+" required
                            title="Il faut que ce soit un nombre">
                    </div>
                    <button type="submit" id="btnvalider">Valider</button>


                </form>
                <form action="index.php">
                    <button id="btnPrecedent">Précédent</button>
                </form>
            </div>
        </section>
    </div>
    <script>
        function reinitialiserPref() {
            var boutonsViandes = document.querySelectorAll('input[type="radio"]');

            boutonsViandes.forEach(function (bouton) {
                if (bouton.id.endsWith('sansPreference')) {
                    bouton.checked = true;
                } else {
                    bouton.checked = false;
                }
            });
        }
    </script>
</body>

</html>