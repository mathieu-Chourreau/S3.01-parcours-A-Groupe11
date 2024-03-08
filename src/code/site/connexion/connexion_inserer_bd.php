<?php
    session_start();
    include '../bd.php';
    $_SESSION['connecter'] = false;

    $errors = array();
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordVerif']) && isset($_POST['mail'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $passwordverif = trim($_POST['passwordVerif']);
        $mail = trim($_POST['mail']);

        date_default_timezone_set('UTC');
        $dateCreation = date('y-m-d h:i:s');


        // Si l'utilisateur existe déjà
        $conn = connexionBd();
        $sql = "SELECT pseudo FROM utilisateur WHERE pseudo = '$username';";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $errors[] = "Le nom d'utilisateur est déjà existant.";
        }



        // Si l'addresse mail n'est pas correcte
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse e-mail est invalide.";
        }

        // Si le mdp verif est différent du mdp
        if($password != $passwordverif) {
            $errors[] = "Mdp et confirmation de mdp pas identitique.";
        }
        
        

        if(empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO utilisateur VALUES ('', '$username', '$mail', '$hashedPassword', '$dateCreation', '$dateCreation', '')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['connecter'] = true;
                deconnexionBd($conn);
                header("Location: ../index.php");
                exit;
            } else {
                echo "Insertion pas réussie".PHP_EOL;
            }
        } 
        else {
            $_SESSION['login_username_deco'] = $username;
            $_SESSION['login_mail'] = $mail;
            $errorString = implode("<br>", $errors); 
            deconnexionBd($conn);
            header("Location: creeCompte.php?erreur=1&message=" . urlencode($errorString));
            exit;
        }
    }

    
    else {
        header("Location: creeCompte.php");
        exit;
    }
?>