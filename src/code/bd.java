import java.sql.*;

public class bd {
    public static void main(String[] args) {
        String url = "jdbc:mysql://localhost:3306/sae3.01"; // Remplace "nom_de_ta_base_de_donnees" par le nom réel de ta base de données
        String utilisateur = "root"; // Utilisateur MySQL par défaut pour WAMP
        String motDePasse = ""; // Laisse le mot de passe vide par défaut pour WAMP

        Connection connexion = null;

        try {
            // Connexion à la base de données
            connexion = DriverManager.getConnection(url, utilisateur, motDePasse);

            if (connexion != null) {
                System.out.println("Connexion réussie !");

                // Exemple de requête SQL (remplace-la par ta propre requête)
                String sql = "SELECT nom FROM Recette"; // Remplace "nom_de_ta_table" par le nom de ta propre table

                Statement statement = connexion.createStatement();
                ResultSet resultat = statement.executeQuery(sql);

                // Affichage des données résultantes
                while (resultat.next()) {
                    String recette = resultat.getString("nom");
                    System.out.println("recette: " + recette);
                }

                // Fermeture des ressources
                resultat.close();
                statement.close();
                connexion.close();
            }
        } catch (SQLException e) {
            System.out.println("La connexion à la base de données a échoué !");
            e.printStackTrace();
        }
    }
}
