<?php 
include 'header.php';
include 'registratiefuncties.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registratieformulier</title>
    <link rel="stylesheet" type="text/css" href="custom.css">
</head>
<body>
<style>
    .naam {width: 15%; margin-right: 10px; display: inline-block }
</style>
<h2 class="logintxt" style="margin-left: 300px">Registreren:</h2>

<form method="post">
    <div class="wholeform">
        <div class="invoervelden">
                <label for="full_name"></label>
                <input type="text" placeholder="Voornaam*" id="full_name" class="naam" name="voornaam" style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite; margin-left: 300px" required>
                <label for="full_name"></label>
                <input type="text" id="betweenname" placeholder="Tussenvoegsel" name="tussenvoegsel" style="width: 15%; margin-right: 10px ;background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite" >
                <label for="preferred_name"></label>
                <input type="text" id="preferred_name" placeholder="Achternaam*" name="achternaam" class="naam"  required style="background-color: rgb(35, 35, 47) ; border-radius: 8px; border:solid antiquewhite; color: antiquewhite">
                <label for="email"></label>
                <input type="email" id="email" name="email" placeholder="E-mailadres*" class="gegevens" style="margin-left: 300px; margin-top: 10px; display: inline-grid" required>
                <label for="password"></label>
                <input type="password" id="password" placeholder="Wachtwoord*" name="password" class="gegevens" style="margin-left: 300px; display: inline-grid" required>
                <label for="confirm_password"></label>
                <input type="password" id="confirm_password" placeholder="Bevestig wachtwoord*" name="confirm_password" class="gegevens" style="margin-left: 300px; display: inline-grid" required>
        </div>
        <div class="submission">

            <input type="submit" value="Registreren" class="knop"><br>
            <a href="login.php" style="margin-left: 300px">← Terug</a>
        </div>
    </div>
</form>


</body>
</html>
