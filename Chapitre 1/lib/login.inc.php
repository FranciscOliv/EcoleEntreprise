<?php
require_once "security.inc.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isLogged()) {
    header("Location:private.php");
    exit;
}

// Initialisation de tous les champs de la session lors de la 1ère ouverture
//VARIALES DANS LA SESSION
if (!isset($_SESSION['logged'])) {

    //Session vide -> créer tous les champs
    $_SESSION['logged'] = FALSE;
    $_SESSION['username'] = "";
    $_SESSION['index'] = 0;
    $_SESSION['users'] = array();
}

$error = "";

if (filter_has_var(INPUT_POST, 'login')) {
    $username = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdLogin', FILTER_SANITIZE_STRING);

    $userOk = false;

    if (usernameVerify($username)) {
        $_SESSION['username'] = $username;
        if (passwordVerify($_SESSION['index'], $pwd)) {

            //            $_SESSION['logged'] = TRUE;
//            header("Location:")
        } else {
            $error = "Le mot de passe ne correspond pas.";
        }

    } else {
        $error = "Votre identifiant n'existe pas. Inscrivez vous!";
    }
}

function usernameVerify($username)
{
    $_SESSION['index'] = -1;
    $userOk = false;
    foreach ($_SESSION['users'] as $array) {
        $_SESSION['index']++;
        if ($array[2] == $username) {
            $userOk = true;
            break;
        }
    }
    return $userOk;

}

function passwordVerify($index, $pwd)
{
    $pwdOk = false;
    if ($_SESSION['users'][$index][3] == $pwd) {
        $pwdOk = true;
    }

    return $pwdOk;
}