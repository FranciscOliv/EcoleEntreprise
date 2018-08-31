<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//INITIALISATION DES VARIBLES EN SESSION
if (!isset($_SESSION['logged'])) {

    //Session vide -> créer tous les champs
    $_SESSION['logged'] = FALSE;
    $_SESSION['username'] = "";
    $_SESSION['index'] = 0;
    $_SESSION['users'] = array();
}
//INITIALISATION DES VARIBLES EN LOCALES
$loginErrors = array();
$registerErrors = array();

if (filter_has_var(INPUT_POST, 'login')) {
    $username = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdLogin', FILTER_SANITIZE_STRING);

    if (empty($username)) {
        $loginErrors['username'] = "Veuillez tapez votre username";
    }
    if (empty($pwd)) {
        $loginErrors['password'] = "Veuillez tapez votre password";
    }
    $userOk = false;

    if (usernameVerify($username)) {
        $_SESSION['username'] = $username;


        if (passwordVerify($username, $pwd)) {

            $_SESSION['logged'] = TRUE;
            header("Location:private.php");
            exit;

        } else {
            $loginErrors['password'] = "Le mot de passe ne correspond pas.";
        }

    } else {
        $loginErrors['username'] = "Votre identifiant n'existe pas. Inscrivez vous!";
    }
}

function usernameVerify($usernameVerify)
{
    $db = dbConnect();

    $usernameRequest = $db->prepare("SELECT login  FROM user WHERE login=:username");
    $usernameRequest->execute(array(":username" => $usernameVerify));


    return $usernameRequest->rowCount() == 1;

}


function passwordVerify($usernameVerify, $pwdVerify)
{
    $db = dbConnect();

    $password_ok = false;

    $pwdRequest = $db->prepare('SELECT password FROM user WHERE login=?');

    $pwdRequest->execute(array($usernameVerify));
    $pwdRequestResult = $pwdRequest->fetch();

    if ($pwdVerify==$pwdRequestResult['password']) {
        $password_ok = true;
    }

    return $password_ok;
}

function isLogged()
{
    if (array_key_exists('logged', $_SESSION)) {
        return $_SESSION['logged'];
    } else {
        return FALSE;
    }
}

function dbConnect()
{
    $servername = "127.0.0.1";
    $username = "root";


    $db = new PDO("mysql:host=$servername;dbname=forumdb", $username);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_PERSISTENT, true);

    return $db;
}
