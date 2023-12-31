<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php


function connectToDatabase() {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "superadmin", "Welkom01", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID,
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}
function klantToevoegenInDatabase($databaseConnection, $klant_naam, $email,$DefinitiefWachtwoord , $adres, $postcode, $woonplaats, $land)
{
    $query = "INSERT INTO people (FullName, EmailAddress, HashedPassword ,adress,postcode,woonplaats,land)
VALUES ('$klant_naam','$email', '$DefinitiefWachtwoord' ,'$adres','$postcode','$woonplaats', '$land')";
    $statement = mysqli_prepare($databaseConnection, $query);
    mysqli_stmt_execute($statement);

}






function orderToevoegen($database, $klant_id, $betaalWijze, $datum)
{
    $klant_id = intval($klant_id);
    $query = "INSERT INTO bestelling (CustomerID,datum,betaal_wijze)
              VALUES ('$klant_id','$datum','$betaalWijze') ";
    if (mysqli_query($database, $query)) {
        $order_Id = mysqli_insert_id($database);

        return $order_Id;


    } else {
        print mysqli_error($database);

    }

}

function ischilled($id){  //checks if a product is chilled or not.
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Maakt verbinding met database
    try {
        $Connection = mysqli_connect("localhost", "superadmin", "Welkom01", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    }
    catch (Exception $e){
        print($e);
    }
    $ischillerstock = null; // Checks product ID chilled of niet.
    $databaseConnection = $Connection;
    $ischillerstock = "SELECT IsChillerStock FROM stockitems WHERE StockItemID = '$id'";
    $result = $databaseConnection->query($ischillerstock);
    $markerData = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    return $markerData['IsChillerStock'];
};

function isOnSale($id, $databaseConnection)
{
    $Result = null;

    $Query = " 
           SELECT OnSale 
        FROM stockitems
        Where StockItemID=?;";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    $onSale = $Result['OnSale'];

    if($onSale == 0)
    {
        return FALSE;
    }
    else
    {
        return TRUE;
    }
}

function getDiscountedPrice($id, $databaseConnection)
{
    $Result = null;

    $Query = " 
          SELECT (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, DiscountPercentage FROM stockitems WHERE StockItemID= ?;
          ";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    $price = round($Result['SellPrice'], 2);
    $discount = $Result['DiscountPercentage'];

    if($discount != null)
    {
        return $price - ($price * ($discount / 100));
    }
    else
    {
        return $price;
    }

}
function orderRegelToevoegen($database, $order_id, $klant_Id, $stockItemID, $aantal_stockItem)
{
    $query = "INSERT INTO orderregel (OrderID,CustomerID,StockItemID,aantal)
            VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($database,$query);
    mysqli_stmt_bind_param($stmt,"iiii",$order_id,$klant_Id,$stockItemID,$aantal_stockItem);
    if (!mysqli_stmt_execute($stmt)) {
        print mysqli_error($database);
    }
}

function updateStockItemHolding($database, $stockItemID, $aantal)
{
    $query = "UPDATE stockitemholdings SET QuantityOnHand = QuantityOnHand - '$aantal' WHERE StockItemID = '$stockItemID'";
    if (!mysqli_query($database, $query)) {
        print mysqli_error($database);

    }
}
