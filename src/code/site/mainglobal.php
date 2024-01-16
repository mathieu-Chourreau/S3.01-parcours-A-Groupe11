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
    foreach ($_SESSION['ingredientsPreferences'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
    echo "<h2>Préférences des ingrédients (Page Sale) :</h2>";
    echo "<ul>";
    foreach ($_SESSION['ingredientsPreferencesPageSale'] as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
} else {
    echo "Le formulaire n'a pas été soumis.";
}

if (!isset($_SESSION['ingredientsPreferences'])) {
    $_SESSION['ingredientsPreferences'] = $ingPref;
}

if (!isset($_SESSION['ingredientsPreferencesPageSale'])) {
    $_SESSION['ingredientsPreferencesPageSale'] = $ingPageSale;
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
    public function afficherDetails() {
        echo "identifiant: " .$this->getIdentifiant() ."nom: " .$this->getNom() . ", temps: " .$this->getTemps() .", dif: " .$this->getDifficulte() .", instuction: " .$this->getInstruction() .", grammage: " .$this->getGrammage();
        echo "</br> je suis composer de ";
        foreach ($this->getMesIngredients() as $ing) {
            echo "</br>";
            echo $ing[1] ."de" .$ing[0]->getNom();
        }
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

// Récuperer les préférences de l'utilisateur
foreach ($_SESSION['ingredientsPreferences'] as $nomIngredient => $valeur) {
    //Stocker l'ingredient en fonction de la preference
    if ($valeur == 0){
        $pileIngredientRefus[$nomIngredient] = $valeur;
    }
    else{
        $lIngredientPref[$nomIngredient] = $valeur;
    }
}

if (isset($pileIngredientRefus)){
    foreach ($pileIngredientRefus as $nomIngredient => $valeur) {
        echo "<li>$nomIngredient : $valeur</li>";
    }
    echo "</ul>";
}

// Récuperer le salé
/*
$sale = $ingPageSale['sale'];
$temps = $ingPageSale['temps'];
$date_naissance = $ingPageSale['prixKg'];
*/

// tri des recettes en fonction des préférences

// Récupérer toutes les recettes qui comportent seulement des ingredients que l'utilisateur souhaite

if (isset($pileIngredientRefus)){
    $conditionWhere = '';
    // Creer et excecuter la requete

    foreach ($pileIngredientRefus as $nomIngredient => $valeur) {
        $conditionWhere = "".$conditionWhere .",'" .$nomIngredient ."'";
    }
    $conditionWhere = substr($conditionWhere, 1);
    $conditionWhere = "(".$conditionWhere .")";

    $sql = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette, r.instruction as instruction_recette, r.temps_min_ as temps_recette, r.niveau_difficulte as niveauDif_recette, r.grammage as grammage_recette, r.identifiantVideo as identifiantVid_recette 
    FROM RECETTE r
    JOIN CONTENIR c ON r.identifiant = c.recette_id  
    JOIN INGREDIENT i ON c.ingredient_id = i.nom
    WHERE r.IDENTIFIANT NOT IN (SELECT rt.IDENTIFIANT
                                FROM RECETTE rt
                                JOIN CONTENIR ct ON rt.identifiant = ct.recette_id  
                                JOIN INGREDIENT ig ON ct.ingredient_id = ig.nom
                                WHERE ig.NOM IN $conditionWhere)
    ORDER BY r.identifiant;";

    $resultR = $conn->query($sql);
    $nomVar = "";

    if ($resultR && $resultR->num_rows > 0) {
        while ($row = $resultR->fetch_assoc()) {
            $nomVar = "recette".$row['identifiant_recette'];
            $$nomVar = new Recette($row['identifiant_recette'], $row['nom_recette'], $row['temps_recette'], $row['niveauDif_recette'], $row['instruction_recette'], $row['grammage_recette']);
            $sql= "SELECT i.nom as nom_ingr, i.prixKG as prix, ci.categorie as categorie, c.quantite as quantite
                    FROM ingredient i
                    JOIN categorieingredient ci on i.identifiantC = ci.identifiant
                    JOIN contenir c ON i.nom = c.Ingredient_id
                    JOIN recette r ON c.Recette_id = r.identifiant
                    WHERE r.identifiant =". $row['identifiant_recette'].";";
            $resultI = $conn->query($sql);
            if ($resultI && $resultI->num_rows > 0) {
                while ($row = $resultI->fetch_assoc()) {
                    $nomVarI = "".$row['nom_ingr'];
                    $nomVarI = str_replace(' ', '_', $nomVarI);
                    if (!isset($$nomVarI)) {
                        $$nomVarI = new Ingredient($row['nom_ingr'], $row['prix'], $row['categorie']);
                        $$nomVar->ajouterIngredient($$nomVarI,$row['quantite']);
                        $$nomVarI->ajouterRecette($$nomVar);
                    }
                }
            }   
        }
    }
    $recette1->afficherDetails();
}   

/*echo "</br>";
  $sql = "SELECT ";
  $resultR = $conn->query($sql);*/