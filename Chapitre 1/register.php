<!--
Auteur: Fonseca de Oliveira, Francisco Daniel
Classe: I.DA-P3B
Année 2018-2019
Projet : Forum
Version : 1.0.0
-->
<?php
require_once "lib/register.inc.php";
if (isLogged()) {
    header("Location:main.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chapitre 1 Inscription</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        main {
            width: 30%;
            height: 500px;
            margin: auto;
            background-color: cornflowerblue;
        }
    </style>
</head>
<body>
<main>
    <form action="" method="post">
        <fieldset>
            <legend style="text-align: center;">Inscription</legend>

            <label for="idInput">Prénom:</label><br>
            <input id="idInput" type="text" name="firstNameRegister"><br>
            <label for="pwdInput">Nom:</label><br>
            <input id="pwdInput" type="text" name="lastNameRegister"><br>
            <label for="idInput">Identifiant:</label><br>
            <input id="idInput" type="text" name="usernameRegister"><br>
            <label for="pwdInput">Mot de passe:</label><br>
            <input id="pwdInput" type="password" name="pwdLogin"><br>
            <label for="pwdInput">Validation du mot de passe:</label><br>
            <input id="pwdInput" type="password" name="pwdValidateLogin"><br>
            <input id="submitInput" type="submit" name="register" value="Valider"><br>
        </fieldset>
        <?php
        if(!empty($errors)){
            foreach ($errors as $value){
                echo "<p>" . $value . "</p>";
            }
        }

        ?>

    </form>
</main>
</body>
</html>
