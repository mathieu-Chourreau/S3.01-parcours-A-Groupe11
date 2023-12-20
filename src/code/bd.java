import java.sql.*;

public class bd {
    public static void main(String[] args) {
        String url = "jdbc:mysql://localhost:3306/sae3.01";
        String utilisateur = "root"; 
        String motDePasse = "";

        Connection connexion = null;

        try {
            connexion = DriverManager.getConnection(url, utilisateur, motDePasse);

            if (connexion != null) {
                System.out.println("Connexion réussie !");

                String sql = "SELECT nom, prix FROM Recette";

                Statement statement = connexion.createStatement();
                ResultSet resultat = statement.executeQuery(sql);

                while (resultat.next()) {
                    String recette = resultat.getString("nom");
                    int prix = resultat.getInt("prix");
                    System.out.println("recette: " + recette + " prix: " + prix);
                }

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
