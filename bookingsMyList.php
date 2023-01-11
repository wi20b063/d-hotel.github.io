<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");

    if (!$con) {
        die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
    }

    $msg = "";

    // Check if valid user is logged in
    if (!isset($_SESSION["username"])) {
        $msg = "Bitte einloggen um die Übersicht Ihrer Buchungen zu sehen!";
        exit();}
    
    if ($_SESSION["role"] != "0") {
        $msg = "Sie haben keine Berechtigung die Buchungsübersicht einzusehen!";
        exit();}
        
    // Check if session is expired.
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        $msg = "Session ist abgelaufen. Bitte neu einloggen!";
        exit();}        
        
    // If tbl_reservation is empty, display "No news users yet." in red font
    $sqlSelectMyReservations = "SELECT * FROM $mysqli_tbl_reservation";
    $result = mysqli_query($con, $sqlSelectMyReservations);
    if (mysqli_num_rows($result) == 0) {
        $msg = "Keine Buchungen vorhanden."; }

    // cancel reservation if cancel button is pressed and reservation is not already cancelled
    /* if (isset($_POST['cancel']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
        $bookingID = $_POST['bookingID'];
        $sql = "UPDATE booking SET status = 'cancelled' WHERE bookingID = '$bookingID'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $msg = "Ihre Buchung wurde erfolgreich storniert!";
        } else {
            $msg = "Fehler beim Stornieren der Buchung!";
        }
    } else {
        $msg = "Fehler beim Stornieren der Buchung!";
    } ?> */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | Buchungsübersicht</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

    <div class="content">
            <div class="container">
                <h1 class="headline">Übersicht Ihrer Buchungen</h1>
                
                <form method="POST" enctype="multipart/form-data">

                    <div class="row g-3">
                        <div class="col-md-6 mb-4" style="background-color:lightgrey"><?php echo $msg; ?></div>
                    </div>

                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col-sm-1">Buchungs-ID</th>
                                    <th scope="col-sm-1">Buchungscode</th>
                                    <th scope="col-sm-1">Raumkategorie</th>
                                    <th scope="col-sm-1">Preis</th>
                                    <th scope="col-sm-1">Ankunftsdatum</th>
                                    <th scope="col-sm-1">Abreisedatum</th>
                                    <th scope="col-sm-1">Anmerkungen</th>
                                    <!-- <th scope="col-sm-1">Personen-anzahl</th> -->
                                    <th scope="col-sm-1">Status</th>
                                </tr>
                            </thead>

                            <?php                                  

                            // GETTING DATA FROM DATABASE
                            $id = $_SESSION["personID"];
                            $sqlSelectMyReservations = "SELECT * FROM $mysqli_tbl_reservation WHERE GUESTID = $id";
                            $result = $con->query($sqlSelectMyReservations);
                            while ($row = $result->fetch_assoc()) {
                                $reservationID = $row["RESERVEID"];
                                $reservationCode = $row["CONFIRMCODE"];
                                //$roomID = $row["ROOMID"];  ---------- was modified. reservation does not need room ID, but category for searching.
                                //                                      the total number or rooms will be monitored, room assignment only at checkin...
                                $roomCategory = $row["ROOMCAT"];                               
                                $price = $row["PRICE"];
                                $arrivalDate = date("d.m.Y", strtotime($row["DATEARRIVAL"]));
                                $departureDate = date("d.m.Y", strtotime($row["DATEDEPART"]));
                                $bookingDate = date("d.m.Y", strtotime($row["DATECREATE"]));
                                $remark = $row["REMARK"];
                                $status = $row["STATUS"];
                                $guestID = $row["GUESTID"];

                                // Get name from tbl_u_profile
                                $sqlSelectPerson = "SELECT * FROM $mysqli_tbl_u_profile WHERE personID = $guestID";
                                $resultPerson = $con->query($sqlSelectPerson);
                                while ($rowPerson = $resultPerson->fetch_assoc()) {
                                    $firstname = $rowPerson["firstName"];
                                    $lastname = $rowPerson["lastName"];
                                    $email = $rowPerson["email"];
                                    //$numberOfGuests = $rowPerson["numberOfGuests"];
                                } ?>

                                <tbody>
                                    <tr>
                                        <td scope="row"><?php echo $reservationID; ?></th>
                                        <td><?php echo $reservationCode; ?></th>
                                        <td><?php echo $roomCategory; ?></th>
                                        <td><?php echo $price . " EUR";  ?></th>
                                        <td><?php echo $arrivalDate; ?></th>
                                        <td><?php echo $departureDate; ?></th>
                                        <?php if ($remark == "") { ?>
                                            <td>-</th>
                                        <?php } else { ?>
                                            <td><?php echo $remark; ?></th>
                                        <?php } ?> 
                                        <!-- <td><?php echo $numberOfGuests; ?></th> -->
                                        <?php if ($status == "reserved") { ?>
                                            <td style="background-color:lightgreen">Bestätigt</th>
                                        <?php } else if ($status == "new") { ?>
                                            <td>Offen</th>
                                        <?php } else if ($status == "cancelled") { ?>
                                            <td style="background-color:lightred">Storniert</th>
                                        <?php } else { ?>
                                            <td style="color:blue">Fehler, bitte kontaktieren Sie das Hotel.</th>
                                        <?php } ?>                                  
                                        <!-- <td><a class="btn btn-warning" href="./cancelBooking.php?personID=<//?php echo $guestID; ?>&RESERVEID=<//?php echo reservationCode; ?>">Buchung stornieren</a></th> -->
                                        <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelReserv_<?php echo $reservationID; ?>"">Buchung stornieren</button></td>

                                        <!-- Modal Cancel Booking -->
                                        <div class="container">
                                        <div class="modal fade" id="cancelReserv_<?php echo $reservationID; ?>" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Buchung stornieren</h5>
                                                </div>
                                                <div class="modal-body">                            
                                                    <p>Sind Sie sich sicher, dasss Sie die Buchung mit der Buchungs-ID <?php echo $reservationID; ?> stornieren möchten?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                    <a class="btn btn-danger" href="./components/cancelBooking.php?reservationID=<?php echo $reservationID; ?>">Buchung stornieren</a>
                                                    <!-- <button type="button" name="cancel" id="cancel" class="btn btn-primary">Stornieren</button> -->
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                    </tr>
                                </tbody>
                                <?php } ?>
                        
                        </table>
                
                </form>
                                        
                </div>                                                               
            </div>


    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

    <script type="text/javascript">
        $("#cancel").click(function () {
            var reserveID = $("#name").val();
            var marks = $("#marks").val();
            var str = "You Have Entered " 
                + "Name: " + name 
                + " and Marks: " + marks;
            $("#modal_body").html(str);
        });
    </script>

</body>

</html>