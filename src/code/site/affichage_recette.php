<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edu'Cook - Recettes</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="image/logo.png" alt="Logo Edu'Cook">
        </div>
        <h1>Recettes de Cuisine</h1>
    </header>

    <section class="section">
        <div class="recette">
            <h3>Les 5 meilleures recettes :</h3>
            <ul>
                <?php
                include 'main.php'; 
                /**
                 * @file    Recette.php
                 * @author  Mathieu,Leo,Nathan,Souleymen
                 * @brief   Cette page permet l'affichage des recettes
                 * @version 0.3
                 * @date    17/01/2024
                 */
                $topIngredients = array_slice($lRecettePoint, 0, 5);
                foreach ($topIngredients as $rec) {
                    if ($rec['point']>0) {
                        echo '<li><h3>' . $rec['recette'] . ' :  ' . $rec['point'] .' points </h3></li>';
                        echo '<li> Nombre de points sans les ajustements : ' . $rec['nbPointRecetteOrigin'] . '</li>';
                        echo '<li> Prix de la recette : ' . $rec['prixRec'] . '</li>';
                        echo '<li> Nombre de points apres ajustement de prix : ' . $rec['nbPointRecetteAjustBudget'] . '</li>';
                        echo '<li> Temps de la recette : ' . $rec['tempsRec'] . '</li>';
                        echo '<li> Nombre de points apres ajustement de temps : ' . $rec['nbPointRecetteAjustTemps'] . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <a href="index.php"><button>Revenir à la page d'accueil</button></a>
    </section>
</body>
</html>