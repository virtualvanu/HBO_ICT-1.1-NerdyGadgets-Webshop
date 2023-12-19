<?php
// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nerdygadgets";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren op fouten in de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


// Ontvangen van de ingelogde gebruiker (hier ga ik uit van de 'personID' opgeslagen in de sessie)
$ingelogde_personID = $_SESSION['PersonID'];





if ($_SERVER["REQUEST_METHOD"] == "POST")
{
// Ontvangen van formuliergegevens
    $postcode = $_POST['postcode'];
    $straatnaam = $_POST['straatnaam'];
    $plaats = $_POST['plaats'];
    $adress = $straatnaam;
    $customerNaam = $_POST['naam'];
// Ontvangen van de ingelogde gebruiker (hier ga ik uit van de 'personID' opgeslagen in de sessie)
    $ingelogde_personID = $_SESSION['PersonID'];


    $query1 = "SELECT CustomerID FROM customers WHERE PrimaryContactPersonID = '$ingelogde_personID'";
    $result1 = $conn->query($query1);
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $_SESSION['CustomerID'] = $row['CustomerID'];
        $CustomerID = $_SESSION['CustomerID'];
//        $sql_update_name = "UPDATE customers SET CustomerName = '' WHERE CustomerID = '$CustomerID'";
        if ($result1->num_rows > 0) {
            $sql_update_customer = "UPDATE customers SET PrimaryContactPersonID = '$ingelogde_personID', PostalAddressLine1 = '$adress', PostalAddressLine2 = '$plaats' , PostalPostalCode = '$postcode', CustomerCategoryID = '3', DeliveryMethodID = '3', DeliveryCityID = '38184' ,PostalCityID = '38184', BillToCustomerID = 1 ,LastEditedBy = '1', CustomerName = '$customerNaam' WHERE CustomerID = '$CustomerID'";
            $sql_update_name = "UPDATE people SET FullName = '$customerNaam' where PersonID = '$ingelogde_personID'";
            if ($conn->query($sql_update_customer) === TRUE && $conn->query($sql_update_name) === TRUE) {
                echo "Klantinformatie succesvol aangepast.";
            } else {
                echo "Error: " . $sql_update_customer . "<br>" . $conn->error;
            }
        }
    }
    else {
        $sql_insert_customer = "INSERT INTO customers (PrimaryContactPersonID, PostalAddressLine1, PostalAddressLine2 , PostalPostalCode, CustomerCategoryID, DeliveryMethodID, DeliveryCityID,PostalCityID, BillToCustomerID,LastEditedBy, CustomerName ) VALUES ('$ingelogde_personID','$adress', '$plaats' , '$postcode', '3', '3', '38184','38184','1','1', '$customerNaam')";

        if ($conn->query($sql_insert_customer) === TRUE) {
            echo "Klantinformatie succesvol toegevoegd.";
        } else {
            echo "Error: " . $sql_insert_customer . "<br>" . $conn->error;
        }
    }


    $query1 = "SELECT CustomerID FROM customers WHERE PrimaryContactPersonID = '$ingelogde_personID'";
    $result1 = $conn->query($query1);
    if ($result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $_SESSION['CustomerID'] = $row['CustomerID'];

    }
    $CustomerID = $_SESSION['CustomerID'];
    $query2 = "SELECT PostalAddressLine1, PostalAddressLine2, PostalPostalCode, CustomerName FROM customers WHERE CustomerID = '$CustomerID'";
    $result2 = $conn->query($query2);

    if ($result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $_SESSION['straatnaam'] = $row['PostalAddressLine1'];
        $_SESSION['plaats'] = $row['PostalAddressLine2'];
        $_SESSION['postcode'] = $row['PostalPostalCode'];
        $_SESSION['voornaam'] = $row['CustomerName'];

    }


}




$conn->close();
?>
