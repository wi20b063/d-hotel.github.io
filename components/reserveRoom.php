<?php
// Todo: price should go to database in separate table...

$priceRoomRate = 0;
$priceExtra = 0;
$priceTotal = 0;

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

//prepare booleans for insert into reservation table and calculate pricing
// $GET was also submitted by the Ajax HTML function
$isBreakFast = $_GET["isBreakfast"] == "yes" ? 1 : 0;
$isParking = $_GET["isParking"] == "yes" ? 1 : 0;
$isPet = $_GET["isPets"] == "yes" ? 1 : 0;

// add up total price for the reservation, prices we have already stored in $_SESSION["Pricearray]["PRICECAT"]
if ($isBreakFast) {
    $priceExtra += ($duration->days * $_SESSION["PriceArray"]["BREAKFAST"]);
}
if ($isParking) {
    $priceExtra += ($duration->days * $_SESSION["PriceArray"]["PARKING"]);
}
if ($isPet) {
    $priceExtra += $_SESSION["PriceArray"]["PET"];
}

$priceRoomRate = $_SESSION["PriceArray"][$_GET['roomCat']];
$priceTotal = $duration->days * $priceRoomRate + $priceExtra;


$bookingStatus = "new";

// need Date format ensured for SQL 
$SQLfromDat = $fromDat->format('Y-m-d H:i:s'); // needed to make it a String for the query.
$SQLtoDat = $toDat->format('Y-m-d H:i:s');
$bookingRef = mt_rand(100000, 999999); // random 6 digits for Booking Reference number
$timeStamp = date('Y-m-d H:i:s');



/* Insert reservation to Database
Prepare INSERT statement for reserving room in DB*/
$sqlInsertReserv = "INSERT INTO $mysqli_tbl_reservation  (CONFIRMCODE,  ROOMCAT, PRICE, BREAKF, PARKING, PET, DATEARRIVAL, DATEDEPART, DATECREATE, DATELASTUP, STATUS, GUESTID)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmtRes = $con->prepare($sqlInsertReserv);
$stmtRes->bind_param("ssdiiisssssi", $bookingRef, $_GET['roomCat'], $priceTotal, $isBreakFast, $isParking, $isPet, $SQLfromDat, $SQLtoDat, $timeStamp, $timeStamp, $bookingStatus, $_SESSION['personID']);
$stmtRes->execute();

$result = mysqli_stmt_get_result($stmtRes);
if ($result == 0) {
    echo "Reservierung erfolgreich"; ?>
    <p><strong> Ihre Buchungsreferenz ist: <?php echo $bookingRef; ?></strong></p>
    <p><strong> Ihre Buchungen und deren Status sind <a href="bookingsMyList.php">hier </a> einsehbar </strong></p>
    <?php
}
?>