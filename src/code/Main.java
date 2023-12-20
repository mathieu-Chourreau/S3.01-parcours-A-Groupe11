import javafx.util.Pair;

public class Main {
    public static void main(String[] args) {
        // Création d'une recette
        Recette recette = new Recette("poulet", 10.5, "facile", "sucre", 25);

        // Création d'ingrédients
        Ingredient ingredient1 = new Ingredient("Poulet", 10, "viandeBlanche");
        Ingredient ingredient2 = new Ingredient("fritte", 2, "Autre");

        // Liaison des ingrédients à la recette
        recette.ajouterIngredient(ingredient1, 10);
        recette.ajouterIngredient(ingredient2, 5);

        // Affichage des détails de la recette
        System.out.println("Nom de la recette: " + recette.getNom());
        System.out.println("Temps de préparation: " + recette.getTemps());
        System.out.println("Difficulté: " + recette.getDifficulte());
        System.out.println("Catégorie: " + recette.getCategorie());
        System.out.println("Prix: " + recette.getPrix());

        // Affichage des ingrédients de la recette
        System.out.println("\nIngrédients de la recette:");
        for (Pair<Ingredient, Integer> pair : recette.getMesIngredients()) {
            System.out.println(pair.getKey().getNom() + " - Quantité(g): " + pair.getValue());
        }
    }
}
