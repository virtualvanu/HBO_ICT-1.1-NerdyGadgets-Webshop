<?php

function FetchProductTopFive($databaseConnection)
{
    $Result = null;
    $topFive = array();
    $Query = "
    SELECT SI.StockItemID, SI.AmountSold, SI.StockItemName, (SI.RecommendedRetailPrice*(1+(SI.TaxRate/100))) AS SellPrice, SH.QuantityOnHand 
    FROM stockitems SI
    JOIN stockitemholdings SH ON (SI.StockItemID=SH.StockItemID)
    WHERE AmountSold > 0
    GROUP BY AmountSold DESC;
    ";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult)
    {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);
    }

    $mostSold = 0;
    $mostSoldID = 0;
    $i = 0;
    while(count($topFive) < 5)
    {
        foreach ($Result as $record)
        {
            $resultQuantity = $record['QuantityOnHand'];
            $quantityInt = preg_replace('/[^0-9]/', '', $resultQuantity);
            if(!in_array($record['StockItemID'], $topFive) && $quantityInt > 0)
            {
                $productAmountSold = $record['AmountSold'];
                if($productAmountSold > $mostSold)
                {
                    $mostSold = $productAmountSold;
                    $mostSoldID = $record['StockItemID'];
                }
            }
        }

        $topFive[$i] = $mostSoldID;
        $mostSold = 0;
        $mostSoldID = 0;
        $i++;
    }

    return $topFive;
}