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
                include 'bd.php'; 
                
                $points = range(5, 1);

                $sql = "SELECT * FROM recette LIMIT 5";
                $result = $conn->query($sql);
                $conn->close();

                if ($result && $result->num_rows > 0) {
                    $index = 0;
                    while ($row = $result->fetch_assoc()) {
                        $pointActuel = $points[$index];

                        echo '<li>';
                        echo '<h3>' . $row["nom"] . ' :  cette recette correspond à ' . $pointActuel .' points de correspondance </h3>';
                        echo '<p>' . $row["instruction"] . '</p>';
                        echo '</li>';

                        $index++;
                    }
                } else {
                    echo "Aucune recette n'a été trouvée";
                }
                ?>
            </ul>
        </div>
    </section>
</body>
</html>
