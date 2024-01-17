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
                /**
                 * @file    Recette.php
                 * @author  Mathieu,Leo,Nathan,Souleymen
                 * @brief   Cette page permet l'affichage des recettes
                 * @version 0.1
                 * @date    17/01/2024
                 */
                include 'mainglobal.php'; 
                $topIngredients = array_slice($lRecettePoint, 0, 5);
                foreach ($topIngredients as $rec) {
                    if ($rec['point']>0) {
                        echo '<li>';
                        echo '<h3>' . $rec['recette'] . ' :  ' . $rec['point'] .' points </h3>';
                        //echo '<p>' . $row["instruction"] . '</p>';
                        echo '</li>';
                    }
                    }
                ?>
            </ul>
        </div>
    </section>
</body>
</html>