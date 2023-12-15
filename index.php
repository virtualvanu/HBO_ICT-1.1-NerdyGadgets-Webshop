<!-- dit is het bestand dat wordt geladen zodra je naar de website gaat -->
<?php
include __DIR__ . "/header.php";
include __DIR__ . "/topsellerfuncties.php";
?>
<div class="IndexStyle">
    <div class="col-11">
        <div class="TextPrice">
            <a href="view.php?id=93">
                <div class="TextMain">
                    "The Gu" red shirt XML tag t-shirt (Black) M
                </div>
                <ul id="ul-class-price">
                    <li class="HomePagePrice">€30.95</li>
                </ul>
        </div>
        </a>
        <div class="HomePageStockItemPicture"></div>
    </div>
    <div class="col-xl-11" style="text-align: center;">
        <h1 class="TextMain" style="font-size: xx-large; text-align: -moz-center;"><b>MEEST VERKOCHT</b></h1>
        <?php
        $emptyWhitespace = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $topFive = FetchProductTopFive($databaseConnection);
        $sellerOne = getStockItem($topFive[0], $databaseConnection);
        $sellerOneImage = getStockItemImage($sellerOne['StockItemID'], $databaseConnection);
        $sellerOnePrice = round($sellerOne['SellPrice'], 2);
        $sellerOnePrice = number_format($sellerOnePrice, 2, '.', '.');
        $displayDiscountPriceOne = number_format(getDiscountedPrice($sellerOne['StockItemID'], $databaseConnection), 2);

        $sellerTwo = getStockItem($topFive[1], $databaseConnection);
        $sellerTwoImage = getStockItemImage($sellerTwo['StockItemID'], $databaseConnection);
        $sellerTwoPrice = round($sellerTwo['SellPrice'], 2);
        $sellerTwoPrice = number_format($sellerTwoPrice, 2, '.', '.');
        $displayDiscountPriceTwo = number_format(getDiscountedPrice($sellerTwo['StockItemID'], $databaseConnection), 2);

        $sellerThree = getStockItem($topFive[2], $databaseConnection);
        $sellerThreeImage = getStockItemImage($sellerThree['StockItemID'], $databaseConnection);
        $sellerThreePrice = round($sellerThree['SellPrice'], 2);
        $sellerThreePrice = number_format($sellerThreePrice, 2, '.', '.');
        $displayDiscountPriceThree = number_format(getDiscountedPrice($sellerThree['StockItemID'], $databaseConnection), 2);

        $sellerFour = getStockItem($topFive[3], $databaseConnection);
        $sellerFourImage = getStockItemImage($sellerFour['StockItemID'], $databaseConnection);
        $sellerFourPrice = round($sellerFour['SellPrice'], 2);
        $sellerFourPrice = number_format($sellerFourPrice, 2, '.', '.');
        $displayDiscountPriceFour = number_format(getDiscountedPrice($sellerFour['StockItemID'], $databaseConnection), 2);

        $sellerFive = getStockItem($topFive[4], $databaseConnection);
        $sellerFiveImage = getStockItemImage($sellerFive['StockItemID'], $databaseConnection);
        $sellerFivePrice = round($sellerFive['SellPrice'], 2);
        $sellerFivePrice = number_format($sellerFivePrice, 2, '.', '.');
        $displayDiscountPriceFive = number_format(getDiscountedPrice($sellerFive['StockItemID'], $databaseConnection), 2);
        ?>
        <table class="col-xl-11" style="font-size: xx-large; text-align: -moz-center;">
            <tr>
                <th>#1</th>
                <th>#2</th>
                <th>#3</th>
                <th>#4</th>
                <th>#5</th>
            </tr>
            <tr>
                <th>
                    <a href=view.php?id=<?php print $sellerOne['StockItemID'];?>><h3 class="TopSellerProductName"><?php print($sellerOne['StockItemName']);?></h3></a>
                    <a href=view.php?id=<?php print $sellerOne['StockItemID'];?>><img src="Public/StockItemIMG/<?php print $sellerOneImage[0]['ImagePath']; ?>" class="TopSellerImage"></a>
                    <p class="TopSellerPrice" style="text-align: inherit;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <p class="TopSellerPrice">€<?php print($sellerOnePrice); ?></p> <!-- Mind the € and !-->
                </th>
                <th>
                    <a href=view.php?id=<?php print $sellerTwo['StockItemID'];?>><h3 class="TopSellerProductName"><?php print($sellerTwo['StockItemName']);?></h3></a>
                    <a href=view.php?id=<?php print $sellerTwo['StockItemID'];?>><img src="Public/StockItemIMG/<?php print $sellerTwoImage[0]['ImagePath']; ?>" class="TopSellerImage"></a>
                    <p class="TopSellerPrice">€<?php print($sellerTwoPrice); ?>!</p>
                    <span style='color:red;text-decoration:line-through ' class="TopSellerPrice" >
                        <span style='color:#5F63A5'>€999.99</span>
                    </span>
                </th>
                <th>
                    <a href=view.php?id=<?php print $sellerThree['StockItemID'];?>><h3 class="TopSellerProductName"><?php print($sellerThree['StockItemName']);?></h3></a>
                    <a href=view.php?id=<?php print $sellerThree['StockItemID'];?>><img src="Public/StockItemIMG/<?php print $sellerThreeImage[0]['ImagePath']; ?>" class="TopSellerImage"></a>
                    <p class="TopSellerPrice">€<?php print($sellerThreePrice); ?>!</p>
                    <span style='color:red;text-decoration:line-through ' class="TopSellerPrice" >
                        <span style='color:#5F63A5'>€999.99</span>
                    </span>                </th>
                <th>
                    <a href=view.php?id=<?php print $sellerFour['StockItemID'];?>> <h3 class="TopSellerProductName"><?php print($sellerFour['StockItemName']);?></h3></a>
                    <a href=view.php?id=<?php print $sellerFour['StockItemID'];?>><img src="Public/StockItemIMG/<?php print $sellerFourImage[0]['ImagePath']; ?>" class="TopSellerImage"></a>
                    <p class="TopSellerPrice"><?php
                        if(isOnSale($sellerFour['StockItemID'], $databaseConnection))
                        {
                            print('€'.$displayDiscountPriceFour.'!');
                        }
                        else
                        {
                            print($emptyWhitespace);
                        }
                        ?>

                    </p>
                    <?php
                    if(isOnSale($sellerFour['StockItemID'], $databaseConnection))
                    {
                        $htmlStringFour = "
                    <span style='color:red;text-decoration:line-through ' class='TopSellerPrice' >
                        <span style='color:#5F63A5'>€$sellerFourPrice</span>
                    </span>
                    ";
                        print($htmlStringFour);
                    }
                    else
                    {
                        print('<h3 class="TopSellerPrice">'.'€'.$sellerFourPrice.'</h3>');
                    }
                    ?>
                </th>
                <th>
                    <a href=view.php?id=<?php print $sellerFive['StockItemID'];?>><h3 class="TopSellerProductName"><?php print($sellerFive['StockItemName']);?></h3></a>
                    <a href=view.php?id=<?php print $sellerFive['StockItemID'];?>><img src="Public/StockItemIMG/<?php print $sellerFiveImage[0]['ImagePath']; ?>" class="TopSellerImage"></a>
                    <p class="TopSellerPrice"><?php
                        if(isOnSale($sellerFive['StockItemID'], $databaseConnection))
                        {
                            print('€'.$displayDiscountPriceFive.'!');
                        }
                        else
                        {
                            print($emptyWhitespace);
                        }
                        ?>

                    </p>
                    <?php
                    if(isOnSale($sellerFive['StockItemID'], $databaseConnection))
                    {
                        $htmlStringFive = "
                    <span style='color:red;text-decoration:line-through ' class='TopSellerPrice' >
                        <span style='color:#5F63A5'>€$sellerFivePrice</span>
                    </span>
                    ";
                        print($htmlStringFive);
                    }
                    else
                    {
                        print('<h3 class="TopSellerPrice">'.'€'.$sellerFivePrice.'</h3>');
                    }
                    ?>
                </th>
            </tr>
        </table>
    </div>
</div>

<?php
include __DIR__ . "/footer.php";
?>

