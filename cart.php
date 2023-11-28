<?php
include "cartfuncties.php";
include __DIR__ . "/header.php";
$dbConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="nl">

<style>
    .inhoud {
        margin auto;
        width: 500px;
        text-align: center;
        background-color: rgb(35, 35, 47);
        border-radius: 8px;
        border:solid antiquewhite;
        color: antiquewhite;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <script src='Popup.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="custom.css">
</head>
<body >

<h1 >Inhoud Winkelwagen</h1>
<table class="inhoud" style="border-radius: 8px">
    <tr>
        <th>Product</th>
        <th>Prijs</th>
        <th>Aantal</th>
    </tr>

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

        $htmlstring = "<table class='inhoud' >

            <tr>
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
         <form method='post' action='cart.php' id='form1'>
                <input type='hidden' name='product' value='$itemId'>
                </form>   
         <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal' onclick='openConfirm()'>
                  X
                </button>
                
                <script type='text/javascript'>
    function openConfirm() {
        $('exampleModal').modal('toggle');
        $('form1').submit();
            }
                </script>
             <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
        </tr>
        </table>";




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



</body>
</html>