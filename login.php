<?php
include "header.php";
?>

<!DOCTYPE html>
<div class="container" >
    <a href="http://localhost/nerdygadgets/registreren.php">
        <button class="registreren">Registreren</button>
    </a>
</div>

<form action="action_page.php" method="post">

    <div class="container">
        <label for="uname"><b>Emailadress</b></label>
        <input type="text" placeholder="Emailadress" name="uname" required>

        <label for="psw"><b>Wachtwoord</b></label>
        <input type="password" placeholder="Wachtwoord" name="psw" required>

        <button type="submit">Login</button>
<!--        <label class="checkBox">-->
<!--            <input type="checkbox" checked="checked" name="remember"> Remember me-->
<!--        </label>-->
    </div>


</form>

<?php

$inlog_melding = "";

if (!isset($_SESSION["klant_ingelogd"])) {
    if (isset($_POST["login"])) {
        if (isset($_POST["email"]) && isset($_POST["wachtwoord"])) {
            $email = $_POST["email"];
            $wachtwoord = $_POST["wachtwoord"];
            $database = connectToDatabase();
            $klant = getCustomerGegevens($database, $email, $wachtwoord);

            if ($klant === false) {
                $inlog_melding = "<p style='color: red'>De ingevoerd gegevens zijn onjuist</p>";

            } else {

                $_SESSION["klant_ingelogd"] = $klant;
                if (isset($_POST["cart"])) {
                    header("Location:/Nerdygadgets/afrekenen.php");
                } else {
                    header("Location:/Nerdygadgets/index.php");
                }

//                $inlog_melding = "<p style='color: green'>De ingevoerd gegevns zijn juist</p>";

            }

        }

    }

} else {

    header("Location:/Nerdygadgets/browse.php");
}


?>

