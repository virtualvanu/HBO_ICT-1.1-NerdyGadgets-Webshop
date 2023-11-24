<?php
include "cartfuncties.php";
include __DIR__ . "/header.php";
$dbConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="nl">
<style>
    /* Style for the pop-up container */
    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* semi-transparent background */
        display: none;
    }

    /* Style for the pop-up content */
    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    /* Style for the close button */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    /* Style for the trigger button */
    .openPopup {
        display: block;
        margin: 20px auto;
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <script src='Popup.js'></script>
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
    $popUpHtml = " <!-- Trigger/Open The Modal -->


<div id='popupContainer' class='popup'>
    <!-- Pop-up content -->
    <div class='popup-content'>
        <span class='close' id='closePopup'>&times;</span>
        <h2>Hello, this is a pop-up!</h2>
        <p>This is some content inside the pop-up.</p>
    </div>
</div>";

//    $popUpConfirm = 1;
    if(isset($_POST['removeform']))
    {
        print($popUpHtml);
//        if($popUpConfirm == TRUE) {
//            $removeID = $_POST['product'];
//            removeProductFromCart($removeID);
//            $cart = getCart();
//        }
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



        $itemPrice = 9999;
        $itemName = "UNDEFINED";
        $itemInfo = getStockItem($itemId, $dbConnection);

        $itemName = $itemInfo["StockItemName"];
        $itemPrice = round($itemInfo["SellPrice"], 2);
        $totalItemPrice = $itemPrice * $itemAmount;
        $cartTotal += $totalItemPrice;

        $htmlstring = "<tr>
        <th>
            <a href='view.php?id=$itemId'>$itemName</a>
        </th>
        <th>$totalItemPrice</th>
        <th> 
            <form method='post' action='cart.php' name='modifyform' id='MODIFY'>
                <input type='number' value='$itemAmount' min='0' onchange='this.form.submit()' name='modifiedAmount'>
                <input type='hidden' name='modifiedproduct' value='$itemId'>
            </form>
        </th>
           
         <th>
            <form method='post' action='cart.php'>
                <input type='hidden' name='product' value='$itemId'>
                <input type='submit' name='removeform' id='REMOVE' value='X' onclick=''>
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

    ?>

</table>
<div id="afrekenen">
    <a href="http://localhost/nerdygadgets/Bestelscherm.php">
<button style="background-color:#676EFF; border-radius: 8px; color: white; padding: 10px 20px; font-family: vortice-concept, sans-serif; font-weight: bold; position:relative; left:1300px; top:2px">BESTELLEN</button>
</a>
</div>
<button id="openPopup" class="openPopup">Open Pop-up</button>

<!-- The pop-up container -->
<div id="popupContainer" class="popup">
    <!-- Pop-up content -->
    <div class="popup-content">
        <span class="close" id="closePopup">&times;</span>
        <h2>Hello, this is a pop-up!</h2>
        <p>This is some content inside the pop-up.</p>
    </div>
</div>

<script src="Popup.js"></script>
</body>
</html>