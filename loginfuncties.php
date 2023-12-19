<?php


// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nerdygadgets";

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}
if (isset($_SESSION['PersonID'])){
header('Location: user_page.php');
    exit();

}

// Hier haal je gegevens op vanuit het inlogformulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash het ontvangen wachtwoord met SHA-256 om te vergelijken met de opgeslagen hash in de database
    $hashedPassword = hash('sha256', $password);

    // Zoek de gebruiker in de database
    $sql = "SELECT * FROM people WHERE EmailAddress = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Gebruiker gevonden, controleer of het wachtwoord overeenkomt
        $row = $result->fetch_assoc();
        $storedHashedPassword = $row['HashedPassword'];

        if ($hashedPassword === $storedHashedPassword) {


            // Inloggen gelukt, sla de PersonID op in de sessie en stuur door naar gebruikerspagina
            $_SESSION['PersonID'] = $row['PersonID'];
            $_SESSION['voornaam'] = $row['FullName'];
            $_SESSION['EmailAddress'] = $row['EmailAddress'];
            $ingelogde_personID = $row['PersonID'];
            $query1 = "SELECT * FROM customers WHERE PrimaryContactPersonID = '$ingelogde_personID'";
            $result1 = $conn->query($query1);
                if ($result1->num_rows > 0) {
                $row = $result1->fetch_assoc();
                $_SESSION['postcode'] = $row['PostalPostalCode'];;
                $_SESSION['plaats'] = $row["PostalAddressLine2"];
                $_SESSION['straatnaam'] = $row["PostalAddressLine1"];
                header("Location: user_page.php");
                exit();
                // Voer verdere acties uit voor ingelogde gebruiker
            }
            header("Location: user_page.php");
        }
       else {
        // Onjuist wachtwoord
        echo "<script>alert('Onjuist wachtwoord');</script>";
        }
    }
else {
        // Gebruiker niet gevonden
        echo "<script>alert('Gebruiker niet gevonden');</script>";
    }

}
// Sluit de verbinding
$conn->close();
?>
