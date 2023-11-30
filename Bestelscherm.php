
<?php
include "database.php";
$databaseConnection = connectToDatabase();
?>

<!DOCTYPE html>
<html lang="nl">
<style>
    .head {display: inline-flex; style=border-bottom: 1px green}
</style>
<style>
    .naam {width: 33%; margin-right: 10px }
    </style>
<style>
    .gegevens {background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite}
</style>
<head class="head">
    <meta charset="UTF-8">
    <title>Bestelscherm</title>
    <a href="index.php"><img src="Images/nerdygadgets.png" alt="logo" width="250" height="140"></a>
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
<form method="POST" action="verwerk.php" style="200px; margin-left: 200px;display: inline-block">
    <p style="display: inline-flex; background-color: rgb(35, 35, 47) ;">
    <input type="text" name="voornaam" value="" placeholder="Voornaam" class="naam" style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite"> <br>
    <br><input type="text" name="tussenvoegsel" value="" placeholder="Tussenvoegsel" style="width: 25%; margin-right: 10px ;background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite">
    <br><input type="text" name="achternaam" value="" placeholder="Achternaam" class="naam" style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite" >
    </p><br>
    <p2 >
    <input type="text" name="land" value="" placeholder="Land" class="gegevens"><br>
    <input type="text" name="postcode" value="" placeholder="Postcode" class="gegevens"><br>
    <input type="text" name="huisnummer" value="" placeholder="Huisnummer" class="gegevens"><br>
    <input type="text" name="straatnaam" value="" placeholder="Straatnaam" class="gegevens"><br>
    <input type="text" name="woonplaats" value=""placeholder="Plaats" class="gegevens"><br>
    <input type="text" name="telefoonnummer" placeholder="Emailadress" value="" class="gegevens"><br>
    <br><input type="submit" value="Verzenden"  style="background-color: #676EFF; border-radius: 8px; font-family: vortice-concept, sans-serif; font-weight: bold; color: antiquewhite">
    </p2>
</form>



</body>
</html>
