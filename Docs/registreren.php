<?php
include "header.php";
include "cartfuncties.php";


?>

<style>
    .naam {width: 33%; margin-right: 10px }
</style>
<!DOCTYPE html>
<html lang="nl">
<link rel="stylesheet" type="text/css" href="../custom.css">

<form method="POST" action="../verwerk.php" style="200px; margin-left: 200px;display: inline-block; float: left">
    <p style="display: inline-flex; background-color: rgb(35, 35, 47) ;">
    <h2 style="font-size: 20px">Uw gegevens:</h2> <br>
    <input type="text" name="voornaam" value="" placeholder="Voornaam" class="naam" style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite" required>
    <input type="text" name="tussenvoegsel" value="" placeholder="Tussenvoegsel" style="width: 25%; margin-right: 10px ;background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite">
    <input type="text" name="achternaam" value="" placeholder="Achternaam" class="naam" style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite" required>

    </p>
    <p2 >

        <input type="text" name="postcode" value="" placeholder="Postcode" class="gegevens" required><br>
        <input type="text" name="huisnummer" value="" placeholder="Huisnummer" class="gegevens" required><br>
        <input type="text" name="straatnaam" value="" placeholder="Straatnaam" class="gegevens" required><br>
        <input type="text" name="woonplaats" value=""placeholder="Plaats" class="gegevens" required><br>
        <input type="text" name="land" value="" placeholder="Land" class="gegevens" required><br>
        <input type="email" name="emailadress" placeholder="Emailadress" value="" class="gegevens" required><br>
        <input type="password" name="wachtw" placeholder="Wachtwoord" value="" class="gegevens" required><br>
        <input type="password" name="wachtwher" placeholder="Wachtwoord herhalen" value="" class="gegevens" required><br>
        <input type="submit" value="Registreren"  style="background-color: #676EFF; width: 95.5%;border-radius: 8px; font-family: vortice-concept, sans-serif; font-weight: bold; color: antiquewhite">
    </p2>

</form>


<?php
$databaseConnection = connectToDatabase();



//if(isset($_POST['wachtw']) && isset($_POST['wachtwher']))
//{
//    $wachtwoord = $_POST["wachtw"];
//    $wachtwoordHer = $_POST["wachtwher"];
//    if ($wachtwoord == $wachtwoordHer) {
//
//        $DefinitiefWachtwoord = $wachtwoordHer;
//    } else {
//        print"De ingevoerde wachtwoorden zijn niet gelijk";
//
//    }
//
//
//}
if(isset($_POST['submit'])) {

    $voornaam = $_POST["voornaam"];
    $tussenVoegsel = (empty($_POST["tussenvoegsel"])) ? " " : $_POST["tussenvoegsel"] . " ";
    $achternaam = $_POST["achternaam"];
    $postcode = $_POST["postcode"];
    $email = $_POST["emailadress"];
    $huis_nummer = $_POST["huisnummer"];
    $straat_naam = $_POST["straatnaam"];
    $woonplaats = $_POST["woonplaats"];
    $land = $_POST["land"];
    $wachtwoord = $_POST["wachtw"];
    $wachtwoordHer = $_POST["wachtwher"];
    $klant_naam = $voornaam . " " . $tussenVoegsel . $achternaam;
    $hetadres = $straat_naam . " " . $huis_nummer;
    $DefinitiefWachtwoord = $wachtwoordHer;


klantToevoegenInDatabase($databaseConnection, $klant_naam, $email, $DefinitiefWachtwoord, $hetadres, $postcode, $woonplaats, $land);
}
?>