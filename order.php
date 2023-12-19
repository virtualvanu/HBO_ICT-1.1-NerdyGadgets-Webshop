<?php
include "header.php";
include "verwerkfuncties.php";
$databaseConnection = connectToDatabase();

//Create order
$customerID = $_SESSION['CustomerID'];
$orderID = CreateOrder($customerID, $databaseConnection);
//Create orderlines and empty the cart
//FinishOrder($orderID, $databaseConnection);





?>

<html>
<head>
<lang nl></lang>
</head>
<body>
<p> U heb afgerekend en uw bestelling is geplaatst</p>
<p2> Uw order id = <?php echo $orderID ?></p2>
<p3> Dankuwel en tot ziens!</p3>


</body>
</html>
