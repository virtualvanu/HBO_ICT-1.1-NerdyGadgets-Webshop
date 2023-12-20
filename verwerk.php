<?php
include "header.php";
include "cartfuncties.php";
include "verwerkfuncties.php";

$databaseConnection = connectToDatabase();
?>


<html>
<lang nl></lang>
 <body >
 <h1 style="margin-left: 20px;"> <?php if(!empty($_SESSION['voornaam'])) {echo ($_SESSION['voornaam']); } ?>, u kunt nu uw bestelling afronden</h1>
 <div id="bestelldiv" class="center" style="margin-left: 20px;">
     <div id="bestellen">
         <p>Controleer uw besteladres.</p>

         <div id="anderadres" class="border" style="width: 40%">
             <div id="afleveradres" style="width: 30%">
                 <p>Afleveradres: <br>Naam: <?php if(!empty($_SESSION['voornaam'])) {echo ($_SESSION['voornaam']); } ?> <br> Adres: <?php if(!empty($_SESSION['straatnaam']) ){echo ($_SESSION['straatnaam']);}   ?> <br>
                     Postcode: <?php if(!empty($_SESSION['postcode'])) {echo ($_SESSION['postcode']); } ?> <br> Woonplaats: <?php if(!empty($_SESSION['plaats']) ){echo ($_SESSION['plaats']);}   ?></p>
             </div>
         </div>
         <br>
         <h4 class="fa fa-bank"> IDeal betalen:</h4>
         <br>
         <div >
             <form action="order.php" method="post" id="banken" style="width: 20%">
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
                 <input type="submit" class="CartOrderButton" value="afrekenen">


         </div>



         <br><br>
     </div>
<!-- <h1 class="CartOverviewHeader">Overzicht</h1>-->
 <br>




     <div id="afrekenen" class="TotaalKosten" style="margin-right: 100px">
         <?php

         ?>
         <p style="font-size: x-large; margin: 0">Artikelen: <?php
             print("€".(number_format($_SESSION['Totaalwinkelmand'], 2, ',', '.') ));            ?>

         </p>
         <p style="font-size: x-large; margin: 0">Verzendkosten: <?php
             print("€".(number_format($_SESSION['VerzendKost'], 2, ',', '.')));
             ?>

             <p style="text-align: center; font-size: x-large; margin: 0">Korting:  <?php
                 if (!empty($_SESSION['Korting']) ){
                     print ("€".number_format($_SESSION['Korting'], 2, ',', '.'));
                 }
                 else {
                     print ("€0,00");

                 }
                 ?>

         </p>

         <p style="text-align: center; font-size: x-large; margin: 0">----------------------------------------</p>
         <p style="font-size: x-large; margin: 0">Totaal: <?php
             print ("€".(number_format($_SESSION['OrderTotal'], 2, ',', '.')));
             ?>

         </p>
     </p>
     <br>
     </div>
 </div>
        <div class='VerwerkCartOverview'>
             <table >

              <?php
            $cart = getCart();
            foreach ($cart as $itemId => $itemAmount){
             $images = getStockItemImage($itemId, $databaseConnection);
             $firstImagePath = $images[0]['ImagePath'];
                $itemInfo = getStockItem($itemId, $databaseConnection);
                $itemName = $itemInfo["StockItemName"];

             print "
            
            <tr>
             <img src='Public/StockItemIMG/$firstImagePath'  class='CartImageStyle' style='display: inline-block;width: 100px;
        height: 100px;'>
             </tr>
             <tr style='width: 50%;'>
                <a href='view.php?id=$itemId' style=' margin-left: 10px; font-size: 16px;'>$itemName</a>
            </tr><br><br>
            
            ";
            }
            ?>
            </table>

        </div>



 </body>
</html>
