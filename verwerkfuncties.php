<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

//emptyCart(); //TEMPORARY Delete the contents of your cart when this page is loaded. TODO: Implement this to happen after payment.


//finishOrder($databaseConnection); //TEMPORARY Delete the contents of your cart when this page is loaded. TODO: Implement this to happen after payment.

function CreateOrder($customerID, $dbConnection) //TODO: Acquire OrderID somehow
{
    $orderDate = date("Y/m/d");
    $orderID = null;
    $controlOrderDate = date("Y/m/d H:i:s");
    $Query = "CALL AddOrder($customerID, '$orderDate');";
        $Statement = mysqli_prepare($dbConnection, $Query);
        mysqli_stmt_execute($Statement);

    $Query2 = "SELECT OrderID FROM Orders WHERE CustomerID=$customerID AND LastEditedWhen='$controlOrderDate';";
        $Statement2 = mysqli_prepare($dbConnection, $Query2);
        mysqli_stmt_execute($Statement2);

    $R = mysqli_stmt_get_result($Statement2);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);
    foreach($R as $row)
    {
        $orderID = $row['OrderID']; // I have no idea if this works and 11PM is approaching so I'm just gonna leave it for future me
    }
        return $orderID;
}
function CreateOrderLine($orderID, $itemID, $itemAmount, $dbConnection)
{
    $Query = "CALL AddOrderLine($orderID, $itemID, $itemAmount);";
    $Statement = mysqli_prepare($dbConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
}
function FinishOrder($orderID, $databaseConnection)
{
    $cart = getCart();

    foreach ($cart as $itemId => $itemAmount)
    {
        $StockItem = getStockItem($itemId, $databaseConnection);
        $dbQuantity = $StockItem['QuantityOnHand'];
        if($dbQuantity > 0 && $itemAmount <= $dbQuantity)
        {
            $Query = "CALL RemoveProductQuantity($itemId, $itemAmount);";
            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_execute($Statement);
            $Result = mysqli_stmt_get_result($Statement);

            CreateOrderLine($orderID, $itemId, $itemAmount, $databaseConnection);
        }

    }
    emptyCart();
}

}



