<?php
require_once "lib/functions.php";
if (!isLogged()) {
    header("Location:index.php");
    exit;
}

$userInfo = getUserByLogin($_SESSION['usernameLog']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        fieldset {
            width: 98.5%;
            margin: auto;
        }
    </style>
</head>
<body>
<?php
if ($_SESSION['postOk']) {
    echo "<h1>Votre post a bient été publié et figure ci-dessous!</h1>";

} else {
    echo "Le post n'a pas pu être inséré!";
}

?>
<h1>Bonjour <?php echo $userInfo['surname'] . " " . $userInfo['name'] ?>, voici votre fil d'actualités!</h1>
<fieldset>
    <legend>Nouveau post</legend>
    <form action="" method="post">
        <label for="titleInput">Title:</label><br>
        <input id="titleInput" type="text" name="titlePost"><br>
        <label for="descriptionInput">Description:</label><br>
        <textarea id="descriptionInput" rows="40" cols="200" name="descriptionPost"></textarea><br>
        <input id="postInput" type="submit" name="post"><br>
    </form>
</fieldset>
<a href="logout.php">Déconnection</a>

</body>
</html>
