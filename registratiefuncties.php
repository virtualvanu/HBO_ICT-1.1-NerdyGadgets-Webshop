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

// Hier haal je gegevens op vanuit het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["voornaam"];
    $betweenname = (empty($_POST["tussenvoegsel"])) ? " " : $_POST["tussenvoegsel"] . " ";
    $achternaam = $_POST["achternaam"];
    $email = $_POST["email"];
    $password = $_POST["password"];
$query = "SELECT EmailAddress FROM people WHERE EmailAddress = '$email'";
    if ($conn->query($query) != TRUE) {
        echo "Emailaddress is al gebruikt";
        // Voorkom verdere uitvoering van de code als emails niet overeenkomen
        exit();
    }

    // Controleer of wachtwoorden overeenkomen
    $confirmPassword = $_POST["confirm_password"];
    if ($password !== $confirmPassword) {
        echo "Wachtwoorden komen niet overeen";
        // Voorkom verdere uitvoering van de code als wachtwoorden niet overeenkomen
        exit();
    }

    // Vervang dit door de werkelijke waarde van LastEditedBy
    $lastEditedBy = 1; // Een bestaande PersonID-waarde

    // Hash het wachtwoord met SHA-256
    $hashedPassword = hash('sha256', $password);

$klant_naam = $fullName . " " . $betweenname . $achternaam;
    $sql = "INSERT INTO people (FullName,EmailAddress, HashedPassword, LastEditedBy) VALUES ('$klant_naam','$email', '$hashedPassword', '$lastEditedBy')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account aangemaakt');</script>";
        header('Location: login.php');
    } else {
        echo "Fout: " . $sql . "<br>" . $conn->error;
    }
}

// Sluit de verbinding
$conn->close();
?>
