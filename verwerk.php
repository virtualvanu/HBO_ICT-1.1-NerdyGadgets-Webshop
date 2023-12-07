<?php
include "header.php";
include "cartfuncties.php";

    $databaseConnection = connectToDatabase();
    $voornaam = "Jelmer";
    $tussenVoegsel = (empty($_POST["tussenvoegsel"])) ? " " : $_POST["tussenvoegsel"];
    $achternaam = "Kanis";
    $postcode = "7463PK";
    $email = "12345@info.nl";
    $huis_nummer = "4";
    $straat_naam = "Twijnspil";
    $woonplaats = "Wierden";
    $land = "Nederland";
    $klant_naam = $voornaam . " ". $tussenVoegsel . $achternaam;
    $hetadres = $straat_naam . " " . $huis_nummer;

    emptyCart(); //TEMPORARY Delete the contents of your cart when this page is loaded. TODO: Implement this to happen after payment.

?>


<html>
<lang nl></lang>
 <body>
 <h1> <?php print($klant_naam) ?>, u kunt nu uw bestelling afronden</h1>
 <div id="bestelldiv" class="center">
     <div id="bestellen">
         <p>Controleer uw besteladres.</p>

         <div id="anderadres" class="border">
             <div id="afleveradres">
                 <p>Afleveradres: <br>Naam: <?php print $klant_naam ?> <br> Adres: <?php print $hetadres ?> <br>
                     Postcode: <?php print $postcode ?> <br> Woonplaats: <?php print $woonplaats ?></p>
             </div>
         </div>
         <br>
         <h4 class="fa fa-bank"> IDeal betalen:</h4>
         <br>
         <div id="banken">
             <form action="#" method="post">
                 <select name="banken" id="banken">
                     <option value="ing">ING</option>
                     <option value="rabobank">Rabobank</option>
                     <option value="sns">SNS</option>
                     <option value="abnamro">ABN AMRO</option>
                     <option value="bunq">bunq</option>
                     <option value="knab">Knab</option>
                     <option value="asnbank">ASN Bank</option>
                     <option value="regiobank">RegioBank</option>
                     <option value="revolut">Revolut</option>
                     <option value="triodosbank">Triodos Bank</option>
                     <option value="vanlanschot">Van Lanschot</option>
                 </select>


         </div>
         <br><br>
     </div>
<!-- <h1 class="CartOverviewHeader">Overzicht</h1>-->
 <br>
 <div id="TotaalPrijsVerwerk" class="CartOverview">
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
