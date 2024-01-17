<?php
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

?>
