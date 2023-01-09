<?php
// Todo: price should go to database in separate table...
$pricePet = 50;
$priceParking = 15; //pD
$priceBreakfast = 25; //pD                 

require(dirname(__FILE__, 2) . "\components\session.php");
if (!isset($_GET['arrivalDate']) && !isset($_GET['departureDate']) && !isset($_GET['roomSelection']) && !isset($_GET['isParking'])) {
    echo "Es ist ein Fehler aufgetreten, versuchen Sie es später nochmal";
    exit();
}

// need only to trim the dates, remaining $_POSTs are ok.
$fromDat = new DateTime($_GET['arrivalDate']);
$toDat = new DateTime($_GET['departureDate']);
$duration = date_diff($fromDat, $toDat);

$fromDat->setTime(12, 0); //now setting datetime to 12:00 for arrival date 
$toDat->setTime(10, 0); // Checkout time is 10:00, so room is free for reservation at as of 12:00 on the same date!  

//buidling up price (ternary operator)
$priceExtra = 0;
$priceExtra += $_GET["isPets"] ? $pricePet : 0;
if ($_GET["isBreakfast"]) {
    $priceExtra += ($duration->days * $priceBreakfast);
}
if ($_GET["isParking"]) {
    $priceExtra += ($duration->days * $priceParking);
}

$status = "new";

// need Date format ensured for SQL 
$SQLfromDat = $fromDat->format('Y-m-d H:i:s'); // needed to make it a String for the query.
$SQLtoDat = $toDat->format('Y-m-d H:i:s');
$bookingRef = mt_rand(100000, 999999); // random 6 digits should be enough for Booking Ref
$timeStamp = date('Y-m-d H:i:s');

/* 
Prepare INSERT statement for reserving room in DB*/
$sqlInsertReserv = "INSERT INTO $mysqli_tbl_reservation  (CONFIRMCODE,  ROOMCAT, PRICE, DATEARRIVAL, DATEDEPART, DATECREATE, DATELASTUP, STATUS, GUESTID)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtProfile = $con->prepare($sqlInsertReserv);
$stmtProfile->bind_param("ssdsssssi", $bookingRef, $_GET['roomCat'], $priceExtra, $SQLfromDat, $SQLtoDat, $timeStamp, $timeStamp, $status, $_SESSION['personID']);
$stmtProfile->execute();

$result = mysqli_stmt_get_result($stmtProfile);
if ($result == 0) {
    echo "Successfully placed Reservation"; ?>
    <p><strong> Ihre Buchungsreferenz ist: <?php echo $bookingRef; ?></strong></p>
    <?php
}
?>