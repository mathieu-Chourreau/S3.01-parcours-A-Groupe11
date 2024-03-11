<?php 

session_start();

if (!isset($_SESSION['ingredientsPreferencesPageVege'])) {
    $_SESSION['ingredientsPreferencesPageVege'] = array();
}    

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferencesPageVege'][$nomIngredient] = $valeur;
    }
} 
else {
    echo "Le formulaire n'a pas été soumis.";
}

include 'Ingredient.php';
include '../bd.php';
include 'Recette.php';
Include 'Utilisateur.php';

// Récuperer le resultat du formulaire

    $conn = connexionBd();

    // Initialiser les variables
    $lIngredientsPref = $_SESSION['ingredientsPreferences'];
    $ingredientsPrefPageVege = $_SESSION['ingredientsPreferencesPageVege'];

    // Récuperer les préférences de l'utilisateur
    foreach ($lIngredientsPref as $nomIngredient => $preferenceIngPourUtilisateur) {
        //Stocker l'ingredient en fonction de la preference
        if ($preferenceIngPourUtilisateur == 0){
            $tabIngredientRefus[$nomIngredient] = $preferenceIngPourUtilisateur;
        }
        else{
            $tabIngredientPref[$nomIngredient] = $preferenceIngPourUtilisateur;
        }

    }

    function afficherIngredientsPref($tabIngredientPref) {
        foreach ($tabIngredientPref as $nomIngredient => $preference) {
            echo "TableauPref: $nomIngredient, Préférence: $preference <br>";
        }
        echo "<br> <br> <br>";
    }

    function afficherIngredientsRefus($tabIngredientRefus) {
        foreach ($tabIngredientRefus as $nomIngredient => $refus) {
            echo "TableauRefus: $nomIngredient, Préférence: $refus <br>";
        }
    }

    // Recuperer la préférence du salé, le temps et le budget

    $vege = $ingredientsPrefPageVege['vege'];
    $tempsCuisineMax = $ingredientsPrefPageVege['zone_temps'];
    $budget = $ingredientsPrefPageVege['zone_prix'];

// TRI DES RECETTES EN FONCTION DES PREFERENCES
    
    // Initialiser les variables
    $listeRecette = array();
    $nomRecette = "";
    
    // Récupérer toutes les recettes qui comportent seulement des ingredients que l'utilisateur souhaite
        
        //création d'un string correspondant à la condition de la requete
        $conditionRequete = '';
        
        // Creer la condition de la requete
        if (isset($tabIngredientRefus)){
            
            // Rajouter à conditionRequete tous les ingrédients que l'utilisateur ne souhaite pas avoir
            foreach ($tabIngredientRefus as $nomIngredient => $valeur) {
                
                // On ajoute à conditionRequete le nom de l'ingredient pour l'exclure du résultat de la requete
                $conditionRequete = "".$conditionRequete .",'" .$nomIngredient ."'";
            }
            $conditionRequete = substr($conditionRequete, 1);
            $conditionRequete = "(".$conditionRequete .")";
        }

        // Affecter null à la condition
        else {$conditionRequete = "('null')";}

    // Gerer l'execution de la requete

        //Création et execution d'une requete pour réupérer les recette
        $recetteValide = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette, r.instruction as instruction_recette, r.temps_min_ as temps_recette, r.niveau_difficulte as niveauDif_recette, r.grammage as grammage_recette, r.identifiantVideo as identifiantVid_recette 
        FROM recette r
        JOIN contenir c ON r.identifiant = c.recette_id  
        JOIN ingredient i ON c.ingredient_id = i.nom
        WHERE r.IDENTIFIANT NOT IN (SELECT rt.IDENTIFIANT
                                    FROM recette rt
                                    JOIN contenir ct ON rt.identifiant = ct.recette_id  
                                    JOIN ingredient ig ON ct.ingredient_id = ig.nom
                                    WHERE ig.NOM IN $conditionRequete)
        ORDER BY r.identifiant;";
        
        // executer la requete avec la condition
        $resultRecette = $conn->query($recetteValide);

        // Vérifier si la requête s'est bien exécutée
        if (!$resultRecette) {
            echo "Erreur lors de l'exécution de la requête : " . $conn->error;
            // Vous pouvez ajouter d'autres actions à prendre en cas d'erreur ici
        }
        // Transformer le resultat de la requete en une liste d'objet recette
        if ($resultRecette && $resultRecette->num_rows > 0) {

            while ($row = $resultRecette->fetch_assoc()) {
                
                // Créer des objets de Recette
                $nomRecette = "recette".$row['identifiant_recette'];
                $$nomRecette = new Recette($row['identifiant_recette'], $row['nom_recette'], $row['temps_recette'], $row['niveauDif_recette'], $row['instruction_recette'], $row['grammage_recette']);
                
                // Ajouter l'objet à la liste de Recette
                $listeRecette[] = $$nomRecette;

                // recuperer et creer les Ingredients de la recette
                $ingredientDeRecette= "SELECT i.nom as nom_ingr, i.prixKG as prix, ci.categorie as categorie, c.quantite as quantite
                        FROM ingredient i
                        JOIN categorieingredient ci on i.identifiantC = ci.identifiant
                        JOIN contenir c ON i.nom = c.Ingredient_id
                        JOIN recette r ON c.Recette_id = r.identifiant
                        WHERE r.identifiant =". $row['identifiant_recette'].";";
                
                $resultIngredient = $conn->query($ingredientDeRecette);
                
                
                if ($resultIngredient && $resultIngredient->num_rows > 0) {
                    while ($row = $resultIngredient->fetch_assoc()) {
                        $nomIngredient = "".$row['nom_ingr'];
                        $nomIngredient = str_replace(' ', '_', $nomIngredient);
                        if (!isset($$nomIngredient)) {
                            $$nomIngredient = new Ingredient($row['nom_ingr'], $row['prix'], $row['categorie']);
                        }
                        $$nomRecette->ajouterIngredient($$nomIngredient,$row['quantite']);
                        $$nomIngredient->ajouterRecette($$nomRecette);
                    }
                }   
            }
        }
    

    $lRecettePoint = array();

