<?php

function FetchProductTopFive($databaseConnection)
{
    $Result = null;
    $topFive = array();
    $Query = "
    SELECT StockItemID, AmountSold, StockItemName, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice 
    FROM stockitems
    WHERE AmountSold > 0
    GROUP BY StockItemID;
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
            if(!in_array($record['StockItemID'], $topFive))
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