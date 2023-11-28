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
        <th>Afbeelding</th>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
        </tr>

    <head>
        <meta charset="UTF-8">
        <title>Winkelwagen</title>
        <style>
            .CartImageStyle {
                width: 75px;
                height: 75px;
                margin-left: 10px;
                border-radius: 8px;
            }
        </style>
    </head>

    <?php

    $cart = getCart();

    if(isset($_POST['removeform']))
    {
        $removeID = $_POST['product'];
        removeProductFromCart($removeID);
        $cart = getCart();
    }

    if(isset($_POST['modifiedAmount']))
    {
        $newAmount = $_POST['modifiedAmount'];
        $item = $_POST['modifiedproduct'];

        if($newAmount <= 0)
        {
            removeProductFromCart($item);
            $cart = getCart();

        }
        else
        {
            $cart[$item] = $newAmount;
            saveCart($cart);
            $cart = getCart();
        }


    }

    $cartTotal = 0;


    foreach($cart as $itemId => $itemAmount)
    {


        $images = getStockItemImage($itemId, $dbConnection);
        $firstImagePath = $images[0]['ImagePath'];
        $itemPrice = 9999;
        $itemName = "UNDEFINED";
        $itemInfo = getStockItem($itemId, $dbConnection);
        $itemName = $itemInfo["StockItemName"];
        $itemPrice = round($itemInfo["SellPrice"], 2);
        $totalItemPrice = $itemPrice * $itemAmount;
        $cartTotal += $totalItemPrice;

        $htmlstring = "
      <tr>
      <th>
            <img src='Public/StockItemIMG/$firstImagePath'  class='CartImageStyle' style='display: inline-block;'>
      </th>
        <th>
            <a href='view.php?id=$itemId' style=' margin-left: 10px'>$itemName</a>
        </th>
        <th>$totalItemPrice</th>
        
        <th> 
            <form method='post' action='cart.php' name='modifyform' id='MODIFY'>
                <input type='number' value='$itemAmount' min='0' onchange='this.form.submit()' name='modifiedAmount'>
                <input type='hidden' name='modifiedproduct' value='$itemId'>
            </form>
        </th>
        
         <th>
            <form method='post' action='cart.php' style='display: inline-flex; position: relative;'>
                <input type='hidden' name='product' value='$itemId'>
                <input type='submit' name='removeform' id='REMOVE' value='X'>
            </form>
         </th>
        </tr>";



        print($htmlstring);
    }

    $totalPriceHTML = "
        <tr>
        <th>Totaal: </th>
        <th>$cartTotal</th>
        </tr>
        ";
    print($totalPriceHTML);

    //print_r($cart);
    //gegevens per artikelen in $cart (naam, prijs, etc.) uit database halen
    //totaal prijs berekenen
    //mooi weergeven in html
    //etc.

    ?>

</table>
<div id="afrekenen">
    <a href="http://localhost/nerdygadgets/Bestelscherm.php">
<button style="background-color:#676EFF; border-radius: 8px; color: white; padding: 10px 20px; font-family: vortice-concept, sans-serif; font-weight: bold; position:relative; left:1300px; top:2px">BESTELLEN</button>
</a>
</div>
</body>
</html>