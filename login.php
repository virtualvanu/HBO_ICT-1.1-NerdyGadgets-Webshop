<?php
include "header.php";
include 'loginfuncties.php'
?>

<!DOCTYPE html>



<body>
<br><br>
<form  method="post">
    <div class="wholeform">
        <div class="invoervelden">
            <label for="email"></label>
            <input type="email" id="email" placeholder="E-mailadres*" name="email" class="gegevens" style="display: inline-grid; margin-left: 300px" required><br>
            <label for="password"></label>
            <input type="password" id="password" name="password" placeholder="Wachtwoord*" class="gegevens" style="display: inline-grid; margin-left: 300px" required>
        </div>
        <div class="submission">
            <input type="submit" value="Inloggen" class="knop" style="display: inline-grid">
        </div>
    </div>
</form>


<div class="container" >
    <a href="http://localhost/nerdygadgets/registratie.php">
        <button class="knop" style="display: inline-grid; margin-left: 85px">Registreren</button>
    </a>
</div>
</body>
<?php

?>

