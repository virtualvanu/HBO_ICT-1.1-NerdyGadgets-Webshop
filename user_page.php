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
            <h1 style="margin-left: 100px;" class="logintxt">Persoonlijke gegevens</h1>
            <div class="invoervelden" >
                    <label for="vnaam" style="margin-left: 100px;">Naam:</label><br>
                    <input class="gegevens" type="text" id="vnaam" name="naam" placeholder="Naam.." value="<?php if(!empty($_SESSION['voornaam'])) {echo ($_SESSION['voornaam']); } ?>" required><br>
                    <label for="pcode" style="margin-left: 100px;">Postcode*</label><br>
                    <input class="gegevens" type="text" id="pcode" name="postcode" placeholder="Postcode.." value="<?php if(!empty($_SESSION['postcode'])) {echo ($_SESSION['postcode']); } ?>" required><br>
                    <label for="hnummer" style="margin-left: 100px;">Straatnaam + Huisnummer*</label><br>
                    <input class="gegevens" type="text" id="straatnaam" name="straatnaam" placeholder="Straatnaam + Huisnummer.." value="<?php if(!empty($_SESSION['straatnaam']) ){echo ($_SESSION['straatnaam']);}   ?>" required><br>
                    <label for="plaats" style="margin-left: 100px;">Plaats*</label><br>
                    <input class="gegevens" type="text" id="plaats" name="plaats" placeholder="Plaats.." value="<?php if(!empty($_SESSION['plaats']) ){echo ($_SESSION['plaats']);}   ?>" required><br>
                    <input class="knop" type="submit" value="Gegevens opslaan" style="margin-left: 100px;">
            </div>
        </form>

        <form action="Logoutfunction.php" method="post">
        <button class="knop" type="submit" style="margin-left: 100px; margin-top: 10px">Uitloggen</button>
         </form>
</div>


<?php

if (session_status() == PHP_SESSION_ACTIVE) {
//echo $_SESSION['PersonID'];
}?>
</body>
</html>
