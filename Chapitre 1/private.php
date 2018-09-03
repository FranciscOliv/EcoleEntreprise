<!--
Auteur: Fonseca de Oliveira, Francisco Daniel
Classe: I.DA-P3B
Année 2018-2019
Projet : Forum
Version : 1.0.0
-->
<?php
require_once "lib/security.inc.php";
if(!isLogged()){
    header("Location:index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Private Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Page PRIVÉE</h1>
<a href="logout.php">logout</a>

</body>
</html>
