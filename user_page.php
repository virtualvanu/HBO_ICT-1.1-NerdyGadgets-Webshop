<?php 
include 'header.php';
include 'klantformulierfunctie.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Klantinformatie formulier</title>
</head>
<body>
<div class="wholeform">
<form method="post">
            <h1 class="logintxt">Persoonlijke gegevens</h1>
            <div class="invoervelden">
                    <label for="vnaam">Naam:</label>
                    <input type="text" id="vnaam" name="naam" placeholder="Naam.." value="<?php echo ($_SESSION['voornaam']);  ?>" required>
                    <label for="pcode">Postcode*</label>
                    <input type="text" id="pcode" name="postcode" placeholder="Postcode.." value="<?php echo ($_SESSION['postcode']);  ?>" required>
                    <label for="hnummer">Straatnaam + Huisnummer*</label>
                    <input type="text" id="straatnaam" name="straatnaam" placeholder="Straatnaam + Huisnummer.." value="<?php echo ($_SESSION['straatnaam']);  ?>" required>
                    <label for="plaats">Plaats*</label>
                    <input type="text" id="plaats" name="plaats" placeholder="Plaats.." value="<?php echo ($_SESSION['plaats']);  ?>" required>
                    <input type="submit" value="Gegevens opslaan">
            </div>
        </form>

        <form action="Logoutfunction.php" method="post">
        <button type="submit">Uitloggen</button>
         </form>
</div>


<?php

if (session_status() == PHP_SESSION_ACTIVE) {
//echo $_SESSION['PersonID'];
}?>
</body>
</html>
