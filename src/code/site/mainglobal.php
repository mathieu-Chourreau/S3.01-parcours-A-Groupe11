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
    private $prix;
    private $categorie;
    private $lesRecettes;

    public function __construct($INom, $IPrix, $ICategorie) {
        $this->nom = $INom;
        $this->prix = $IPrix;
        $this->categorie = $ICategorie;
        $this->lesRecettes = array();
    }

    public function __constructCopy(Ingredient $Ing) {
        $this->nom = $Ing->getNom();
        $this->prix = $Ing->getPrix();
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
        return $this->prix;
    }

    public function setPrix($nvPrix) {
        $this->prix = $nvPrix;
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
    private $temps;
    private $nom;
    private $difficulte;
    private $categorie;
    private $mesIngredients;

    public function __construct($n, $t, $d, $c) {
        $this->nom = $n;
        $this->difficulte = $d;
        $this->temps = $t;
        $this->categorie = $c;
        $this->mesIngredients = array();
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

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($nvCategorie) {
        $this->categorie = $nvCategorie;
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
}

class Utilisateur {
    private $identifiant;
    private $nom;
    private $prenom;
    private $budget;
    private $tempsMax;
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

    public function getBudget() {
        return $this->budget;
    }

    public function setBudget($b) {
        $this->budget = $b;
    }

    public function getTempsMax() {
        return $this->tempsMax;
    }

    public function setTempsMax($t) {
        $this->tempsMax = $t;
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
$budget = $ingPageSale['prix'];
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

    $sql = "SELECT DISTINCT(r.identifiant) as identifiant_recette,r.nom as nom_recette, r.instruction as instruction_recette, r.temps_min_ as temps_recette, r.niveau_difficulte as niveau_recette, r.grammage as grammage_recette, r.identifiantVideo as identifiantVid_recette 
    FROM RECETTE r
    JOIN CONTENIR c ON r.identifiant = c.recette_id  
    JOIN INGREDIENT i ON c.ingredient_id = i.nom
    WHERE r.IDENTIFIANT NOT IN (SELECT rt.IDENTIFIANT
                                FROM RECETTE rt
                                JOIN CONTENIR ct ON rt.identifiant = ct.recette_id  
                                JOIN INGREDIENT ig ON ct.ingredient_id = ig.nom
                                WHERE ig.NOM IN $conditionWhere)
    ORDER BY r.identifiant;";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['nom_recette'];
            $row['nom_recette'] = new Recette();
        }
    }
}