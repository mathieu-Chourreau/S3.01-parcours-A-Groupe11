import java.util.ArrayList;

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
    private double prix;
    private String categorie;
    public ArrayList<Recette> lesRecettes;


    public Ingredient(String INom, double IPrix, String ICategorie) {
        nom = INom;
        prix = IPrix;
        categorie = ICategorie;
        lesRecettes = new ArrayList<Recette>();
    }

    public Ingredient(Ingredient Ing) {
        nom = Ing.getNom();
        prix = Ing.getPrix();
        categorie = Ing.getCategorie();
        lesRecettes = Ing.getLesRecette();
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String newNom) {
        nom = newNom;
    }

    public double getPrix() {
        return prix;
    }

    public void setPrix(float newPrix) {
        prix = newPrix;
    }

    public ArrayList<Recette> getLesRecette() {
        return lesRecettes;
    }

    public boolean ajouterRecette(Recette r){
        if (!existeRecette(r)) {
            return lesRecettes.add(r);   
        }
        else{
            return false;
        }
    }
    
    public boolean retirerRecette(Recette r){
        return lesRecettes.remove(r);
    }

    public boolean existeRecette(Recette r){
        return lesRecettes.contains(r);
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String newCategorie) {
        categorie = newCategorie;
    }
}
