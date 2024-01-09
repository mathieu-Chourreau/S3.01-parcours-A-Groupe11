<?php
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

    public function setNom($newNom) {
        $this->nom = $newNom;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($newPrix) {
        $this->prix = $newPrix;
    }

    public function getLesRecette() {
        return $this->lesRecettes;
    }

    public function ajouterRecette($r) {
        if (!$this->existeRecette($r)) {
            $this->lesRecettes[] = $r;
            return true;
        } else {
            return false;
        }
    }

    public function retirerRecette($r) {
        $key = array_search($r, $this->lesRecettes);
        if ($key !== false) {
            unset($this->lesRecettes[$key]);
            return true;
        } else {
            return false;
        }
    }

    public function existeRecette($r) {
        return in_array($r, $this->lesRecettes);
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function setCategorie($newCategorie) {
        $this->categorie = $newCategorie;
    }
}

?>
