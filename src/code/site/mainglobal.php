<?php 

session_start();

if (!isset($_SESSION['ingredientsPreferencesPageSale'])) {
    $_SESSION['ingredientsPreferencesPageSale'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferencesPageSale'][$nomIngredient] = $valeur;
    }

    echo "<h2>Préférences des ingrédients (depuis la session) :</h2>";
    echo "<ul>";
    echo "<h2>Préférences des ingrédients (Page Sale) :</h2>";
    echo "<ul>";
    foreach ($_SESSION['ingredientsPreferencesPageSale'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
} else {
    echo "Le formulaire n'a pas été soumis.";
}



include 'bd.php';
class Ingredient {
    private $nom;
    private $prixKg;
    private $categorie;
    private $lesRecettes;

    public function __construct($INom, $IPrix, $ICategorie) {
        $this->nom = $INom;
        $this->prixKg = $IPrix;
        $this->categorie = $ICategorie;
        $this->lesRecettes = array();
    }

    public function __constructCopy(Ingredient $Ing) {
        $this->nom = $Ing->getNom();
        $this->prixKg = $Ing->getPrix();
        $this->categorie = $Ing->getCategorie();
        $this->lesRecettes = $Ing->getLesRecette();
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nvNom) {
        $this->nom = $nvNom;
    }

    public function getPrix() {
        return $this->prixKg;
    }

    public function setPrix($nvPrix) {
        $this->prixKg = $nvPrix;
    }

    public function getLesRecette() {
        return $this->lesRecettes;
    }

    public function ajouterRecette($recette) {
        if (!$this->existeRecette($recette)) {
            $this->lesRecettes[] = $recette;
            return true;
        } else {
            return false;
        }
    }

    public function retirerRecette($recette) {
        $cle = array_search($recette, $this->lesRecettes);
        if ($cle !== false) {
            unset($this->lesRecettes[$cle]);
            return true;
        } else {
            return false;
        }
    }

    public function existeRecette($recette) {
        return in_array($recette, $this->lesRecettes);
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($nvCategorie) {
        $this->categorie = $nvCategorie;
    }
}

class Recette {
    private $identifiant;
    private $nom;
    private $temps;
    private $instruction;
    private $difficulte;
    private $grammage;
    private $mesIngredients;

    public function __construct($id, $n, $t, $d, $i, $g) {
        $this->identifiant = $id;
        $this->nom = $n;
        $this->difficulte = $d;
        $this->temps = $t;
        $this->instruction = $i;
        $this->grammage = $g;
        $this->mesIngredients = array();
    }

    public function getGrammage() {
        return $this->grammage;
    }

    public function setGrammage($gram) {
        $this->grammage = $gram;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function setIdentifiant($id) {
        $this->identifiant = $id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nvNom) {
        $this->nom = $nvNom;
    }


    public function getTemps() {
        return $this->temps;
    }

    public function setTemps($nvTemps) {
        $this->temps = $nvTemps;
    }

    public function getDifficulte() {
        return $this->difficulte;
    }

    public function setDifficulte($nvDifficulte) {
        $this->difficulte = $nvDifficulte;
    }

    public function getInstruction() {
        return $this->instruction;
    }

    public function setInstruction($nvInstr) {
        $this->instruction = $nvInstr;
    }

    public function getMesIngredients() {
        return $this->mesIngredients;
    }

    public function ajouterIngredient($nvIngredient, $poids) {
        $Ing_ajoutee = array($nvIngredient, $poids);
        if (!$this->existeIngredient($nvIngredient)) {
            $insert = array_push($this->mesIngredients, $Ing_ajoutee);
            if ($insert) {
                $nvIngredient->ajouterRecette($this);
            }
            return $insert;
        } else {
            return false;
        }
    }

    public function retirerIngredient($ing_supp) {
        foreach ($this->getMesIngredients() as $ing) {
            if ($this->existeIngredient($ing[0])) {
                $ing_supp->retirerRecette($this);
                $index = array_search($ing, $this->mesIngredients);
                if ($index !== false) {
                    unset($this->mesIngredients[$index]);
                    return true;
                }
            }
        }
        return false;
    }


    public function existeIngredient($ing_recherche) {
        foreach ($this->getMesIngredients() as $ing) {
            if ($ing[0] == $ing_recherche) {
                return true;
            }
        }
        return false;
    }

    public function getPrix() {
        $prix = 0;
        foreach ($this->getMesIngredients() as $ing) {
            $prix+=$ing[0]->getPrix()*0.01*$ing[1];
        }
        return $prix;
    }

    public function afficherDetails() {
        echo "identifiant: " .$this->getIdentifiant() ."nom: " .$this->getNom() . ", temps: " .$this->getTemps() .", dif: " .$this->getDifficulte() .", instuction: " .$this->getInstruction() .", grammage: " .$this->getGrammage();
        echo "</br> je suis composer de ";
        foreach ($this->getMesIngredients() as $ing) {
            echo "</br>";
            echo $ing[1] ."de" .$ing[0]->getNom();
        }
        echo "</br>";
        echo $this->getPrix();
    }
}

class Utilisateur {
    private $identifiant;
    private $nom;
    private $prenom;
    private $date_naissance;
    private $tempsMin;
    private $mesPreferences;

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function setIdentifiant($i) {
        $this->identifiant = $i;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($n) {
        $this->nom = $n;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($p) {
        $this->prenom = $p;
    }

    public function getDate() {
        return $this->date_naissance;
    }

    public function setDate($b) {
        $this->date_naissance = $b;
    }

    public function getTempsMin() {
        return $this->tempsMin;
    }

    public function setTempsMin($t) {
        $this->tempsMin = $t;
    }

    public function getMesPreferences() {
        return $this->mesPreferences;
    }

    public function ajouterIngredient($i, $p) {
        $pairAjt = array($i, $p);
        return array_push($this->mesPreferences, $pairAjt);
    }

    public function retirerIngredient($i) {
        foreach ($this->getMesPreferences() as $ing) {
            if ($ing[0] == $i) {
                $index = array_search($ing, $this->mesPreferences);
                if ($index !== false) {
                    unset($this->mesPreferences[$index]);
                    return true;
                }
            }
        }
        return false;
    }

    public function existeIngredient($i) {
        foreach ($this->getMesPreferences() as $ing) {
            if ($ing[0] == $i) {
                return true;
            }
        }
        return false;
    }
}

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
        echo "prop :";
        echo $proportion;
        echo "<br>";
        echo "pointRE 1:";
        echo $nbPointRecette;
        echo "<br>";
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
    if ($val->getTemps() > $temps) {
        //On enleve des points à cette recette car elle ne rentre pas dans les critères de l'utilisateur
        $nbPointRecette -= ($val->getTemps()-$temps)/($temps*0.5)*40;
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

echo "<br>";
echo "recette :";
foreach ($lRecettePoint as $rec) {
    if ($rec['point']>0) {
        echo "</br>";
        echo "Recette: " . $rec['recette'] . ", Point: " . $rec['point'];
    }
}