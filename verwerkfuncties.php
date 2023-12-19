<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

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

}



