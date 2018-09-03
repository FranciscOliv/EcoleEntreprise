<?php
/**
 * Auteur: Fonseca de Oliveira, Francisco Daniel
 * Classe: I.DA-P3B
 * Année 2018-2019
 * Projet : Forum
 * Version : 1.0.0
 */
require_once "security.inc.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isLogged()) {
    header("Location:main.php");
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

$errors = array();
$errorExist = false;

if (filter_has_var(INPUT_POST, 'register')) {
    $firstName = filter_input(INPUT_POST, 'firstNameRegister', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastNameRegister', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'usernameRegister', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdLogin', FILTER_SANITIZE_STRING);
    $pwdValidate = filter_input(INPUT_POST, 'pwdValidateLogin', FILTER_SANITIZE_STRING);


    if (empty($firstName)) {
        $errors["firstName"] = "Le champ prénom est vide ou non valable";
        $errorExist = true;
    }
    if (empty($lastName)) {
        $errors["lastName"] = "Le champ nom est vide";
        $errorExist = true;
    }
    if (empty($username)) {
        $errors["username"] = "Le champ identifiant est vide";
        $errorExist = true;
    }
    if (empty($pwd) or $pwd != $pwdValidate) {
        $errors["password"] = "Les mots de passes sont vides ou ne correspondent pas";
        $errorExist = true;
    }
    if (!$errorExist) {
        array_push($_SESSION['users'], array($firstName,  $lastName, $username, $pwd));
        header("Location:index.php");
        exit;
    }


}