foreach ($listeRecette as $val){
    //Verifier si une recette est végétarienne
    $sql="SELECT cr.gout as gout
    FROM categorierecette cr 
    JOIN appartenirrc rc ON cr.identifiant = rc.identifiantC
    JOIN recette r ON rc.identifiantR = r.identifiant
    WHERE r.identifiant =" .$val->getIdentifiant().";";



    $resultS = $conn->query($sql);
    $bvege = false;
    if ($resultS && $resultS->num_rows > 0) {
        while ($row = $resultS->fetch_assoc()) {
            $gout = "".$row['gout'];
            if ($gout == 'Végétarien') {
                $bvege = true;
            }
        }
    }

    if ($bvege && $vege == 0) {
        $nbPointRecette = -1000;
    }else {
    
    //Initialisation de nbPointRecette
    $nbPointRecette = 0;
    foreach ($val->getMesIngredients() as $ing){
        $proportion = ($ing[1]/$val->getGrammage())*100;
        foreach ($tabIngredientPref as $nomIngredient => $valeur){
            $nomIngredient = str_replace('_', ' ', $nomIngredient);
            if ($nomIngredient == $ing[0]->getNom()){
                $nbPointRecette = $nbPointRecette + $proportion * $valeur;
            }
        }
    }

    $nbPointRecette = $nbPointRecette/2;
    $nbPointRecetteOrigin = $nbPointRecette;
    //ajuster en fonction du prix
    if ($val->getPrix()>$budget) {
        //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
        $nbPointRecette -= (($val->getPrix()-$budget)/($budget*0.1)*10)/2;
    }

    $nbPointRecetteAjustBudget = intval($nbPointRecette);

    //ajuster en fonction du temps
    if ($val->getTemps() > $tempsCuisineMax) {
        //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
        $nbPointRecette -= (($val->getTemps()-$tempsCuisineMax)/($tempsCuisineMax*0.5)*10)/2;
    }

    $nbPointRecetteAjustTemps = intval($nbPointRecette);

    //ajuster en fonction de si la recette est salé
    if ($vege==2 && $bvege) {
        //On ajoute un bonus de points à la recette
        $nbPointRecette +=25;
    }

    $partieEntiere = intval($nbPointRecette);

    //création d'un array avec un recette et ses points
    $lRecettePoint[] = array('id_recette' => $val->getIdentifiant(), 'recette' => $val->getNom(), 'point' => $partieEntiere, 'nbPointRecetteOrigin' => $nbPointRecetteOrigin, 'nbPointRecetteAjustBudget' => $nbPointRecetteAjustBudget, 'nbPointRecetteAjustTemps' => $nbPointRecetteAjustTemps, 'prixRec' => $val->getPrix(), 'tempsRec' => $val->getTemps());
    }
}

//trier les recette en fonction de la correspondance dans l'ordre decroissant
$n =count($lRecettePoint);
do {
    $bchanger= false;
    for ($i = 0; $i < $n - 1; $i++) {
        if ($lRecettePoint[$i]['point'] < $lRecettePoint[$i + 1]['point']) {
            //echange des éléments si l'élément actuel a un score plus bas que l'élément suivant
            $temp = $lRecettePoint[$i];
            $lRecettePoint[$i] = $lRecettePoint[$i + 1];
            $lRecettePoint[$i + 1] = $temp;
            $bchanger = true;
        }
    }
} while ($bchanger);

    deconnexionBd($conn);
?>