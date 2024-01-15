<<<<<<< HEAD
<?php

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

?>
=======
<?php

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

?>
>>>>>>> modifInterfaceEnUnePagePhp
