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
include 'Ingredient.php';
include 'Recette.php';
Include 'Utilisateur.php';

$ingredientsPref = $_SESSION['ingredientsPreferences'];
$ingredientsPrefPageSale = $_SESSION['ingredientsPreferencesPageSale'];

// Récuperer les préférences de l'utilisateur
foreach ($ingredientsPref as $nomIngredient => $valeur) {
    //Stocker l'ingredient en fonction de la preference
    if ($valeur == 0){
        $tabIngredientRefus[$nomIngredient] = $valeur;
    }
    else{
        $tabIngredientPref[$nomIngredient] = $valeur;
    }
}

// Recuperer la préférence du salé, le temps et le budget

$sale = $ingredientsPrefPageSale['sale'];
$temps = $ingredientsPrefPageSale['zone_temps'];
$budget = $ingredientsPrefPageSale['zone_prix'];

// tri des recettes en fonction des préférences
// Récupérer toutes les recettes qui comportent seulement des ingredients que l'utilisateur souhaite

$listeRecette = array();

if (isset($tabIngredientRefus)){
    $conditionWhere = '';
    // Creer et excecuter la requete
    foreach ($tabIngredientRefus as $nomIngredient => $valeur) {
        $conditionWhere = "".$conditionWhere .",'" .$nomIngredient ."'";
    }
    $conditionWhere = substr($conditionWhere, 1);
    $conditionWhere = "(".$conditionWhere .")";
}
else {$conditionWhere = "('null')";}
    $recetteValide = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette, r.instruction as instruction_recette, r.temps_min_ as temps_recette, r.niveau_difficulte as niveauDif_recette, r.grammage as grammage_recette, r.identifiantVideo as identifiantVid_recette 
    FROM RECETTE r
    JOIN CONTENIR c ON r.identifiant = c.recette_id  
    JOIN INGREDIENT i ON c.ingredient_id = i.nom
    WHERE r.IDENTIFIANT NOT IN (SELECT rt.IDENTIFIANT
                                FROM RECETTE rt
                                JOIN CONTENIR ct ON rt.identifiant = ct.recette_id  
                                JOIN INGREDIENT ig ON ct.ingredient_id = ig.nom
                                WHERE ig.NOM IN $conditionWhere)
    ORDER BY r.identifiant;";

    $resultRecette = $conn->query($recetteValide);
    $nomRecette = "";
    

    if ($resultRecette && $resultRecette->num_rows > 0) {
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
                    }
                    $$nomRecette->ajouterIngredient($$nomIngredient,$row['quantite']);
                    $$nomIngredient->ajouterRecette($$nomRecette);
                }
            }   
        }
    }
 

$lRecettePoint = array();

foreach ($listeRecette as $val){
    //Verifier si une recette est salé
    $sql="SELECT cr.gout as gout
    FROM categorierecette cr 
    JOIN appartenirrc rc ON cr.identifiant = rc.identifiantC
    JOIN recette r ON rc.identifiantR = r.identifiant
    WHERE r.identifiant =" .$val->getIdentifiant().";";

    $resultS = $conn->query($sql);
    $bSale = false;
    if ($resultS && $resultS->num_rows > 0) {
        while ($row = $resultS->fetch_assoc()) {
            $gout = "".$row['gout'];
            if ($gout == 'Salé') {
                $bSale = true;;
            }
        }
    }

    if ($bSale && $sale == 0) {
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
    if ($val->getTemps() > $temps) {
        //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
        $nbPointRecette -= (($val->getTemps()-$temps)/($temps*0.5)*10)/2;
    }

    $nbPointRecetteAjustTemps = intval($nbPointRecette);

    //ajuster en fonction de si la recette est salé
    if ($sale==2 && $bSale) {
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
