<?php
require_once "lib/login.inc.php";
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
            <input id="idInput" type="text" name="idRegister"><br>
            <label for="pwdInput">Mot de passe:</label><br>
            <input id="pwdInput" type="text" name="pwdLogin"><br>
            <input id="submitInput" type="submit" name="register" value="Valider"><br>
        </fieldset>

    </form>
</main>
</body>
</html>
