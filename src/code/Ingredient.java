/**
 * @file Ingredient.java
 * @author Chourreau Mathieu, Fermé Léo, Piel Nathan, Zaza Souleymen
 * @brief 
 * @version 1
 * @date 2023-11-16
 * 
 * @copyright Copyright (c) 2023
 * 
 */

public class Ingredient {
    private String nom;
    private float prix;
    private Recette maRecette;
    private String categorie;
    public ArrayList<Recette> lesRecettes;

    public Ingredient() {
        // Default constructor
    }

    public Ingredient(String INom, String IPrix, String ICategorie) {
        nom = INom;
        prix = IPrix;
        categorie = ICategorie;
    }

    public Ingredient(Ingredient Ing) {
        nom = Ing.getNom();
        prix = Ing.getPrix();
        maRecette = Ing.getMaRecette();
        categorie = Ing.getCategorie();
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String newNom) {
        nom = newNom;
    }

    public float getPrix() {
        return prix;
    }

    public void setPrix(float newPrix) {
        prix = newPrix;
    }

    public Recette getMaRecette() {
        return maRecette;
    }

    public void setMaRecette(Recette newRecette) {
        maRecette = newRecette;
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String newCategorie) {
        categorie = newCategorie;
    }

    // Déclaration des fonctions lierIngredient et delierIngredient
    public void lierIngredient(Recette recette) {
        setMaRecette(recette);
        recette.getMesIngredients().add(new Recette.Pair(this, ""));
    }

    public void delierIngredient() {
        if (maRecette != null) {
            maRecette.getMesIngredients().removeIf(pair -> pair.getIngredient() == this);
            setMaRecette(null);
        }
    }
}
