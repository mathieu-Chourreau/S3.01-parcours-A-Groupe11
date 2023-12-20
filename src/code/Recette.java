import java.util.ArrayList;
import javafx.util.Pair;

public class Recette {
    private double temps;
    private String nom;
    private String difficulte;
    private String categorie;
    private float prix;
    private ArrayList<Pair<Ingredient, Integer>> mesIngredients;

    public Recette(String n, double t, String d, String c, float p) {
        nom = n;
        difficulte = d;
        temps = t;
        categorie = c;
        prix = p;
        mesIngredients = new ArrayList<Pair<Ingredient, Integer>>();
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

    public double getTemps() {
        return temps;
    }

    public void setTemps(float newTemps) {
        temps = newTemps;
    }

    public String getDifficulte() {
        return difficulte;
    }

    public void setDifficulte(String newDifficulte) {
        difficulte = newDifficulte;
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String newCategorie) {
        categorie = newCategorie;
    }

    public ArrayList<Pair<Ingredient, Integer>> getMesIngredients() {
        return mesIngredients;
    }

    public boolean ajouterIngredient(Ingredient i, int p){
        Pair<Ingredient, Integer> pairAjt = new Pair<Ingredient,Integer>(i, p);
        if (!existeIngredient(i)) {
            boolean insert = mesIngredients.add(pairAjt);
            if (insert) {
                i.ajouterRecette(this);
            }
            return insert;   
        }
        else{
            return false;
        }
    }

    public boolean retirerIngredient(Ingredient i){
        for(Pair<Ingredient,Integer> ing:getMesIngredients()){
            if (existeIngredient(ing.getKey())) {
                i.retirerRecette(this);
                return mesIngredients.remove(ing);
            }
        }
        return false;
    }

    public boolean existeIngredient(Ingredient i){
        for(Pair<Ingredient,Integer> ing:getMesIngredients()){
            if (ing.getKey() == i) {
                return mesIngredients.contains(ing);
            }
        }
        return false;
    }

}
