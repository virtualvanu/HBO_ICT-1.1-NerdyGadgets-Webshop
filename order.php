<?php
include "header.php";
include "cartfuncties.php";
$databaseConnection = connectToDatabase();

//emptyCart(); //TEMPORARY Delete the contents of your cart when this page is loaded. TODO: Implement this to happen after payment.


//finishOrder($databaseConnection); //TEMPORARY Delete the contents of your cart when this page is loaded. TODO: Implement this to happen after payment.
//
//function finishOrder($databaseConnection)
//{
//    $cart = getCart();
//
//    foreach ($cart as $itemId => $itemAmount)
//    {
//        $StockItem = getStockItem($itemId, $databaseConnection);
//        $dbQuantity = $StockItem['QuantityOnHand'];
//        if($dbQuantity > 0 && $itemAmount <= $dbQuantity)
//        {
//            $Query = "CALL RemoveProductQuantity($itemId, $itemAmount);";
//            $Statement = mysqli_prepare($databaseConnection, $Query);
//            mysqli_stmt_execute($Statement);
//            $Result = mysqli_stmt_get_result($Statement);
//        }
//
//    }
//    emptyCart();
//}





emptyCart();
?>

<html>
<head>
<lang nl></lang>
</head>
<body>
<p> U heb afgerekend en uw bestelling is geplaatst</p>
<p2> Uw order id = <?php ?></p2>
<p3> Dankuwel en tot ziens!</p3>


</body>
</html>
