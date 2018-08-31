<?php
require_once "lib/functions.php";
if (isLogged()) {
    header("Location:private.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chapitre 1 Index</title>
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
            <legend style="text-align: center;">Connection</legend>

            <label for="idInput">Identifiant:</label><br>
            <input id="idInput" type="text" name="idLogin"
                <?php
                if ($_SESSION['username'] != "") {
                    echo 'value="' . $_SESSION['username'] . '"';
                } ?>><br>
            <label for="pwdInput">Mot de passe:</label><br>
            <input id="pwdInput" type="password" name="pwdLogin"><br>
            <input id="submitInput" type="submit" name="login" value="Valider"><br>

        </fieldset>
    </form>
    <a href="register.php">Pas encore inscrit?</a>
</main>
</body>
</html>
