<?php
/**
 * @file    sale.php
 * @author  Mathieu
 * @brief   La page Sale permet à l'utilisateur de saisir son prix, son temps et si il veut du salé
 * @version 0.1
 * @date    17/01/2024
 */

session_start();

include_once '../bd.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les clés existent dans $_POST avant de les utiliser
    if (isset($_POST['vege'], $_POST['zone_prix'], $_POST['zone_temps'])) {
        // Connexion à la base de données
        $conn = connexionBd();

        // Récupération des données du formulaire
        $user_id = $_SESSION['login_username'];
        $vege = $_POST['vege'];
        $budget = $_POST['zone_prix'];
        $temps = $_POST['zone_temps'];

        // Préparation de la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO preferencesComplementaires (user_id ,vege_pref, budget, tempsCuisine) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $user_id, $vege, $budget, $temps);

        // Exécution de la requête
        if ($stmt->execute() === TRUE) {
            echo "<script>alert('Enregistrement des préférences réussi.');</script>";
        } else {
            echo "<script>alert('Erreur lors de l\'enregistrement des préférences: " . $conn->error . "');</script>";
        }

        // Fermeture de la requête et de la connexion
        $stmt->close();
        $conn->close();
    } else {

    }
}

// Vérification de l'ID de l'utilisateur dans la table des préférences complémentaires
$conn = connexionBd();
$user_id = $_SESSION['login_username'];
$stmt = $conn->prepare("SELECT user_id, budget, vege_pref, tempsCuisine FROM preferencesComplementaires WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    // L'utilisateur a des préférences enregistrées, récupérons les valeurs et affichons-les dans un prompt
    $row = $result->fetch_assoc();
    $vege_pref = $row['vege_pref'];
    $tempsCuisine = $row['tempsCuisine'];
    $budgtPref = $row['budget'];

}
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Edu'Cook</title>

    <link rel="stylesheet" href="sale.css">
    <link rel="stylesheet" href="../commun/commun.css">
</head>

