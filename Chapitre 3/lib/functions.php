<?php
/**
 * Auteur: Fonseca de Oliveira, Francisco Daniel
 * Classe: I.DA-P3B
 * Année 2018-2019
 * Projet : Forum
 * Version : 1.0.0
 */
//INITIALISATION DE LA SESSION POUR LA PREMIERE FOIS
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//INITIALISATION DES VARIBLES EN SESSION
if (!isset($_SESSION['logged'])) {

    //Session vide -> créer tous les champs
    $_SESSION['logged'] = FALSE;
    $_SESSION['index'] = 0;
    $_SESSION['users'] = array();

    $_SESSION['usernameLog'] = "";

    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['usernameReg'] = '';

    $_SESSION['postOk'] = FALSE;

}
//INITIALISATION DES VARIBLES EN LOCALES
$loginErrors = array();
$registerErrors = array();
$postErrors = array();

//LOGIN
if (filter_has_var(INPUT_POST, 'login')) {

    $_SESSION['usernameLog'] = "";

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
        $_SESSION['usernameLog'] = $username;


        if (passwordVerify($username, $pwd)) {

            $_SESSION['logged'] = TRUE;
            header("Location:main.php");
            exit;

        } else {
            $loginErrors['password'] = "Le mot de passe est faux.";
        }

    } else {
        $loginErrors['username'] = "Votre identifiant n'existe pas. Inscrivez vous!";
    }
}

//REGISTER
if (filter_has_var(INPUT_POST, 'register')) {

    $_SESSION['firstNameReg'] = '';
    $_SESSION['lastNameReg'] = '';
    $_SESSION['usernameReg'] = '';

    $registerErrorExist = false;


    //Entrees par l'utilisateur
    $firstName = filter_input(INPUT_POST, 'firstNameRegister', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastNameRegister', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'usernameRegister', FILTER_SANITIZE_STRING);
    $pwd = filter_input(INPUT_POST, 'pwdLogin', FILTER_SANITIZE_STRING);
    $pwdValidate = filter_input(INPUT_POST, 'pwdValidateLogin', FILTER_SANITIZE_STRING);


    if (empty($firstName)) {
        $registerErrors['firstName'] = "Le champ prénom est vide ou non valable";
        $registerErrorExist = true;
    } else {
        $_SESSION['firstNameReg'] = $firstName;
    }

    if (empty($lastName)) {
        $registerErrors['lastName'] = "Le champ nom est vide ou non valable";
        $registerErrorExist = true;
    } else {
        $_SESSION['lastNameReg'] = $lastName;
    }

    if (empty($username)) {
        $registerErrors['username'] = "Le champ identifiant est vide ou non valable";
        $registerErrorExist = true;
    } else {
        $_SESSION['usernameReg'] = $username;
    }

    if (empty($pwd) OR empty($pwdValidate) OR $pwd != $pwdValidate) {

        $registerErrors['password'] = "Les mots de passes sont vides ou ne correspondent pas";
        $registerErrorExist = true;
    }

    if (!$registerErrorExist) {
        if (userVerify($username)) {
            addUser($firstName, $lastName, $username, $pwd);
            header("Location:index.php");
            exit;
        } else {
            $_SESSION['registerErrors']['username'] = "Le username existe déjà";
        }
    }
}

//POST
if (filter_has_var(INPUT_POST, 'post')) {

    $_SESSION['titlePost'] = "";
    $_SESSION['descriptionPost'] = "";
    $_SESSION['postOk'] = FALSE;


    $errorPostExit = false;

    $userInfo = getUserByLogin($_SESSION['usernameLog']);

    $title = filter_input(INPUT_POST, 'titlePost', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'descriptionPost', FILTER_SANITIZE_STRING);

    if (empty($title)) {
        $postErrors['title'] = "Le titre est vide ou pas valable";
        $errorPostExit = true;
    }
    if (empty($description)) {
        $postErrors['description'] = "Le titre est vide ou pas valable";
        $errorPostExit = true;
    }

    if (!$errorPostExit) {
        if (insertPost($title, $description, $userInfo['idUser'])) {
            $_SESSION['postOk'] = TRUE;
        }
    }

}

//Login functions
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

    if ($pwdVerify == $pwdRequestResult['password']) {
        $password_ok = true;
    }

    return $password_ok;
}

//Register functions
function userVerify($usernameVerify)
{
    $db = dbConnect();

    $username_ok = false;

    $usernameRequest = $db->prepare("SELECT login  FROM user WHERE login=:username");
    $usernameRequest->execute(array(":username" => $usernameVerify));

    if ($usernameRequest->rowCount() == 0) {
        $username_ok = true;
    }
    return $username_ok;
}

function addUser($firstName, $lastName, $username, $pwd)
{
    $db = dbConnect();

    //Ajout dans la table user
    $userAddRequest = $db->prepare("INSERT INTO user(surname, name, login, password) VALUES (:firstname, :lastname, :username, :pwd)");
    $userAddRequest->execute(array(":firstname" => $firstName, ":lastname" => $lastName, ":username" => $username, ":pwd" => $pwd));
}

/**
 * Renvoie les détails d'un utilisateur
 * @param string login de l'utilisateur
 * @return array {id; surname; name} ou false si non valide
 */
function getUserByLogin($username)
{
    $db = dbConnect();

    $userInfoRequest = $db->prepare('SELECT idUser, surname, name FROM user WHERE login=? ');
    $userInfoRequest->execute(array($username));
    $userInfoRequestResult = $userInfoRequest->fetch();

    return $userInfoRequestResult;

}

/**
 * Enregistre un post en base
 * @return boolean si tout ok ou pas
 */
function insertPost($title, $description, $idUser)
{
    $db = dbConnect();
    $postOk = false;
    try {
        $postAddRequest = $db->prepare("INSERT INTO news(title, description, idUser) VALUES(:title, :description, :idUser)");
        $postAddRequest->execute(array(":title" => $title, ":description" => $description, ":idUser" => $idUser));
        $postOk = true;
    } catch (Exception $e) {
        $postOk = false;
    }
    if(isset($e)){
        echo $e;
    }
    return $postOk;
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
