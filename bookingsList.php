<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");

    if (!$con) {
        die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
    }

    $msg = $resID = $resIDErr = $changeStatusSelectValue = $changeStatusSelectErr = "";

    // Check if valid user is logged in
    if (!isset($_SESSION["username"])) {
        $msg = "Bitte einloggen um die Übersicht der User zu sehen!";
        exit();}
    
    if ($_SESSION["role"] != "1") {
        $msg = "Sie haben keine Berechtigung die Übersicht der User zu sehen!";
        exit();}
        
    // Check if session is expired.
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        $msg = "Session ist abgelaufen. Bitte neu einloggen!";
        exit();}        
        
    // If tbl_reservation is empty, display "No news users yet." in red font
    $sqlSelectReservations = "SELECT * FROM $mysqli_tbl_reservation";
    $result = mysqli_query($con, $sqlSelectReservations);
    if (mysqli_num_rows($result) == 0) {
        $msg = "Keine Buchungen vorhanden."; }

        // change status of reservation if status button is pressed
    $readyForSubmit = true;

    if (isset($_POST['changeStatus']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

        // combined generic Validations (isempty, errorMsgs, open for expansion)
        $readyForSubmit = $readyForSubmit & genericValidation($resIDErr, $_POST["reservationIDstatus"]);
        $readyForSubmit = $readyForSubmit & genericValidation($changeStatusSelectErr, $_POST["changeStatusSelect"]);

        if ($readyForSubmit == true) {
        // get the data from the form
        $resID = $_POST["reservationIDstatus"];
        $changeStatusSelectValue = $_POST["changeStatusSelect"];

        // Submit to database SQL Statemnt for prepared statements
        $sqlChangeStatus = "UPDATE $mysqli_tbl_reservation SET STATUS = ? WHERE RESERVEID = ?";
        $stmtReservStatus = $con->prepare($sqlChangeStatus);
        $stmtReservStatus -> bind_param("si", $changeStatusSelectValue, $resID);
        $stmtReservStatus -> execute();

        $msg = "Status der Buchung $resID wurde erfolgreich geändert!";
        header("Refresh: 3; url=bookingsList.php");
        
        } else {
        $msg = "Fehler beim ändern des Status der Buchung $resID.";
        }
    
    }
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
                <h1 class="headline">Übersicht aller Buchungen</h1>
                
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
                                    <th scope="col-sm-1">Raum-kategorie</th>
                                    <th scope="col-sm-1">Preis</th>
                                    <th scope="col-sm-1">Ankunftsdatum</th>
                                    <th scope="col-sm-1">Abreisedatum</th>
                                    <th scope="col-sm-1">Anmerkungen</th>
                                    <th scope="col-sm-1">Vorname</th>
                                    <th scope="col-sm-1">Nachname</th>
                                    <th scope="col-sm-1">E-Mailadresse</th>
                                    <th scope="col-sm-1">Telefon</th>
                                    <th scope="col-sm-1">Status</th>
                                </tr>
                            </thead>

                            <?php                                  

                            // Link each uploaded file. Hint: keep in mind to use the correct path!

                            // Get all data from tbl_news
                            $sqlSelectReservations = "SELECT * FROM $mysqli_tbl_reservation";
                            $result = $con->query($sqlSelectReservations);
                            while ($row = $result->fetch_assoc()) {
                                $reservationID = $row["RESERVEID"];
                                $reservationCode = $row["CONFIRMCODE"];
                                //$roomID = $row["ROOMID"];  ---------- was modified. reservation does not need room ID, but category for searching.
                                //                                      the total number or rooms will be monitored, room assignment only at checkin...
                                $roomCategory = $row["ROOMCAT"];                               
                                $price = $row["PRICE"];
                                $arrivalDate = $row["DATEARRIVAL"];
                                $departureDate = $row["DATEDEPART"];
                                $bookingDate = $row["DATECREATE"];
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
                                    $tel = $rowPerson["tel"];
                                } ?>

                                <tbody>
                                    <tr>
                                        <td scope="row"><?php echo $reservationID; ?></th>
                                        <td><?php echo $reservationCode; ?></th>
                                        <td><?php echo $roomCategory; ?></th>
                                        <td><?php echo $price; ?></th>
                                        <td><?php echo $arrivalDate; ?></th>
                                        <td><?php echo $departureDate; ?></th>
                                        <td><?php echo $remark; ?></th>
                                        <td><?php echo $firstname; ?></th>
                                        <td><?php echo $lastname; ?></th>
                                        <td><?php echo $email; ?></th>
                                        <td><?php echo $tel; ?></th>
                                        <?php if ($status == "reserved") { ?>
                                            <td style="background-color:lightgreen">Bestätigt</th>
                                        <?php } else if ($status == "new") { ?>
                                            <td style="background-color:lightblue">Offen</th>
                                        <?php } else if ($status == "cancelled") { ?>
                                            <td style="color:red">Storniert</th>
                                        <?php } else { ?>
                                            <td>Fehler</th>
                                        <?php } ?>

                                         <!-- Button trigger modal change status-->
                                         <td><button type="button" class="btn" style="background-color:#ffcc00" data-bs-toggle="modal" data-bs-target="#changeStatus<?php echo $reservationID; ?>">Status ändern</button></td>
                                    <!-- Modal Change Status -->
                                    <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="modal fade" id="changeStatus<?php echo $reservationID; ?>" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Buchungsstatus ändern</h5>
                                                            <input type="hidden" id="reservationIDstatus" name="reservationIDstatus" value="<?php echo $reservationID; ?>">
                                                        </div>
                                                        <div class="modal-body">                            
                                                            <select class="form-select" aria-label="Default select example" id="changeStatusSelect" name="changeStatusSelect">
                                                                <option selected>Status der Buchung mit der Buchungs-ID <?php echo $reservationID; ?> ändern.</option>
                                                                <option value="new">Offen</option>
                                                                <option value="reserved">Bestätigt</option>
                                                                <option value="cancelled">Storniert</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                            <button type="submit" name="changeStatus" id="changeStatus" class="btn btn-danger">Speichern</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>             
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

</body>

</html>