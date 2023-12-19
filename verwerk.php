<?php
include "header.php";
include "cartfuncties.php";
include "verwerkfuncties.php";

$databaseConnection = connectToDatabase();

?>


<html>
<lang nl></lang>
 <body>
 <h1> <?php if(!empty($_SESSION['voornaam'])) {echo ($_SESSION['voornaam']); } ?>, u kunt nu uw bestelling afronden</h1>
 <div id="bestelldiv" class="center">
     <div id="bestellen">
         <p>Controleer uw besteladres.</p>

         <div id="anderadres" class="border">
             <div id="afleveradres">
                 <p>Afleveradres: <br>Naam: <?php if(!empty($_SESSION['voornaam'])) {echo ($_SESSION['voornaam']); } ?> <br> Adres: <?php if(!empty($_SESSION['straatnaam']) ){echo ($_SESSION['straatnaam']);}   ?> <br>
                     Postcode: <?php if(!empty($_SESSION['postcode'])) {echo ($_SESSION['postcode']); } ?> <br> Woonplaats: <?php if(!empty($_SESSION['plaats']) ){echo ($_SESSION['plaats']);}   ?></p>
             </div>
         </div>
         <br>
         <h4 class="fa fa-bank"> IDeal betalen:</h4>
         <br>
         <div id="banken">
             <form action="order.php" method="post">
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




     <div id="afrekenen" class="CartOverview">
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
 </body>
</html>
