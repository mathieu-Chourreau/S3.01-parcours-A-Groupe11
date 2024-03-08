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
</head>

<body>

        <div class="container">
            <main id="main" class="container-main">
                <div id="content" class="d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <section id="loginForm" class="login-section login-form card-body">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" id="fm1" action="connexion_inserer_bd.php">
                                        <img src="image/logo.PNG" width="100%" height="100%">
                                            <?php
                                                if(isset($_GET['message'])) {
                                                    $errorMessage = urldecode($_GET['message']);
                                                    echo '<div class="mauvais_identifiant_mdp">' . $errorMessage . '</div>';
                                                }
                                                ?>
                                            <section class="form-group">
                                                <label for="username">Identifiant:
                                                </label>
                                                    <div>
                                                        <input class="form-control"
                                                            id="username"
                                                            size="25"
                                                            tabindex="1"
                                                            type="text"
                                                            required="required"
                                                            autocomplete="off" name="username" value="<?php echo isset($_SESSION['login_username_deco']) ? htmlspecialchars($_SESSION['login_username_deco'], ENT_QUOTES, 'UTF-8') : ''; ?>"/></div>
                                            </section>
                                            <section class="form-group">
                                                <label for="mail">Mail:
                                                </label>
                                                    <div>
                                                        <input class="form-control"
                                                            id="mails"
                                                            size="25"
                                                            tabindex="2"
                                                            type="text"
                                                            required="required"
                                                            autocomplete="off" name="mail" value="<?php echo isset($_SESSION['login_mail']) ? htmlspecialchars($_SESSION['login_mail'], ENT_QUOTES, 'UTF-8') : ''; ?>"/></div>
                                            </section>

                                            <section class="form-group">
                                                <label for="password">Mot de passe:</label>
                                                    <div>
                                                        <input class="form-control"
                                                        type="password"
                                                        id="password"
                                                        size="25"
                                                        tabindex="3"
                                                        required="required"
                                                        autocomplete="off" name="password" value=""/>
                                                    </div>
                                            </section>
                                            <section class="form-group">
                                                <label for="password">Confirmation mot de passe:</label>
                                                    <div>
                                                        <input class="form-control"
                                                        type="password"
                                                        id="passwordVerif"
                                                        size="25"
                                                        tabindex="4"
                                                        required="required"
                                                        autocomplete="off" name="passwordVerif" value=""/>
                                                    </div>
                                            </section>

                                            <input class ="creeCompte"
                                                name="submit"
                                                accesskey="l"
                                                tabindex="6"
                                                type="submit"
                                                value="Creer un compte"/>
                                    </form>
                                <div>
			                        <span class ="creer_compte"><a href="connexion.php">Déjà un compte</a></span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
</body>
<?php
    unset($_SESSION['login_username_deco']);
    unset($_SESSION['login_mail']);
?>
</html>
