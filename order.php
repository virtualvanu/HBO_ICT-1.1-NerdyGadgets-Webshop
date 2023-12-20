<?php
include "header.php";
include "verwerkfuncties.php";
include "cartfuncties.php";

$databaseConnection = connectToDatabase();

if(count(getCart()) > 0) //Check if there are products in the cart to prevent empty orders from being created when the page is refreshed.
{
    //Create order
    $customerID = $_SESSION['CustomerID'];

    mysqli_autocommit($databaseConnection, 0);
    mysqli_begin_transaction($databaseConnection); // Begin SQL transaction in case of errors

    $orderID = GetOrderID($databaseConnection);
    CreateOrder($customerID, $databaseConnection);

    mysqli_commit($databaseConnection);
    mysqli_begin_transaction($databaseConnection);

    //Create orderlines and empty the cart
    FinishOrder($orderID, $databaseConnection);
}


?>

<html>
<head>
<lang nl></lang>
</head>
<body>
<div id="OrderConfirm" style="text-align: center">
    <h3>Geslaagd!</h3>
    <p>Uw order is succesvol geplaatst. Wij gaan zo snel mogelijk voor u aan de slag.</p>
    <p> Veel plezier met uw aankoop, dankuwel en tot ziens!</p>
<?php
    if(!isset($orderID))
    {
        return;
    }
?>
    <p>Bij vragen over uw bestelling, neem contact op met onze klantenservice en vermeld uw orderID <?php echo "<span style='color: #676EFF'>$orderID</span>" ?>.</p>
</div>



</body>
</html>
