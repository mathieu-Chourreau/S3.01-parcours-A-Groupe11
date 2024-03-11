<?php
/**
 * @file    Ingredient.php
 * @author  Souleymen
 * @brief   Spécifie une classe Ingredient avec tous ses attributs
 * @version 0.1
 * @date    17/01/2024
 */
class Ingredient {
    /**
     * @brief Nom de la recette
     */
    private $nom;
    /**
     * @brief prixKg de la recette
     */
    private $prixKg;
    /**
     * @brief categorie de la recette
     */
    private $categorie;
    /**
     * @brief Les recettes qui sont associé l'ingredient
     */
    private $lesRecettes;

    /**
     * @brief Constructeur de la classe Ingredient
     *
     * @param string $INom Nom de l'ingrédient
     * @param float $IPrix Prix par kilogramme de l'ingrédient
     * @param string $ICategorie Catégorie de l'ingrédient
     */
    public function __construct($INom, $IPrix, $ICategorie) {
        // Initialisation des attributs avec les valeurs passées en paramètres
        $this->nom = $INom;
        $this->prixKg = $IPrix;
        $this->categorie = $ICategorie;
        $this->lesRecettes = array();
    }

    /**
     * @brief Constructeur de copie de la classe Ingredient
     *
     * @param Ingredient $Ing L'objet Ingredient à copier
     */
    public function __constructCopy(Ingredient $Ing) {
        // Copie des propriétés de l'objet existant
        $this->nom = $Ing->getNom();
        $this->prixKg = $Ing->getPrix();
        $this->categorie = $Ing->getCategorie();
        $this->lesRecettes = $Ing->getLesRecette();
    }

    /**
     * @brief Récupérer le nom de l'ingrédient
     *
     * @return string Nom de l'ingrédient
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @brief Définir le nom de l'ingrédient
     *
     * @param string $nvNom Nouveau nom de l'ingrédient
     */
    public function setNom($nvNom) {
        $this->nom = $nvNom;
    }

    /**
     * @brief Récupérer le prix par kilogramme de l'ingrédient
     *
     * @return float Prix par kilogramme de l'ingrédient
     */
    public function getPrix() {
        return $this->prixKg;
    }

    /**
     * @brief Définir le prix par kilogramme de l'ingrédient
     *
     * @param float $nvPrix Nouveau prix par kilogramme de l'ingrédient
     */
    public function setPrix($nvPrix) {
        $this->prixKg = $nvPrix;
    }

    /**
     * @brief Récupérer la liste des recettes associées à l'ingrédient
     *
     * @return array Liste des recettes associées à l'ingrédient
     */
    public function getLesRecette() {
        return $this->lesRecettes;
    }

    /**
     * @brief Ajouter une recette à la liste des recettes associées à l'ingrédient
     *
     * @param Recette $recette Recette à ajouter
     * @return bool Retourne true si la recette a été ajoutée avec succès, false sinon
     */
    public function ajouterRecette($recette) {
        if (!$this->existeRecette($recette)) {
            $this->lesRecettes[] = $recette;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @brief Retirer une recette de la liste des recettes associées à l'ingrédient
     *
     * @param Recette $recette Recette à retirer
     * @return bool Retourne true si la recette a été retirée avec succès, false sinon
     */
    public function retirerRecette($recette) {
        $cle = array_search($recette, $this->lesRecettes);
        if ($cle !== false) {
            unset($this->lesRecettes[$cle]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @brief Vérifier si une recette existe dans la liste des recettes associées à l'ingrédient
     *
     * @param Recette $recette Recette à vérifier
     * @return bool Retourne true si la recette existe, false sinon
     */
    public function existeRecette($recette) {
        return in_array($recette, $this->lesRecettes);
    }

    /**
     * @brief Récupérer la catégorie de l'ingrédient
     *
     * @return string Catégorie de l'ingrédient
     */
    public function getCategorie() {
        return $this->categorie;
    }

    /**
     * @brief Définir la catégorie de l'ingrédient
     *
     * @param string $nvCategorie Nouvelle catégorie de l'ingrédient
     */
    public function setCategorie($nvCategorie) {
        $this->categorie = $nvCategorie;
    }
}
?>