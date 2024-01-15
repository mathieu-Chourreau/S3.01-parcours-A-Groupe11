<?php 

session_start();

if (!isset($_SESSION['ingredientsPreferences'])) {
    $_SESSION['ingredientsPreferences'] = $ingPref;
}

if (!isset($_SESSION['ingredientsPreferencesPageSale'])) {
    $_SESSION['ingredientsPreferencesPageSale'] = $ingPageSale;
}

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
    private $prix;
    private $mesIngredients;

    public function __construct($n, $t, $d, $c, $p) {
        $this->nom = $n;
        $this->difficulte = $d;
        $this->temps = $t;
        $this->categorie = $c;
        $this->prix = $p;
        $this->mesIngredients = array();
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

foreach ($ingPref as $nomIngredient => $valeur) {
    //Stocker l'ingredient en fonction de la preference
    if ($valeur ===0){
        $lIngredientPref[$nomIngredient] = $valeur;
    }
    else{
        $pileIngredientRefus[$nomIngredient] = $valeur;
    }
}

// Récuperer le salé

$sale = $ingPageSale['sale'];
$temps = $ingPageSale['temps'];
$budget = $ingPageSale['prix'];


// tri des recettes en fonction des préférences

// Récupérer toutes les recettes qui comportent seulement des ingredients que l'utilisateur souhaite

$conditionWhere = "libelle = ";

// Creer et excecuter la requete

foreach ($pileIngredientRefus as $nomIngredient => $valeur) {
    $conditionWhere = $conditionWhere + $nomIngredient;
}

$sql = "SELECT * FROM Recette WHERE libelle NOT IN (SELECT libelle FROM Recette R JOIN ingredient ON R.id_ingredient = ingredient.id  WHERE $conditionWhere )";
$result = $conn->query($sql);