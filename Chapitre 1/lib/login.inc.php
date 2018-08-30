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
    $_SESSION['users'] = array(
        array("francisco", "oliveira", "frankyoliveira", "bjr"),
        array("daniel", "fonseca", "danielfonseca", "bjr"),
    );

}


if (filter_has_var(INPUT_POST, 'login')) {
    $username = filter_input(INPUT_POST, 'idLogin', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdLogin', FILTER_SANITIZE_STRING);

    $userOk = false;

    if (usernameVerify($username)) {
        function passwordVerify($username, $pwd)
        {

        }

    } else {

    }
}
function usernameVerify($username)
{
    $userOk = false;
    foreach ($_SESSION['users'] as $array) {
        if (in_array($username, $array)) {
            $userOk = true;
        }
    }
    return $userOk;

}

function passwordVerify($username, $pwd)
{

}