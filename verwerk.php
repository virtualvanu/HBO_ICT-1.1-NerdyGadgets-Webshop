<?php
include "header.php";
include "cartfuncties.php";

    $databaseConnection = connectToDatabase();
    $voornaam = $_POST["voornaam"];
    $tussenVoegsel = (empty($_POST["tussenvoegsel"])) ? " " : $_POST["tussenvoegsel"];
    $achternaam = $_POST["achternaam"];
    $postcode = $_POST["postcode"];
    $email = $_POST["emailadress"];
    $huis_nummer = $_POST["huisnummer"];
    $straat_naam = $_POST["straatnaam"];
    $woonplaats = $_POST["woonplaats"];
    $land = $_POST["land"];
    $klant_naam = $voornaam . " ". $tussenVoegsel . $achternaam;
    $hetadres = $straat_naam . " " . $huis_nummer;
//    $email2 = $_POST["emailadress2"];
//
//if ($email2 == controlerenGegevens($databaseConnection, $email2)){
// getCustomerGegevens($databaseConnection, $email2);
//}
//elseif($email2 !== controlerenGegevens($databaseConnection, $email2)) {
//    Print ('U staat nog niet bij ons geregistreerd als klant');
//}
//else {
//    klantToevoegenInDatabase($databaseConnection, $klant_naam, $email, $hetadres, $postcode, $woonplaats, $land);
//}
klantToevoegenInDatabase($databaseConnection, $klant_naam, $email, $hetadres, $postcode, $woonplaats, $land);
?>


<html>
<lang nl></lang>
 <body>
 <h1> <?php print($klant_naam) ?>, u bestelling is geplaatst</h1>
 <h1 class="CartOverviewHeader">Overzicht</h1>
 <br>
 <div id="afrekenen" class="CartOverview">
     <p style="font-size: x-large; margin: 0">Artikelen: <?php
         $cartTotal = 0;
        $cart = getCart();

         foreach($cart as $itemId => $itemAmount)
         {


         $images = getStockItemImage($itemId, $databaseConnection);
         $firstImagePath = $images[0]['ImagePath'];
         $itemPrice = 9999;
         $itemName = "UNDEFINED";
         $itemInfo = getStockItem($itemId, $databaseConnection);
         $itemName = $itemInfo["StockItemName"];
         $itemPrice = round($itemInfo["SellPrice"], 2);
         $totalItemPrice = $itemPrice * $itemAmount;
         $cartTotal += $totalItemPrice;
         $displayPrice = number_format($totalItemPrice, 2, '.', '.');
         $displayCartTotalPrice = number_format($cartTotal, 2, '.', '.');}
         if(count($cart) > 0)
         {
             print("€$displayCartTotalPrice");
         }
         else
         {
             print("€0.00");
         }
         ?>
     </p>
     <p style="font-size: x-large; margin: 0">Verzendkosten: <?php
         $verzendkosten = 6.30;
         print("€".$verzendkosten);
         ?>
     </p>
     <p style="text-align: center; font-size: x-large; margin: 0">----------------------------------------</p>
     <p style="font-size: x-large; margin: 0">Totaal: <?php
         if(count($cart) > 0)
         {

             print("€". ($displayCartTotalPrice + $verzendkosten));
         }
         else
         {
             print("€0.00");
         }
         ?>
     </p>
     <br>
 </body>
</html>