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

?>
