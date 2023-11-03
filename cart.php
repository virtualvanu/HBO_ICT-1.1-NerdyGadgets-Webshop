<?php
include "cartfuncties.php";
include "database.php";
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
        $itemInfo = getStockItem($itemId, connectToDatabase());

        $itemName = $itemInfo["StockItemName"];
        $itemPrice = round($itemInfo["SellPrice"], 2);

        $htmlstring = "<tr>
        <th>$itemName</th>
        <th>$itemPrice</th>
        <th>$itemAmount</th>
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

<p><a href='view.php?id=0'>Naar artikelpagina van artikel 0</a></p>
</body>
</html>