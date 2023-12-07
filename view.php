<!-- dit bestand bevat alle code voor de pagina die één product laat zien -->
<?php
include __DIR__ . "/header.php";


$StockItem = getStockItem($_GET['id'], $databaseConnection);
$StockItemImage = getStockItemImage($_GET['id'], $databaseConnection);
?>
<div id="CenteredContent">
    <?php
    if ($StockItem != null) {
        ?>
        <?php
        if (isset($StockItem['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $StockItem['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($StockItemImage)) {
                // één plaatje laten zien
                if (count($StockItemImage) == 1) {
                    ?>
                    <div id="ImageFrame"
                        style="background-image: url('Public/StockItemIMG/<?php print $StockItemImage[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;">
                    </div>
                    <?php
                } else if (count($StockItemImage) >= 2) { ?>
                        <!-- meerdere plaatjes laten zien -->
                        <div id="ImageFrame">
                            <div id="ImageCarousel" class="carousel slide" data-interval="false">
                                <!-- Indicators -->
                                <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                        <li data-target="#ImageCarousel" data-slide-to="<?php print $i ?>" <?php print(($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                                </ul>

                                <!-- slideshow -->
                                <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($StockItemImage); $i++) {
                                    ?>
                                        <div class="carousel-item <?php print($i == 0) ? 'active' : ''; ?>">
                                            <img src="Public/StockItemIMG/<?php print $StockItemImage[$i]['ImagePath'] ?>">
                                        </div>
                                <?php } ?>
                                </div>

                                <!-- knoppen 'vorige' en 'volgende' -->
                                <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </a>
                            </div>
                        </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                    style="background-image: url('Public/StockGroupIMG/<?php print $StockItem['BackupImagePath']; ?>'); background-size: cover;">
                </div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer:
                <?php print $StockItem["StockItemID"]; ?>
            </h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $StockItem['StockItemName']; ?>
            </h2>
            <div class="QuantityText">
                <?php print $StockItem['QuantityOnHand']; ?>
            </div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild CenterPriceLeftView">
                        <p class="StockItemPriceText"><b>
                                <?php print sprintf("€ %.2f", $StockItem['SellPrice']); ?>
                            </b></p>
                        <h6> Inclusief BTW </h6>
                        <?php
                        include "cartfuncties.php";
                        ?>
                        <!DOCTYPE html>
                        <html lang="nl">

                        <head>
                            <meta charset="UTF-8">
                            <title>Artikelpagina (geef ?id=.. mee)</title>
                            <link rel="stylesheet" href="custom.css"> <!-- to fix add to cart button jumping -->
                        </head>

                        <body>

                            <?php
                            //?id=1 handmatig meegeven via de URL (gebeurt normaal gesproken als je via overzicht op artikelpagina terechtkomt)
                            if (isset($_GET["id"])) {
                                $stockItemID = $_GET["id"];
                            } else {
                                $stockItemID = 0;
                            }
                            ?>
                            <!-- Voeg product aan winkelmandje toe -->
                            <!-- formulier via POST en niet GET om te zorgen dat refresh van pagina niet het artikel onbedoeld toevoegt-->
                            <form method="post" position=absolute>
                                <input type="number" name="stockItemID" value="<?php print($stockItemID) ?>" hidden>
                                <input type="number" name="itemAmount" value="1" min="1">
                                <input type="submit" name="submit" value="Voeg toe aan winkelmand">
                            </form>
                            <div class="message"> <!-- reserveert ruimte voor added to cart message onder button -->

                                <?php
                                if (isset($_POST["submit"])) {              // zelfafhandelend formulier
                                    //Fetch the item to add to cart
                                    $stockItemID = $_POST["stockItemID"];
                                    $itemAmount = $_POST['itemAmount'];
                                    $itemQuantity = $StockItem['QuantityOnHand'];
                                    $quantityInt = preg_replace('/[^0-9]/', '', $itemQuantity);

                                    //Get the current cart and compare the added amount to current stock
                                    $productCartAmount = getProductCartAmount($stockItemID);
                                    $amountDifference = intval($quantityInt) - intval($productCartAmount);
                                    //print($amountDifference); //Debug print
                            
                                    //Add the product to cart if the current stock allows and the cart contains less than it already.
                                    if ($itemAmount <= $quantityInt && $itemAmount <= $amountDifference) {
                                        addProductToCart($stockItemID, $itemAmount);         //Maak gebruik van geïmporteerde functie uit cartfuncties.php
                                        print("<p>Product toegevoegd aan <a href='cart.php'> winkelmandje!</a></p>");
                                    } else {
                                        print("<p>Helaas is het gekozen aantal momenteel niet in voorraad, kies een lager aantal of probeer het later opnieuw.</p>");
                                    }
                                }
                                ?>

                        </body>

                        </html>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p>

                <?php //Remove the item's name from its description
                    $descriptionHTML = $StockItem['SearchDetails'];
                    $descriptionHTML = str_replace($StockItem['StockItemName'], "", $descriptionHTML);
                    print $descriptionHTML;
                    ?>
            </p>
        </div>
    <div id="StockItemSpecifications">
        <h3>Artikel specificaties</h3>
        <?php
        $CustomFields = json_decode($StockItem['CustomFields'], true);
        if (is_array($CustomFields)) { ?>
            <table>
                <thead>
                    <th>Naam</th>
                    <th>
                        <?php print($StockItem['StockItemName']); ?>
                    </th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php
                            switch ($SpecName) //Translate english database terms into user-friendly Dutch terms
                            {
                                case "CountryOfManufacture":
                                    print("Land van fabricage");
                                    break;
                                case "Range":
                                    print("Doelgroep");
                                    break;
                                case "ShelfLife":
                                    print("Houdbaarheid");
                                    break;
                                case "MinimumAge":
                                    print("Minimum leeftijd");
                                    break;
                                default:
                                    print $SpecName;
                            }

                            ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <?php
        } else { ?>

            <p>
                <?php print $StockItem['CustomFields']; ?>.
            </p>
            <?php
        }
        ?>
    </div>
    <?php
    } else {
        ?>
    <h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2>
    <?php
    } ?>
</div>