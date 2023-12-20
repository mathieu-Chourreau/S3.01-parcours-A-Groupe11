import java.util.ArrayList;

import javafx.util.Pair;

/**
 * @file Ingredient.h
 * @author Chourreau Mathieu, Fermé Léo, Piel Nathan, Zaza Souleymen
 * @brief 
 * @version 0
 * @date 2023-11-16
 * 
 * @copyright Copyright (c) 2023
 * 
 */

public class Utilisateur
{
    //ATTRIBUTS
    private int identifiant;
    private String nom;
    private String prenom;
    private int budget;
    private int tempsMax;
    private ArrayList<Pair<Ingredient, Double>> mesPreferences;

    //ENCAPSULATION
    public int getIdentifiant(){
        return identifiant;
    }

    public void setIdentifiant(int i){
        identifiant=i;
    }

    public String getNom(){
        return nom;
    }

    public void setNom(String n){
        nom=n;
    }

    public String getPrenom(){
        return prenom;
    }

    public void setPrenom(String p){
        prenom=p;
    }

    public int getBudget(){
        return budget;
    }

    public void setBudget(int b){
        budget=b;
    }

    public int getTempsMax(){
        return tempsMax;
    }

    public void setTempsMax(int t){
        tempsMax = t;
    }

    public ArrayList<Pair<Ingredient, Double>> getMesPreferences(){
        return mesPreferences;
    }

    public boolean ajouterIngredient(Ingredient i, double p){
        Pair<Ingredient, Double> pairAjt = new Pair<Ingredient,Double>(i, p);
        return mesPreferences.add(pairAjt);
    }

    public boolean retirerIngredient(Ingredient i){
        for(Pair<Ingredient,Double> ing:getMesPreferences()){
            if (ing.getKey() == i) {
                return mesPreferences.remove(ing);
            }
        }
        return false;
    }

    public boolean existeIngredient(Ingredient i){
        for(Pair<Ingredient,Double> ing:getMesPreferences()){
            if (ing.getKey() == i) {
                return mesPreferences.contains(ing);
            }
        }
        return false;
    }
}