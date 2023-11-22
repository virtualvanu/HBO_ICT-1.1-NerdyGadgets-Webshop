
<?php
include "database.php";
$databaseConnection = connectToDatabase();
?>

<!DOCTYPE html>
<html lang="nl">
<style>
    .head {display: inline-flex}



</style>

<head class="head">
    <meta charset="UTF-8">
    <title>Bestelscherm</title>
    <img src="Images/nerdygadgets.png" alt="logo" width="250" height="140">
    <h1 class="head">
    <b style="font-size: 50px; position: relative;top: 15px; left:300px">Bestelscherm</b>
    </h1>

    <a href="http://localhost/nerdygadgets/cart.php">
            <button style="background-color:#676EFF; border-radius: 8px; color: white; padding: 10px 20px; font-family: vortice-concept, sans-serif; font-weight: bold; position: relative; left: 550px">Terug naar winkelmand</button>
    </a>

    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>
<body style="border-top: 1px solid rgb(36, 41, 143)">



</body>
</html>
