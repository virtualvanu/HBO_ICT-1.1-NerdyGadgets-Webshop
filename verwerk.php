<?php
include "database.php";

    $database = connectToDatabase();
    $voornaam = $_POST["voornaam"];
    $tussenVoegsel = (empty($_POST["tussenvoegsel"])) ? " " : $_POST["tussenvoegsel"];
    $achternaam = $_POST["achternaam"];
    $postcode = $_POST["postcode"];
    $email = $_POST["emailadress"];
    $huis_nummer = $_POST["huisnummer"];
    $straat_naam = $_POST["straatnaam"];
    $woonplaats = $_POST["woonplaats"];
    $land = $_POST["land"];
    $klant_naam = $voornaam . $tussenVoegsel . $achternaam;
    $hetadres = $straat_naam . " " . $huis_nummer;

if (getCustomerGegevens($database, $email)){

}
else {
    klantToevoegenInDatabase($database, $klant_naam, $email, $hetadres, $postcode, $woonplaats, $land);

}
//    return 'bestelscherm.php';
?>

<html>
   <head>
      <title>HTML Meta Tag</title>
      <meta http-equiv = "refresh" content = 3; url = "http://localhost/nerdygadgets/Bestelscherm.php" />
   </head>