<?php 

session_start();

if (!isset($_SESSION['ingredientsPreferencesPageSale'])) {
    $_SESSION['ingredientsPreferencesPageSale'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferencesPageSale'][$nomIngredient] = $valeur;
    }
} 
else {
    echo "Le formulaire n'a pas été soumis.";
}

include 'bd.php';
include 'Recette.php';
include 'Ingredient.php';
include 'utilisateur.php';


// RECUPERER LE RESULTAT DU FORMULAIRE

    //Initialiser les variables
    $lIngredientsPref = $_SESSION['ingredientsPreferences'];
    $ingredientsPrefPageSale = $_SESSION['ingredientsPreferencesPageSale'];

    // Récuperer les préférences de l'utilisateur
    foreach ($lIngredientsPref as $nomIngredient => $preferenceIngPourUtilisateur) {
        
        //Trier l'ingredient
            
            //Stocker l'ingredient en fonction de la preference de l'utilisateur
            if ($preferenceIngPourUtilisateur == 0){

                //Mettre l'ingredient dans un tableau contenant les ingrédients qu'il ne veut pas
                $tabIngredientRefus[$nomIngredient] = $preferenceIngPourUtilisateur;
            }
            else{

                // Mettre l'ingrédient dans un tableau contenant les autres ingrédients
                $tabIngredientPref[$nomIngredient] = $preferenceIngPourUtilisateur;
            }
    }

    // Initialiser la préférence par rapport au salé, au temps et au budget
    $sale = $ingredientsPrefPageSale['sale'];
    $tempsCuisineMax = $ingredientsPrefPageSale['zone_temps'];
    $budget = $ingredientsPrefPageSale['zone_prix'];

// TRI DES RECETTES EN FONCTION DES PREFERENCES
    
    // Initialisation des variables
    $listeRecette = array();
    $nomRecette = "";

    // Récupérer toutes les recettes qui comportent seulement des ingredients que l'utilisateur souhaite

        // Création d'un string correspondant à la condition de la requête
        $conditionRequete = '';

        // Creer et excecuter la requete
            if (isset($tabIngredientRefus)){

                // Rajouter dans conditionRequete tous les ingrédients que l'utilisateur ne souhaite pas avoir
                foreach ($tabIngredientRefus as $nomIngredient) {

                    // Rajouter à conditionRequete nomIngredeint pour pouvoir l'exclure du résultat de la requete
                    $conditionRequete = "".$conditionRequete .",'" .$nomIngredient ."'";
                }
                $conditionRequete = substr($conditionRequete, 1);
                $conditionRequete = "(".$conditionRequete .")";
            }
            else {
                // Initialiser conditionRequete à null car il n'a refusé aucun ingrédient
                $conditionRequete = "('null')";}
            
        // Executer la requete en utilisant conditionRequete
        $recetteValide = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette, r.instruction as instruction_recette, r.temps_min_ as temps_recette, r.niveau_difficulte as niveauDif_recette, r.grammage as grammage_recette, r.identifiantVideo as identifiantVid_recette 
        FROM RECETTE r
        JOIN CONTENIR c ON r.identifiant = c.recette_id  
        JOIN INGREDIENT i ON c.ingredient_id = i.nom
        WHERE r.IDENTIFIANT NOT IN (SELECT rt.IDENTIFIANT
                                    FROM RECETTE rt
                                    JOIN CONTENIR ct ON rt.identifiant = ct.recette_id  
                                    JOIN INGREDIENT ig ON ct.ingredient_id = ig.nom
                                    WHERE ig.NOM IN $conditionRequete)
        ORDER BY r.identifiant;";

        $resultRecette = $conn->query($recetteValide);
        

        // Transformer le resultat de la requete en un liste d'objet recette
        
            // Vérifier si la requete a bien été executée et que son nombre d'enregistrement est supérieur à 0
            if ($resultRecette && $resultRecette->num_rows > 0) {

                // On parcours les champs de la requete
                while ($row = $resultRecette->fetch_assoc()) {

                    $nomRecette = "recette".$row['identifiant_recette'];
                    $$nomRecette = new Recette($row['identifiant_recette'], $row['nom_recette'], $row['temps_recette'], $row['niveauDif_recette'], $row['instruction_recette'], $row['grammage_recette']);
                    $listeRecette[] = $$nomRecette;

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
                                $$nomRecette->ajouterIngredient($$nomIngredient,$row['quantite']);
                                $$nomIngredient->ajouterRecette($$nomRecette);
                            }
                        }
                    }   
                }
            }
    

    $lRecettePoint = array();

    foreach ($listeRecette as $val){
        //Verifier si une recette est salé
        $sql="SELECT cr.gout
        FROM categorierecette cr 
        JOIN appartenirrc rc ON cr.identifiant = rc.identifiantC
        JOIN recette r ON rc.identifiantR = r.identifiant
        WHERE cr.gout = 'sale'
        AND r.identifiant =" .$val->getIdentifiant().";";

        $resultS = $conn->query($sql);
        if ($resultS && $resultS->num_rows > 0 && $sale == 0) {
            $nbPointRecette = -1000;
        }else {
        //Initialisation de nbPointRecette
        $nbPointRecette = 0;
        foreach ($val->getMesIngredients() as $ing){
            $proportion = ($ing[1]/$val->getGrammage())*100;
            foreach ($tabIngredientPref as $nomIngredient => $valeur){
                if ($nomIngredient == $ing[0]->getNom()){
                    $nbPointRecette = $nbPointRecette + $proportion * $valeur;
                }
            }
        }
        //ajuster en fonction du prix
        if ($val->getPrix()>$budget) {
            //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
            $nbPointRecette -= ($val->getPrix()-$budget)/($budget*0.1)*40;
        }

        //ajuster en fonction du temps
        if ($val->getTemps() > $tempsCuisineMax) {
            //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
            $nbPointRecette -= ($val->getTemps()-$tempsCuisineMax)/($tempsCuisineMax*0.5)*40;
        }

        //ajuster en fonction de si la recette est salé
        if ($sale==2) {
            //On ajoute un bonus de points à la recette
            $nbPointRecette +=25;
        }

        //création d'un array avec un recette et ses points
        $lRecettePoint[] = array('recette' => $val->getNom(), 'point' => $nbPointRecette);
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
