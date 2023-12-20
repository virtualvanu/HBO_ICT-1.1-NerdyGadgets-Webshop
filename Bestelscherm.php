
<?php
include "header.php";
?>

<?php
if (isset($_SESSION['CustomerID'])){
    header('Location: verwerk.php');
    exit();

    }
if (empty($_SESSION['PersonID'])){

    print '


<!DOCTYPE html>
<html lang="nl">

<style>

</style>
<head class="head">
    <meta charset="UTF-8">
    <title>Bestelscherm</title>

    <h1 class="head">

    </h1>

    <p style="margin-left: 300px;">U bent nog niet ingelogd</p>
        <a href="http://localhost/nerdygadgets/login.php">
            <button value="Inloggen" class="knop" style="display: inline-grid; width: 30%;">Inloggen</button>
        </a>



        <a href="http://localhost/nerdygadgets/registratie.php">
            <button class="knop" style="display: inline-grid; margin-left: 85px; width: 30%;">Registreren</button>
        </a>

    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>

<body style="border-top: 1px solid rgb(36, 41, 143)">
<link rel="stylesheet" type="text/css" href="custom.css">

<div style="float: left; margin-left: 40px; width: 40%">


</div>';
}
if(empty($_SESSION['CustomerID']) && !empty($_SESSION['PersonID']))
    print "
    <div>
        <p style='margin-left: 85px;'>Voor uw gegevens alstublief in:</p>
        <a href='http://localhost/nerdygadgets/user_page.php'>
        <button class='knop' style='display: inline-grid; margin-left: 85px; width: 30%;'>Account gegevens</button>
        </a>
    </div>
    
    
    
    ";
?>
</body>
</html>
