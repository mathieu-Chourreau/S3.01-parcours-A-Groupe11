<?php

include '../bd.php';
$conn = connexionBd();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recette_id = $_POST["recette_id"];
    $action = $_POST["action"];

    if ($action == "Ajouter") {
        // Récupérer le nom de la recette sélectionnée
        $nom_recette = $_POST["nom_recette"];

        // Vérifier si le nom de la recette existe déjà dans la table recette
        $sql_nom_recette = "SELECT nom FROM recette WHERE nom = ?";
        $stmt_nom_recette = $conn->prepare($sql_nom_recette);
        $stmt_nom_recette->bind_param("s", $nom_recette);
        $stmt_nom_recette->execute();
        $result_nom_recette = $stmt_nom_recette->get_result();

        if ($result_nom_recette->num_rows > 0) {
            echo '<script>alert("Le nom de la recette existe déjà dans la table recette."); window.location.href = "back_office.php";</script>';
            exit;
        } else {
            // Récupérer l'identifiant maximum actuel dans la table recette
            $sql_max_id = "SELECT MAX(identifiant) AS max_id FROM recette";
            $result_max_id = $conn->query($sql_max_id);
            $row_max_id = $result_max_id->fetch_assoc();
            $new_recette_id = $row_max_id['max_id'] + 1;

            // Récupérer les détails de la recette à partir de la table recetteavalider
            $sql_get_recette_details = "SELECT nom, description, tempsPreparation, difficulte, grammage, categorie FROM recetteavalider WHERE id = ?";
            $stmt_get_recette_details = $conn->prepare($sql_get_recette_details);
            $stmt_get_recette_details->bind_param("i", $recette_id);
            $stmt_get_recette_details->execute();
            $result_get_recette_details = $stmt_get_recette_details->get_result();

            if ($result_get_recette_details->num_rows > 0) {
                $row_recette_details = $result_get_recette_details->fetch_assoc();

                $grammage = $row_recette_details['grammage'] ?? 0; 

                // Insérer la recette dans la table recette avec le nouvel identifiant unique
                $sql_insert_recette = "INSERT INTO recette (identifiant, nom, instruction, temps_min_, niveau_difficulte, grammage) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_recette = $conn->prepare($sql_insert_recette);
                $stmt_insert_recette->bind_param("issssi", $new_recette_id, $nom_recette, $row_recette_details['description'], $row_recette_details['tempsPreparation'], $row_recette_details['difficulte'], $grammage);
                $stmt_insert_recette->execute();
                
                echo '<script>alert("Recette ajoutée avec succès dans la table recette."); window.location.href = "back_office.php";</script>';

                $sql = "DELETE FROM recetteavalider WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $recette_id);
                $stmt->execute();

                echo '<script>alert("Recette avec l\'ID '.$recette_id.' supprimée avec succès."); window.location.href = "back_office.php";</script>';

                $stmt_insert_recette->close();
                exit;
            } else {
                echo '<script>alert("La recette n\'existe pas dans la table recetteavalider."); window.location.href = "back_office.php";</script>';
                exit;
                

            }

            // Fermer la connexion à la base de données
            $stmt_get_recette_details->close();
        }

        // Fermer la connexion à la base de données
        $stmt_nom_recette->close();
    } else {
        $conn = connexionBd();
        $sql = "DELETE FROM recetteavalider WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $recette_id);
        $stmt->execute();

        echo '<script>alert("Recette avec l\'ID '.$recette_id.' supprimée avec succès."); window.location.href = "back_office.php";</script>';
        exit;


        $stmt->close();
        $conn->close();
    }
} else {
    echo '<script>alert("Aucune soumission de formulaire."); window.location.href = "back_office.php";</script>';
    exit;
}
?>
