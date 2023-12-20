import java.util.ArrayList;
import java.util.List;

public class Recette {
    private float temps;
    private String nom;
    private int difficulte;
    private String categorie;
    private float prix;
    private List<ArrayList<Ingredient, String>> mesIngredients;

    public class Ingredient {}

    public Recette() {
        difficulte = 1;
        mesIngredients = new ArrayList<>();
    }

    public Recette(String RNom) {
        nom = RNom;
        difficulte = 1;
        mesIngredients = new ArrayList<>();
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

    public float getTemps() {
        return temps;
    }

    public void setTemps(float newTemps) {
        temps = newTemps;
    }

    public int getDifficulte() {
        return difficulte;
    }

    public void setDifficulte(int newDifficulte) {
        difficulte = newDifficulte;
    }

    public String getCategorie() {
        return categorie;
    }

    public void setCategorie(String newCategorie) {
        categorie = newCategorie;
    }

    public List<ArrayList<Object>> getMesIngredients() {
        return mesIngredients;
    }
}
