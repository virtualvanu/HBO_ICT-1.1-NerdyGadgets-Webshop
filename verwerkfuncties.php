<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){

function CreateOrder($customerID, $dbConnection)
{
    $orderDate = date("Y/m/d");
    $Query = "CALL AddOrder($customerID, '$orderDate');";
        $Statement = mysqli_prepare($dbConnection, $Query);
        try
        {
            mysqli_stmt_execute($Statement);
        }
        catch (mysqli_sql_exception $e)
        {
            RollBackProcessingError($dbConnection, $e);
        }


}
function CreateOrderLine($orderID, $itemID, $itemAmount, $dbConnection)
{
    $orderDate = date("Y/m/d");
    $Query = "CALL AddOrderLine($orderID, $itemID, $itemAmount, '$orderDate');";
    $Statement = mysqli_prepare($dbConnection, $Query);
    try
    {
        mysqli_stmt_execute($Statement);
    }
    catch (mysqli_sql_exception $e)
    {
        RollBackProcessingError($dbConnection, $e);
    }
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
            try
            {
                mysqli_stmt_execute($Statement);
            }
            catch (mysqli_sql_exception $e)
            {
                RollBackProcessingError($databaseConnection, $e);
            }
            CreateOrderLine($orderID, $itemId, $itemAmount, $databaseConnection);
        }

    }
    emptyCart();

    mysqli_commit($databaseConnection);
    mysqli_autocommit($databaseConnection, 1);

}

function GetOrderID($dbConnection)
{
    $Query = "SELECT Max(OrderID) AS LastOrder FROM Orders;";
    $Statement = mysqli_prepare($dbConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Result = mysqli_fetch_array($Result);
    $lastOrderID = intval($Result['LastOrder']);

    return $lastOrderID + 1;

}

function RollBackProcessingError($dbConnection, $exception)
{
    mysqli_rollback($dbConnection);
    mysqli_autocommit($dbConnection, 1);
    print("<h2 style='text-align: center'>Er is iets fout gegaan, probeer het later opnieuw</h2><BR>");
    print($exception);
    exit;
}
}



