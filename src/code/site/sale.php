<?php

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
    <link rel="stylesheet" href="styles.css">
    <title>Edu'Cook</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo.png" alt="Logo Edu'Cook">
        </div>
        <h1>Mon En-Tête</h1>
    </header>

    <section class="section">
        <div class="preference">
            <p>Mes préférences : </p>
        </div>
        <div class="recherche_default">
            <input type="button" value="Défaut" onclick="reinitialiserPref();" />
            <form action="liste.php" method = "post">

                <?php
                
                    echo '<div class="sale">';
                    echo '<div class="sale">';
                    echo '<label for="sale">Sale : </label>';
                    echo '<input type="radio" id="salenon" name="sale" value ="0">';
                    echo '<label>NON</label>';
                    echo '<input type="radio" id="salesansPreference" name="sale" value ="1" checked>';
                    echo '<label>Sans préférence</label>';
                    echo '<input type="radio" id="saleoui" name="sale" value ="2">';
                    echo '<label>OUI</label>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="prix">';
                    echo '<label for="prix">Prix (euros): </label>';
                    echo '<textarea id="zone_prix" name="zone_prix" rows="1" cols="10"></textarea>';
                    echo '</div>';

                    echo '<div class="temps">';
                    echo '<label for="temps">Temps (minute): </label>';
                    echo '<textarea id="zone_temps" name="zone_temps" rows="1" cols="10"></textarea>';
                    echo '</div>';

                   
                ?>
                <button id="btnvalider">Valider</button>
            </form>
            <form action="index.php">
                <button id="btnPrecedent">Précédent</button>
            </form>
        </div>
    </section>
    <script>
        function reinitialiserPref() {
            var boutonsViandes = document.querySelectorAll('input[type="radio"]');
            
            boutonsViandes.forEach(function(bouton) {
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
