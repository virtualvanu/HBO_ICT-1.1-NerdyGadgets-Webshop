<?php
include "cartfuncties.php";
include __DIR__ . "/header.php";
$dbConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
</head>
<body>
<h1>Inhoud Winkelwagen</h1>
<table>
    <tr>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
    </tr>
    <?php
    $cart = getCart();
    foreach($cart as $itemId => $itemAmount)
    {



        $itemPrice = 9999;
        $itemName = "UNDEFINED";
        $itemInfo = getStockItem($itemId, $dbConnection);

        $itemName = $itemInfo["StockItemName"];
        $itemPrice = round($itemInfo["SellPrice"], 2);
        $totalItemPrice = $itemPrice * $itemAmount;
        $htmlstring = "<tr>
        <th><a href='view.php?id=$itemId'>$itemName</a></th>
        <th>$totalItemPrice</th>
        <th> <input type='number' value='$itemAmount' min='0'></th>
         <th>
         <form method='post' action='cart.php'>
        
         <input type='submit' name='modify' id='MODIFY' value='X'>
         </form>
         </th>
        </tr>";
        print($htmlstring);
    }


    //print_r($cart);
    //gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
    //totaal prijs berekenen
    //mooi weergeven in html
    //etc.

    ?>
</table>

<!-- <p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p> -->
</body>
</html>