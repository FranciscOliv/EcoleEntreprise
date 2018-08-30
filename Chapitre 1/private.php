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
</body>
</html>
