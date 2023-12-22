<?php
// Haalt huidige temperatuur uit database

function get_temperature(){
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $Connection = mysqli_connect("localhost", "temperaturesensor", "", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    }
    catch (Exception $e){ // achtervang voor als connectie faalt. krijg je error code te zien.
        print($e);
    }
    $ischillerstock = "SELECT Temperature FROM coldroomtemperatures WHERE ColdRoomSensorNumber = '5'";
    $result = $Connection->query($ischillerstock);

    if ($result && $result->num_rows > 0) {
        // haal temperatuur op
        $row = $result->fetch_assoc();
        return $row['Temperature'];
    } else {
        return false; // No temperature found error
    }
}


print(round(get_temperature(), 1));