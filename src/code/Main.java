public class Main {
    public static void main(String[] args) {
        // Création d'une recette
        Recette recette = new Recette("Recette1");
        recette.setTemps("30 minutes");
        recette.setDifficulte(2);
        recette.setCategorie("Dessert");
        recette.setPrix("Abordable");

        // Création d'ingrédients
        Ingredient ingredient1 = new Ingredient("Farine", "2 cups", "Sec");
        Ingredient ingredient2 = new Ingredient("Sucre", "1 cup", "Sucré");

        // Liaison des ingrédients à la recette
        ingredient1.lierIngredient(recette);
        ingredient2.lierIngredient(recette);

        // Affichage des détails de la recette
        System.out.println("Nom de la recette: " + recette.getNom());
        System.out.println("Temps de préparation: " + recette.getTemps());
        System.out.println("Difficulté: " + recette.getDifficulte());
        System.out.println("Catégorie: " + recette.getCategorie());
        System.out.println("Prix: " + recette.getPrix());

        // Affichage des ingrédients de la recette
        System.out.println("\nIngrédients de la recette:");
        for (Recette.Pair pair : recette.getMesIngredients()) {
            System.out.println(pair.getIngredient().getNom() + " - Quantité: " + pair.getQuantity());
        }
    }
}
