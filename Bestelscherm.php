
<?php
include "header.php";
?>

<?php
if (isset($_SESSION['PersonID'])){
    header('Location: verwerk.php');
    exit();

} ?>
<!DOCTYPE html>
<html lang="nl">

<style>

</style>
<head class="head">
    <meta charset="UTF-8">
    <title>Bestelscherm</title>

    <h1 class="head">

    </h1>

    <p>U bent nog niet ingelogd</p>
        <a href="http://localhost/nerdygadgets/login.php">
            <button value="Inloggen" class="knop" style="display: inline-grid">Inloggen</button>
        </a>



        <a href="http://localhost/nerdygadgets/registratie.php">
            <button class="knop" style="display: inline-grid; margin-left: 85px">Registreren</button>
        </a>

    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>
<body style="border-top: 1px solid rgb(36, 41, 143)">
<link rel="stylesheet" type="text/css" href="custom.css">

<div style="float: left; margin-left: 40px; width: 40%">


</div>

</body>
</html>
