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
        <th>Prijs</th>
        <th>Aantal</th>
    </tr>

    <script>
function checkInput() {
    if (modifiedAmount < 0) {
        $("#myform").submit();
        return false;
    }
}
<table class="CartTable" style="width: 60%;">

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

    $cartTotal = 0;
    $kortingBedrag = 0;


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
        $displayPrice = number_format($totalItemPrice, 2, '.', '.');
        $displayCartTotalPrice = number_format($cartTotal, 2, '.', '.');

        $htmlstring = "
      <tr>
      <th>  
            <img src='Public/StockItemIMG/$firstImagePath'  class='CartImageStyle' style='display: inline-block;'>
      </th>
        <th style='width: 50%;'>
            <a href='view.php?id=$itemId' style=' margin-left: 10px; font-size: xx-large;'>$itemName</a>
        </th>
        <th style='font-size: x-large;'>€$displayPrice</th>
        
        <th> 
            <form method='post' action='cart.php' name='modifyform' id='MODIFY'>
                <input type='number' value='$itemAmount' min='0' onchange='checkInput()' name='modifiedAmount' required style='width: 110px;'>
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
                <input type='submit' name='confirmRemove' id='confirm' value='Verwijderen uit winkelmand' onclick=''>
                </form>
            </div>
        </div>
    </div>
</div> 
                       
            
         </th>
        </tr>";

        print($htmlstring);
    }
    //KORTING WINKELMAND
    if(isset($_POST['applyDiscount'])) {
        $discountCode = $_POST['kortingscode'];

        $discountInfo = getDiscountInfo($discountCode, $dbConnection);

        if ($discountInfo) {
            $ingangsdatum = strtotime($discountInfo['Ingangsdatum']);
            $vervaldatum = strtotime($discountInfo['Vervaldatum']);
            $huidigeDatum = time();


            if ($huidigeDatum >= $ingangsdatum && $huidigeDatum <= $vervaldatum) {
                $kortingPercentage = $discountInfo['Kortingspercentage'];
                $kortingBedrag = ($kortingPercentage / 100) * $cartTotal;
                $cartTotal -= $kortingBedrag;

                $_SESSION['appliedDiscount'] = $discountCode;


            } else {

                echo "<script>alert('De kortingscode is niet meer geldig.');</script>";
            }
        } else {

            echo "<script>alert('De kortingscode bestaat niet.');</script>";
        }
    }

    print("</table>");
    ?>

</table>
<h1 class="CartOverviewHeader">Overzicht</h1>
<br>
<div id="afrekenen" class="CartOverview">
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
    $verzendkosten = 6.30;
        print("€".number_format($verzendkosten, 2));
        ?>




    <form method="post" action="cart.php" style="margin-bottom: 20px;">

        <input type="text" id="kortingscode" name="kortingscode" placeholder="Voer kortingscode in" style="width: 200px;"><br>
        <input type="submit" value="Toepassen" name="applyDiscount" class="CartOrderButton">
    </form>

    <p style="text-align: center; font-size: x-large; margin: 0">Korting:  <?php
        if(isset($_POST['applyDiscount']))
        {

            print("€". number_format($kortingBedrag, 2, '.', ','));
        }
        else
        {
            print("€0.00");
        }
        ?>


    <p style="text-align: center; font-size: x-large; margin: 0">----------------------------------------</p>
    <p style="font-size: x-large; margin: 0">Totaal: <?php
        if(count($cart) > 0)
        {

            print("€". number_format($displayCartTotalPrice + $verzendkosten - $kortingBedrag, 2, '.'));
        }
        else
        {
            print("€0.00");
        }
        ?>
    </p>
<br>
    <a href="http://localhost/nerdygadgets/Bestelscherm.php">
        <button class="CartOrderButton">BESTELLEN</button>
    </a>
</div>
</body>
</html>