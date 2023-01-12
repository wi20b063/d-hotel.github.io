<?php

include "session.php";
include "inputValidation.php";


if (!$con) {
    die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
}

$readyForSubmit = true;

// GETTING DATA FROM DATABASE

$reservationID = $_GET["reservationID"];
$sqlSelectReservation = "SELECT * FROM $mysqli_tbl_reservation WHERE RESERVEID = $reservationID";
if ($sqlSelectReservation == "") {
    echo "Keine Reservierung mit der Reservierungsnummer $reservationID gefunden";
}

// Set status to cancelled where reservationID = RESERVEID

// if (isset($_POST['cancel']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {   

        // Submit to database SQL Statemnt for prepared statements
        $sqlCancelReserv = "UPDATE $mysqli_tbl_reservation SET STATUS = ? WHERE RESERVEID = ?";
        $stmtReservStatus = $con->prepare($sqlCancelReserv);
        $stmtReservStatus -> bind_param("si", $status, $reservationID);
        $status = "cancelled";
        $stmtReservStatus -> execute();         
        
        //$msg = "Buchung wurde erfolgreich storniert!";
        header("Refresh: 0; url=..\bookingsMyList.php");

/*     } else {
        //$msg = "Buchung konnte nicht storniert werden!";
    } */


?>

