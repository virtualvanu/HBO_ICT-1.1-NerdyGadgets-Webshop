<?php
function getCart()
{
    if (isset($_SESSION['cart'])) {               //controleren of winkelmandje (=cart) al bestaat
        $cart = $_SESSION['cart'];                  //zo ja:  ophalen
    } else {
        $cart = array();                            //zo nee: dan een nieuwe (nog lege) array
    }
    return $cart;                               // resulterend winkelmandje terug naar aanroeper functie
}

function saveCart($cart)
{
    $_SESSION["cart"] = $cart;                  // werk de "gedeelde" $_SESSION["cart"] bij met de meegestuurde gegevens
}

function addProductToCart($stockItemID, $amount = 1)
{
    $cart = getCart();                          // eerst de huidige cart ophalen

    if (array_key_exists($stockItemID, $cart)) {  //controleren of $stockItemID(=key!) al in array staat
        $cart[$stockItemID] += $amount;                   //zo ja:  aantal met 1 verhogen
    } else {
        $cart[$stockItemID] = $amount;                    //zo nee: key toevoegen en aantal op 1 zetten.
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}



function removeProductFromCart($stockItemID)
{
    $cart = getCart();

    if (array_key_exists($stockItemID, $cart)) {
        unset($cart[$stockItemID]);
    }

    saveCart($cart);                            // werk de "gedeelde" $_SESSION["cart"] bij met de bijgewerkte cart
}

function getProductCartAmount($stockItemID)
{
    $cart = getCart();

    if (array_key_exists($stockItemID, $cart))
    {
        return $cart[$stockItemID];
    }

    return 0;
}

function emptyCart()
{
    if (isset($_SESSION['cart']))
    {
        $cart = array();
        saveCart($cart);
    }
}

function getCartTotal($databaseConnection)
{
    $cart = getCart();
    $cartTotal = 0;
    foreach($cart as $itemId => $itemAmount)
    {
        $itemInfo = getStockItem($itemId, $databaseConnection);
        $itemPrice = round($itemInfo["SellPrice"], 2);
        $totalItemPrice = $itemPrice * $itemAmount;
        $cartTotal += $totalItemPrice;
    }

    return $cartTotal;
}

function berekenVerzendKosten($packageType, $quantity) {
    $kosten = 0;

    switch ($packageType) {
        case 1: // Bag
            $aantalZakjes = $quantity;
            $kosten = 6.95 * ceil($aantalZakjes / 50);
            break;
        case 7: // Each
            $aantalStuks = $quantity;
            $kosten = 6.95 * ceil($aantalStuks / 15);
            break;
        case 9: // Packet
            $aantalPakketen = $quantity;
            $kosten = 6.95 * ceil($aantalPakketen / 10);
            break;
        case 10: // Pair
            $aantalParen = $quantity;
            $kosten = 6.95 * ceil($aantalParen / 100);
            break;
        default:
            echo "Ongeldig UnitpackageID";
            // print ($packageType);
            break;
    }

    return $kosten;
}
function getPackageType($stockItemID){
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    }
    catch (Exception $e){
        print($e);
    }
    $databaseConnection = $Connection;
    $PackageType = "SELECT UnitPackageID FROM stockitems WHERE StockItemID = $stockItemID;";
    $result = $databaseConnection->query($PackageType);
    $markerData = mysqli_fetch_array($result, MYSQLI_ASSOC);
    
    return $markerData['UnitPackageID'];
}
?>