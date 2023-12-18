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
            <ul>Légume : </ul>
            <input type="button" value="Défaut" onclick="reinitialiserPref();" />
            <form action="feculent.php">
                <p id = "type_pref">Je n'en veux pas | Je n'aime pas | Sans préférence | J'aime | J'adore</p>

                <?php
                include 'bd.php'; 
                $sql = "SELECT nom FROM ingredient WHERE categorie ='legume'";
                $result = $conn->query($sql);
                $conn->close();
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="ingredient">';
                        echo '<label for="' . $row["nom"] . '">' . $row["nom"] . '</label>';
                        echo '<input type="radio" id="'. $row["nom"].'jamais" name="' . $row["nom"] . '" value ="0">';
                        echo '<input type="radio" id="'. $row["nom"].'aimePas" name="' . $row["nom"] . '" value ="0.5">';
                        echo '<input type="radio" id="'. $row["nom"].'sansPreference" name="' . $row["nom"] . '" value ="1" checked>';
                        echo '<input type="radio" id="'. $row["nom"].'aime" name="' . $row["nom"] . '" value ="1.5">';
                        echo '<input type="radio" id="'. $row["nom"].'adore" name="' . $row["nom"] . '" value ="2">';
                        echo '</div>';
                    }
                } else {
                    echo "Aucun ingrédient trouvé";
                }
                ?>
                <button id="btnSuivant">Suivant</button>
            </form>
            <form action="poisson.php">
                <button id="btnPrecedent">Précédent</button>
            </form>
        </div>
    </section>
    <script>

        document.getElementById("btnSuivant").addEventListener("click", function() {
            var boutonsViandes = document.querySelectorAll('input[type="radio"]');
            var valeursPrefLegume = {};

            boutonsViandes.forEach(function(bouton) {
                if (bouton.checked) {
                    var nomIngredient = bouton.name;
                    var valeur = parseFloat(bouton.value);
                    valeursPrefLegume[nomIngredient] = valeur;
                }
            });

        });
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
