<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="connexion.css">
    <title>Page de connexion</title>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const erreur = urlParams.get('erreur');

            if (erreur) {
                const mauvaisIdentifiantMdp = document.querySelector('.mauvais_identifiant_mdp');
                mauvaisIdentifiantMdp.style.display = 'block';
            }
        };
    </script>

</head>

<body>

        <div class="container">
            <main id="main" class="container-main">
                <div id="content" class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <section id="loginForm" class="login-section login-form card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" id="fm1" action="connexion_verif.php">
                                        <img src="image/logo.PNG" width="100%" height="100%">
                                        <div class="mauvais_identifiant_mdp" style="display : none;">
                                                <span>Mauvais identifiant / mot de passe.</span>
                                            </div>
                                            <section class="form-group">
                                                <label for="username">Identifiant:
                                                </label>
                                                    <div>
                                                        <input class="form-control "
                                                            id="username"
                                                            size="25"
                                                            tabindex="1"
                                                            type="text"
                                                            required="required"
                                                            autocomplete="off" name="username" value="<?php echo isset($_SESSION['login_username']) ? htmlspecialchars($_SESSION['login_username'], ENT_QUOTES, 'UTF-8') : ''; ?>"/></div>
                                            </section>

                                            <section class="form-group">
                                                <label for="password">Mot de passe:</label>
                                                    <div>
                                                        <input class="form-control"
                                                        type="password"
                                                        id="password"
                                                        size="25"
                                                        tabindex="2"
                                                        required="required"
                                                        autocomplete="off" name="password" value=""/>
                                                    </div>
                                            </section>

                                            <input class ="seConnecter" 
                                                name="submit"
                                                accesskey="l"
                                                tabindex="6"
                                                type="submit"
                                                value="SE CONNECTER"
                                            />
                                    </form>

                                <div>
			                        <span class ="pwd-forget"><a href="#">Mot de passe oublié.</a></span>
                                </div>
                                <div>
			                        <span class ="creer_compte"><a href="creeCompte.php">Créer votre compte</a></span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
</body>
<?php
    unset($_SESSION['login_username']);
?>
</html>
