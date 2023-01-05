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
                                    <th scope="col-sm-1">Raum-ID</th>
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
                                $roomID = $row["ROOMID"];
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
                                        <td><?php echo $roomID; ?></th>
                                        <td><?php echo $price; ?></th>
                                        <td><?php echo $arrivalDate; ?></th>
                                        <td><?php echo $departureDate; ?></th>
                                        <td><?php echo $remark; ?></th>
                                        <td><?php echo $firstname; ?></th>
                                        <td><?php echo $lastname; ?></th>
                                        <td><?php echo $email; ?></th>
                                        <td><?php echo $tel; ?></th>
                                        <?php if ($status == 1) { ?>
                                            <td style="color:green">Bestätigt</th>
                                        <?php } else { ?>
                                            <td style="color:red">Offen</th>
                                        <?php } ?>

                                        <td><a href="./#.php?personID=<?php echo $reservationID; ?>">Status ändern</a></th>
                                        <td><a href="./#.php?personID=<?php echo $reservationID; ?>">Buchung löschen</a></th>
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