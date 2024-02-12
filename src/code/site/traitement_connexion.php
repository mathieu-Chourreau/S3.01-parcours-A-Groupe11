<?php
if(isset($_POST['email'])&& !empty(trim($_POST["email"])) && isset($_POST['password']) && !empty(trim($_POST["password"])))
{
    $user_email= $_POST["email"];
    $user_password= $_POST["password"];

}
else
{
    header('location: connexion.php?err=error');
}
?>