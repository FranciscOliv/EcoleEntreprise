<?php
require_once "lib/functions.php";
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
