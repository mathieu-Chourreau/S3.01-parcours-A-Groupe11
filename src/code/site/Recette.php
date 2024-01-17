<?php
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
?>