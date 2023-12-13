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

<<<<<<< HEAD
function getDiscountInfo($discountCode, $dbConnection) {
    $query = "SELECT * FROM kortingscodes WHERE Kortingscode = ?;";

    $stmt = $dbConnection->prepare($query);
    $stmt->bind_param("s", $discountCode);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discountInfo = $result->fetch_assoc();
        return $discountInfo;
    } else {
        return null; // Geen overeenkomende kortingscode gevonden
    }
}

=======
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

>>>>>>> develop

?>