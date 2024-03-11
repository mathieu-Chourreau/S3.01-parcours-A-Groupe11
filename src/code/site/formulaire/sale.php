<?php
/**
 * @file    sale.php
 * @author  Mathieu
 * @brief   La page Sale permet à l'utilisateur de saisir son prix, son temps et si il veut du salé
 * @version 0.1
 * @date    17/01/2024
 */
session_start();

if (!isset($_SESSION['ingredientsPreferences'])) {
    $_SESSION['ingredientsPreferences'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $nomIngredient => $valeur) {
        $_SESSION['ingredientsPreferences'][$nomIngredient] = $valeur;
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <title>Edu'Cook</title>
    <link rel="stylesheet" href="sale.css">
</head>

<body>


    <div class="background"></div>

    <nav id="nav">
        <div id="divun">
            <a href="index.html"><img class="img_logo" src="image/logo.png"></a>
            <div class="hame">
                <label class="burger" id="burger" for="burger">
                    <input type="checkbox" id="burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="divdeux">
            <ul id="menu">
                <li><a href="#" class="link">Accueil</a></li>
                <li><a href="#" class="link active">Rechercher</a></li>
                <li><a href="#" class="link">Formulaire</a></li>
                <li><a href="#" class="link">L'équipe</a></li>
                <li><a href="#" class="link">Proposer votre recette</a></li>
                <li><a href="#" class="link">Se connecter</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn">Se connecter</button>
        </div>
    </nav>

    <form id="example" method="POST" class="table table-striped" action="affichage_recette.php">
        <div class="container">
            <div id="categorie">
                <img class="etoile" src="image/pngegg.png">
                <div class="nom_categorie">Informations complémentaires</div>
                <img class="etoile" src="image/pngegg.png">
            </div>

            <div class="formulaire">
                <form action="affichage_recette.php" method="post">

                    <div class="vege">
                        <label class="vege" for="vege" style="font-size:3vw">Végétarien : </label>

                        <div class="radioBtn">
                            <input type="radio" id="VegeNon" name="vege" value="0">
                            <label>NON</label>
                            <input type="radio" id="VegeSansPreference" name="vege" value="1" checked
                                style="margin-left: 5vw">
                            <label>Sans préférence</label>
                            <input type="radio" id="vegeOui" name="vege" value="2" style="margin-left: 5vw">
                            <label>OUI</label>
                        </div>

                    </div>

                    <div class="prix">
                        <label for="prix" style="font-size:3vw">Budget (euros): </label>
                        <input type="text" id="zone_prix" name="zone_prix" required>
                        <div id="prixError" class="error-message">Veuillez entrer un nombre entier</div>
                    </div>

                    <div class="temps">
                        <label for="temps" style="font-size:3vw">Temps (minute): </label>
                        <input type="text" id="zone_temps" name="zone_temps" required>
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