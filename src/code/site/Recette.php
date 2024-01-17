<?php
/**
 * @file    Recette.php
 * @author  Souleymen
 * @brief   Spécifie une classe Recette avec tous ses attributs
 * @version 0.1
 * @date    17/01/2024
 */

class Recette {
    /**
     * @brief Identifiant de la recette
     */
    private $identifiant;
    /**
     * @brief Nom de la recette
     */
    private $nom;
    /**
     * @brief Temps de la recette
     */
    private $temps;
    /**
     * @brief Instruction de la recette
     */
    private $instruction;
    /**
     * @brief Difficulté de la recette
     */
    private $difficulte;
    /**
     * @brief Grammage de la recette
     */
    private $grammage;
    /**
     * @brief Initialiste la variables qui contiendra les ingredients de la recette
     */
    private $mesIngredients;

    /**
     * @brief Constructeur de recette
     *
     * @param int $id Identifiant de la recette
     * @param string $n Nom de la recette
     * @param int $t Temps de la recette
     * @param string $d Difficulté de la recette
     * @param string $i Instruction de la recette
     * @param int $g Grammage de la recette
     */
    public function __construct($id, $n, $t, $d, $i, $g) {
        $this->identifiant = $id;
        $this->nom = $n;
        $this->difficulte = $d;
        $this->temps = $t;
        $this->instruction = $i;
        $this->grammage = $g;
        $this->mesIngredients = array();
    }

    /**
     * @brief Recuperer le grammage de la recette
     *
     * @return int Grammage de la recette
     */
    public function getGrammage() {
        return $this->grammage;
    }

    /**
     * @brief Definir le grammage de la recette
     *
     * @param int $gram Nouveau grammage de la recette
     */
    public function setGrammage($gram) {
        $this->grammage = $gram;
    }

    /**
     * @brief Recuperer l'identifiant de la recette
     *
     * @return int Identifiant de la recette
     */
    public function getIdentifiant() {
        return $this->identifiant;
    }

    /**
     * @brief Definir l'identifiant de la recette
     *
     * @param int $id Nouvel identifiant de la recette
     */
    public function setIdentifiant($id) {
        $this->identifiant = $id;
    }

    /**
     * @brief Recuperer le nom de la recette
     *
     * @return string Nom de la recette
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @brief Definir le nom de la recette
     *
     * @param string $nvNom Nouveau nom de la recette
     */
    public function setNom($nvNom) {
        $this->nom = $nvNom;
    }

    // ... (méthodes similaires pour temps, difficulte, instruction)

    /**
     * @brief Recuperer les ingredients de la recette
     *
     * @return array Liste des ingrédients de la recette
     */
    public function getMesIngredients() {
        return $this->mesIngredients;
    }

    /**
     * @brief Ajouter un ingredient à la recette
     *
     * @param Ingredient $nvIngredient Nouvel ingrédient à ajouter
     * @param int $poids Poids de l'ingrédient dans la recette
     * @return bool Retourne true si l'ingrédient a été ajouté avec succès, false sinon
     */
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

    /**
     * @brief Retirer un ingredient de la recette
     *
     * @param Ingredient $ing_supp Ingrédient à retirer
     * @return bool Retourne true si l'ingrédient a été retiré avec succès, false sinon
     */
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

    /**
     * @brief Verifier si un ingredient existe dans la recette
     *
     * @param Ingredient $ing_recherche Ingrédient à rechercher dans la recette
     * @return bool Retourne true si l'ingrédient existe dans la recette, false sinon
     */
    public function existeIngredient($ing_recherche) {
        foreach ($this->getMesIngredients() as $ing) {
            if ($ing[0] == $ing_recherche) {
                return true;
            }
        }
        return false;
    }

    /**
     * @brief Recuperer le prix de la recette
     *
     * @return float Prix total de la recette calculé à partir des ingrédients
     */
    public function getPrix() {
        $prix = 0;
        foreach ($this->getMesIngredients() as $ing) {
            $prix += $ing[0]->getPrix() * 0.01 * $ing[1];
        }
        return $prix;
    }

    /**
     * @brief Afficher les details de la recette
     *
     * Affiche les détails de la recette, y compris son identifiant, nom, temps, difficulté, instruction, grammage,
     * les ingrédients et leur poids, ainsi que le prix total de la recette.
     */
    public function afficherDetails() {
        echo "identifiant: " . $this->getIdentifiant() . "nom: " . $this->getNom() . ", temps: " . $this->getTemps() . ", dif: " . $this->getDifficulte() . ", instuction: " . $this->getInstruction() . ", grammage: " . $this->getGrammage();
        echo "</br> je suis composé de ";
        foreach ($this->getMesIngredients() as $ing) {
            echo "</br>";
            echo $ing[1] . " de " . $ing[0]->getNom();
        }
        echo "</br>";
        echo "Prix total : " . $this->getPrix();
    }
}
?>