<body>


    <div class="background"></div>

    <nav id="nav">
        <div id="imgLogoNav">
            <a href="#"><img class="img_logo" src="../image/logo.png"></a>
            <div class="boutonHamburger">
                <label class="burger" id="burger" for="burger">
                    <input type="checkbox" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="titreMenu">
            <ul id="menu">
                <li><a href="../index.php" class="link">Accueil</a></li>
                <li><a href="../recherche/recherche.php" class="link">Rechercher</a></li>
                <li><a href="formulaire.php" class="link active">Formulaire</a></li>
                <li><a href="../equipe/equipe.php" class="link">L'équipe</a></li>
                <li><a href="../proposerRecette/proposRecette.php" class="link">Proposer votre recette</a></li>
                <?php if ($_SESSION['admin'] == false) { ?>
                <?php } elseif ($_SESSION['admin'] == true) {
                    echo "<li><a href='backOffice/back_office.php' class='link'>Gerer les recettes</a></li>";
                } ?>
            </ul>
        </div>
        <div class="boutonConnexion">
            <?php if ($_SESSION['connecter'] == false) { ?>
                <a href="connexion/connexion.php" id="lien_se_connecter"><button class="btn white-btn" id="loginBtn">Se
                        connecter</button></a>
            <?php } elseif ($_SESSION['connecter'] == true) {
                echo "<button class='btn white-btn' id='loginBtn'><a href='connexion/deconnexion.php' id='lien_se_connecter'>Se déconnecter</a></button>";
            } ?>
        </div>
    </nav>

    <form id="example" method="POST">
        <div class="container_form">
            <div id="categorie">
                <img class="etoile" src="../image/pngegg.png">
                <div class="nom_categorie">Informations complémentaires</div>
                <img class="etoile" src="../image/pngegg.png">
            </div>

            <div class="formulaire">
                <form action="affichage_recette.php" method="post">

                    <div class="vege">
                        <label class="vege" for="vege" style="font-size:3vw">Végétarien : </label>

                        <div class="radioBtn">
                            <input type="radio" id="VegeNon" name="vege" value="0" <?php if (isset($vege_pref) && $vege_pref == 0)
                                echo "checked"; ?>>
                            <label>NON</label>
                            <input type="radio" id="VegeSansPreference" name="vege" value="1" <?php if (!isset($vege_pref) || $vege_pref == 1)
                                echo "checked"; ?> style="margin-left: 5vw">
                            <label>Sans préférence</label>
                            <input type="radio" id="vegeOui" name="vege" value="2" <?php if (isset($vege_pref) && $vege_pref == 2)
                                echo "checked"; ?> style="margin-left: 5vw">
                            <label>OUI</label>
                        </div>

                    </div>

                    <div class="prix">
                        <label for="prix" style="font-size:3vw">Budget (euros): </label>
                        <input type="text" id="zone_prix" value="<?php if (isset($budgtPref))
                            echo $budgtPref; ?>">
                        <div id="prixError" class="error-message">Veuillez entrer un nombre entier</div>
                    </div>

                    <div class="temps">
                        <label for="temps" style="font-size:3vw">Temps (minute): </label>
                        <input type="text" id="zone_temps" name="zone_temps" value="<?php if (isset($tempsCuisine))
                            echo $tempsCuisine; ?>">
                        <div id="tempsError" class="error-message">Veuillez entrer un nombre entier</div>
                    </div>


                </form>
            </div>
            <button class="modal-btn modal-trigger3" id="preferenceBtn" type="button">Réinitialiser vos
                préférences</button>
        </div>
        <div class="boutons_form">

            <button class="btnRetour" onclick="window.history.back()">Retour</button>

            <div>
                <button class="modal-btn modal-trigger" id="annulerBtn" type="button">Annuler</button>
                <button class="modal-btn modal-trigger2" id="validerBtn" type="button">Valider</button>
            </div>
        </div>
    </form>

    <div class="modal-annuler">
        <div class="overlay modal-trigger"></div>
        <div class="modal">
            <button class="close-modal modal-trigger">X</button>
            <div class="modal-title">
                <h1>Êtes-vous sûr de vouloir annuler ?</h1>
            </div>
            <div class="modal-text">
                <p>Vous vous apprêtez à annuler toutes vos modifications, et vous serez redirigé vers la page
                    d'accueil.</p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir annuler ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger">Retour</button>
                <button class="btn-annuler-modal" onclick="window.location.href='index.html'">Annuler</button>
            </div>

        </div>
    </div>

    <div class="modal-préférence">
        <div class="overlay modal-trigger3"></div>
        <div class="modalPref">
            <button class="close-modal modal-trigger3">X</button>
            <div class="modal-title">
                <h1>Êtes-vous sûr de vouloir Réinitialiser vos préférences ?</h1>
            </div>
            <div class="modal-text">
                <p>Vous vous apprêtez à réinitialiser toutes vos préférences par défault, c'est-à-dire à "Sans
                    préférence".</p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir réinitialiser ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger3">Retour</button>
                <button class="btn-reinitialiser-modal" onclick="reinitialiserPref()">Réinitialiser</button>
            </div>

        </div>
    </div>


    <div class="modal-valider">
        <div class="overlay modal-trigger2"></div>
        <div class="modal">
            <button class="close-modal modal-trigger2">X</button>
            <div class="modal-title">
                <h1> Etes-vous prêt à voir votre sélection ?</h1>
            </div>
            <div class="modal-text">
                <p style="margin-right: 40px;">Vous vous appretez à valider votre formulaire et vous allez être redirigé
                    vers la page contenant
                    notre
                    sélection de recettes.
                </p>
                <p style="margin-top: 50px;">Etes vous sûr de vouloir continuer ?</p>
            </div>
            <div class="modal-buttons">
                <button class="btn-retour-modal modal-trigger2">Retour</button>
                <a href="#" class="btn-annuler-modal" onclick="submitForm()">Continuer</a>
            </div>

        </div>
    </div>

    <footer class="footer" id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="region region-footer1">
                        <section id="block-block-1" class="block block-block clearfix">
                            <p>@&nbsp;Equipe Edu'Cook<br />
                                Tous droits réservés<br />
                                <a class="lien" href="../newsletter/politique_confidentialite.html">Politique de
                                    confidentialité</a>
                            </p>
                        </section>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 news">
                    <div class="region region-footer2">
                        <section id="block-block-2" class="block block-block clearfix">
                            <p>Notre Newsletter : </p>
                            <a class="btn_footer" href="../newsletter/newsletter.html">Accès au Newsletter</a>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="../commun/commun.js"></script>

    <script>
        function reinitialiserPref() {
            var boutonsViandes = document.querySelectorAll('input[type="radio"]');

            boutonsViandes.forEach(function (bouton) {
                if (bouton.id.endsWith('sansPreference')) {
                    bouton.checked = true;
                } else {
                    bouton.checked = false;
                }
            });

            modalContainer3.classList.toggle("active")
        }

        const modalContainer = document.querySelector(".modal-annuler");
        const modalContainer2 = document.querySelector(".modal-valider");
        const modalContainer3 = document.querySelector(".modal-préférence");
        const modalTriggers = document.querySelectorAll(".modal-trigger");
        const modalTriggers2 = document.querySelectorAll(".modal-trigger2");
        const modalTriggers3 = document.querySelectorAll(".modal-trigger3");

        modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal))
        modalTriggers2.forEach(trigger => trigger.addEventListener("click", toggleModal2))
        modalTriggers3.forEach(trigger => trigger.addEventListener("click", toggleModal3))

        function toggleModal() {
            modalContainer.classList.toggle("active")
        }

        function toggleModal2() {
            modalContainer2.classList.toggle("active")
        }

        function toggleModal3() {
            modalContainer3.classList.toggle("active")
        }


        function validateForm() {
            var prixInput = document.getElementById("zone_prix");
            var tempsInput = document.getElementById("zone_temps");
            var prixError = document.getElementById("prixError");
            var tempsError = document.getElementById("tempsError");
            var valid = true;

            // Vérification du prix
            if (!/^\d+$/.test(prixInput.value)) {
                document.getElementById('prixError').style.display = 'block';
            } else {
                document.getElementById('prixError').style.display = 'none';
            }

            // Vérification du temps
            if (!/^\d+$/.test(tempsInput.value)) {
                document.getElementById('tempsError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('tempsError').style.display = 'none';
            }

            return valid;
        }

        function submitForm() {
            if (validateForm()) {
                // Le formulaire est valide, soumettre
                var form = document.getElementById("example");
                form.submit();
            } else {
                modalContainer2.classList.toggle("active");
            }
        }

    </script>
</body>

</html>