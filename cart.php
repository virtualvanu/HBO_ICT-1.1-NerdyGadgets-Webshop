<?php
include "cartfuncties.php";
include __DIR__ . "/header.php";
$dbConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <script src='Popup.js'></script>
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">-->
    <link rel="stylesheet" type="text/css" href="custom.css">
</head>
<body >

<h1 style="margin-left: 45px;">Inhoud Winkelwagen</h1>
<table class="CartTable" style="width: 60%;">
    <tr>
        <th>Afbeelding</th>
        <th>Product</th>
        <th>Stukprijs</th>
        <th>Subtotaal</th>
        <th>Aantal</th>
    </tr>

    <script>
function checkInput() {
    if (modifiedAmount < 0) {
        $("#myform").submit();
        return false;
    }
}
</script>

    <?php

    $cart = getCart();

//    $popUpConfirm = 1;
    if(isset($_POST['confirmRemove']))
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
            $stockItem = getStockItem($item, $dbConnection);
            $itemQuantity = $stockItem['QuantityOnHand'];
            $quantityInt = preg_replace('/[^0-9]/', '', $itemQuantity);

            if($newAmount <= $quantityInt)
            {
                $cart[$item] = $newAmount;
            }
            else
            {
                $cart[$item] = $quantityInt;
                //print("Helaas is het gekozen aantal momenteel niet in voorraad, kies een lager aantal of probeer het later opnieuw.");
            }

            saveCart($cart);
            $cart = getCart();
        }
    }
    $i = 0;
    $outOfStockRemovals = array();
    foreach($cart as $itemId => $itemAmount) //Double check if cart items are still in stock, remove them from the cart if not.
    {
        $itemInfo = getStockItem($itemId, $dbConnection);
        $dbQuantity = $itemInfo['QuantityOnHand'];
        $dbQuantity = preg_replace('/[^0-9]/', '', $dbQuantity);

        if($dbQuantity <= 0 || $dbQuantity < $itemAmount)
        {
            $outOfStockRemovals[$i] = $itemId;
            $i++;
        }
    }
    if(count($outOfStockRemovals) > 0)
    {
        $_SESSION['OutOfStockRemoval'] = true;
        foreach ($outOfStockRemovals as $key => $removedProduct)
        {
            removeProductFromCart($removedProduct);
        }
        $outOfStockRemovals = array();
        $cart = getCart();
    }
    else
    {
        $_SESSION['OutOfStockRemoval'] = false;
    }

    foreach($cart as $itemId => $itemAmount) //Populate the cart with added products
    {


        $images = getStockItemImage($itemId, $dbConnection);
        $firstImagePath = $images[0]['ImagePath'];
        $itemPrice = 9999;
        $itemName = "UNDEFINED";
        $itemInfo = getStockItem($itemId, $dbConnection);
        $itemName = $itemInfo["StockItemName"];
        $itemPrice = round($itemInfo["SellPrice"], 2);
        $totalItemPrice = $itemPrice * $itemAmount;

        $displayItemPrice = number_format($itemPrice, 2, '.', '.');
        $displayPrice = number_format($totalItemPrice, 2, '.', '.');
        $displayCartTotalPrice = number_format(getCartTotal($dbConnection), 2, '.', '.');

        $htmlstring = "
      <tr>
      <th>  
            <img src='Public/StockItemIMG/$firstImagePath'  class='CartImageStyle' style='display: inline-block;'>
      </th>
        <th style='width: 50%;'>
            <a href='view.php?id=$itemId' style=' margin-left: 10px; font-size: 22px;'>$itemName</a>
        </th>
        <th style='font-size: x-large;'>€$displayItemPrice</th>
        <th style='font-size: x-large;'>€$displayPrice</th>
        
        <th> 
            <form method='post' action='cart.php' name='modifyform' id='MODIFY'>
                <input type='number' value='$itemAmount' min='1' onchange='checkInput()' name='modifiedAmount' required style='width: 110px;'>
                <input type='hidden' name='modifiedproduct' value='$itemId'>
            </form>
        </th>
        
         <th>
            <form method='post' action='cart.php' id='form$itemId' style=display: inline-flex; position: relative;'>
                <input type='hidden' name='product' value='$itemId'>
                </form>   
         <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal$itemId' onclick='openConfirm()'>
                  X
                </button>
                
                <script type='text/javascript'>
    function openConfirm() {
        $('exampleModal$itemId').modal('toggle');
        $('form$itemId').submit();
            }
                </script>
             <div class='modal fade' id='exampleModal$itemId' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Wilt u dit product echt verwijderen uit uw winkelmand?</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <button type='button' class='NietVerwijderen' data-dismiss='modal'>Niet verwijderen</button>
                <form method='post' action='cart.php'>
                <input type='hidden' name='product' value='$itemId'>
                <input type='submit' name='confirmRemove' id='confirm' value='Verwijderen' onclick=''>
                </form>
            </div>
        </div>
    </div>
</div> 
                       
            
         </th>
        </tr>";

        print($htmlstring);
    }

    print("</table>");
    ?>

</table>
<h1 class="CartOverviewHeader">Overzicht</h1>
<br>
<div id="afrekenen" class="CartOverview">
        <?php
        if(isset($_SESSION['OutOfStockRemoval']))
        {
            if($_SESSION['OutOfStockRemoval'] == 1)
            {
                print("<p id='ERRORANNOUNCE'>1 of meerdere producten zijn uit uw winkelmand verwijderd i.v.m. een verandering in voorraad, excuses voor het ongemak.</p>");
            }
        }
        ?>
    <p style="font-size: x-large; margin: 0">Artikelen: <?php
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
        $verzendkosten = 0;
        $cartTotal = getCartTotal($dbConnection);

        if (is_numeric($cartTotal) && $cartTotal < 100 && $cartTotal != 0) {
            $verzendkosten = 6.3;
            print("€".number_format($verzendkosten, 2, '.', '.'));
        } else {
            print("€0.00");
        }
        ?>
    </p>
    <p style="text-align: center; font-size: x-large; margin: 0">----------------------------------------</p>
    <p style="font-size: x-large; margin: 0">Totaal: <?php
        if(count($cart) > 0)
        {
            $cartTotal = getCartTotal($dbConnection);
            $orderTotal = $cartTotal + $verzendkosten;
            $displayOrderTotal = number_format($orderTotal, 2, '.', '.');
            print("€". ($displayOrderTotal));
        }
        else
        {
            print("€0.00");
        }
        ?>

    </p>
<br>
    <a href="http://localhost/nerdygadgets/Bestelscherm.php">
    <?php
        
        if(count(getCart()) <= 0){
            print ('<button class="CartOrderButtonDisabled" disabled>BESTELLEN</button>');
        }else{
            print ('<button class="CartOrderButton">BESTELLEN</button>');
        }

        ?>
    </a>
</div>
</body>
</html>