<?php


function get_temperature(){
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    }
    catch (Exception $e){
        print($e);
    }
    $ischillerstock = "SELECT Temperature FROM coldroomtemperatures WHERE ColdRoomSensorNumber = '4'";
    $result = $Connection->query($ischillerstock);

    if ($result && $result->num_rows > 0) {
        // Fetch temperature
        $row = $result->fetch_assoc();
        return $row['Temperature'];
    } else {
        return false; // No temperature found or error
    }
}


print(round(get_temperature(), 1));