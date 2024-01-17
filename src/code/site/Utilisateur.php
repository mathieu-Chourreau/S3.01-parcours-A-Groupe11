<?php
/**
 * @file    Utilisateur.php
 * @author  Souleymen
 * @brief   Spécifie une classe Utilisateur avec tous ses attributs
 * @version 0.1
 * @date    17/01/2024
 */

class Utilisateur {
    /**
     * @brief L'identifiant de l'utilisateur
     */
    private $identifiant;
    /**
     * @brief Le nom de l'utilisateur
     */
    private $nom;
    /**
     * @brief Le prenom de l'utilisateur
     */
    private $prenom;
    /**
     * @brief La date de naissance de l'utilisateur
     */
    private $date_naissance;
    /**
     * @brief Le temps minimum que l'utilisateur veut mettre à faire une recette
     */
    private $tempsMin;
    /**
     * @brief Les préférences de l'utilisateur
     */
    private $mesPreferences;

    /**
     * @brief Récuperer l'identifiant de l'utilisateur
     *
     * @return int Identifiant de l'utilisateur
     */
    public function getIdentifiant() {
        return $this->identifiant;
    }

    /**
     * @brief Définir l'identifiant de l'utilisateur
     *
     * @param int $i Nouvel identifiant de l'utilisateur
     */
    public function setIdentifiant($i) {
        $this->identifiant = $i;
    }

    /**
     * @brief Récuperer le nom de l'utilisateur
     *
     * @return string Nom de l'utilisateur
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * @brief Définir le nom de l'utilisateur
     *
     * @param string $n Nouveau nom de l'utilisateur
     */
    public function setNom($n) {
        $this->nom = $n;
    }

    /**
     * @brief Récuperer le prénom de l'utilisateur
     *
     * @return string Prénom de l'utilisateur
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * @brief Définir le prénom de l'utilisateur
     *
     * @param string $p Nouveau prénom de l'utilisateur
     */
    public function setPrenom($p) {
        $this->prenom = $p;
    }

    /**
     * @brief Récuperer la date de naissance de l'utilisateur
     *
     * @return string Date de naissance de l'utilisateur
     */
    public function getDate() {
        return $this->date_naissance;
    }

    /**
     * @brief Définir la date de naissance de l'utilisateur
     *
     * @param string $b Nouvelle date de naissance de l'utilisateur
     */
    public function setDate($b) {
        $this->date_naissance = $b;
    }

    /**
     * @brief Recuperer le temps minimum que l'utilisateur veut mettre à faire une recette
     *
     * @return int Temps minimum pour faire une recette
     */
    public function getTempsMin() {
        return $this->tempsMin;
    }

    /**
     * @brief Définir le temps minimum que l'utilisateur veut mettre à faire une recette
     *
     * @param int $t Nouveau temps minimum pour faire une recette
     */
    public function setTempsMin($t) {
        $this->tempsMin = $t;
    }

    /**
     * @brief Recuperer les préférences de l'utilisateur
     *
     * @return array Liste des préférences de l'utilisateur
     */
    public function getMesPreferences() {
        return $this->mesPreferences;
    }

    /**
     * @brief Ajouter un ingrédient à la liste des préférences de l'utilisateur
     *
     * @param Ingredient $i Nouvel ingrédient à ajouter
     * @param int $p Poids de l'ingrédient dans les préférences
     * @return int Nombre d'éléments après l'ajout
     */
    public function ajouterIngredient($i, $p) {
        $pairAjt = array($i, $p);
        return array_push($this->mesPreferences, $pairAjt);
    }

    /**
     * @brief Retirer un ingrédient de la liste des préférences de l'utilisateur
     *
     * @param Ingredient $i Ingrédient à retirer
     * @return bool Retourne true si l'ingrédient a été retiré avec succès, false sinon
     */
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

    /**
     * @brief Verifier si un ingrédient existe dans les préférences de l'utilisateur
     *
     * @param Ingredient $i Ingrédient à rechercher dans les préférences
     * @return bool Retourne true si l'ingrédient existe dans les préférences, false sinon
     */
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
