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
        
    // If tbl_u_profile is empty, display "No news users yet." in red font
    $sqlSelectUser = "SELECT * FROM $mysqli_tbl_u_profile";
    $result = mysqli_query($con, $sqlSelectUser);
    if (mysqli_num_rows($result) == 0) {
        $msg = "Keine User vorhanden."; }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | News Erstellung</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

    <div class="content">
            <div class="container">
                <h1 class="headline">Übersicht aller User</h1>
                
                <form method="POST" enctype="multipart/form-data">

                    <div class="row g-3">
                        <div class="col-md-6 mb-4" style="background-color:lightgrey"><?php echo $msg; ?></div>
                    </div>

                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col-sm-1">Person-ID</th>
                                    <th scope="col-sm-1">Anrede</th>
                                    <th scope="col-sm-1">Vorname</th>
                                    <th scope="col-sm-1">Nachname</th>
                                    <th scope="col-sm-1">Straße</th>
                                    <th scope="col-sm-1">Hausnummer</th>
                                    <th scope="col-sm-1">PLZ</th>
                                    <th scope="col-sm-1">Ort</th>
                                    <th scope="col-sm-1">E-Mail</th>
                                    <th scope="col-sm-1">Telefon</th>
                                    <th scope="col-sm-1">Rolle</th>
                                    <th scope="col-sm-1">Profilbild</th>
                                    <th scope="col-sm-1">Status</th>
                                    <th scope="col-sm-1">Passwort</th>
                                    <th scope="col-sm-1">Profil</th>
                                </tr>
                            </thead>

                            <?php                                  

                            // Link each uploaded file. Hint: keep in mind to use the correct path!

                            // Get all data from tbl_news
                            $sqlSelectUser = "SELECT * FROM $mysqli_tbl_u_profile";
                            $result = $con->query($sqlSelectUser);
                            while ($row = $result->fetch_assoc()) {
                                $personID = $row["personID"];
                                $salutation = $row["salutation"];
                                $firstname = $row["firstName"];
                                $lastname = $row["lastName"];
                                $street = $row["address"];
                                $housenumber = $row["address2"];
                                $zip = $row["zipcode"];
                                $city = $row["city"];
                                $email = $row["email"];
                                $tel = $row["tel"];
                                $role = $row["role"];
                                // Get status from tbl_login
                                $sqlSelectPerson = "SELECT * FROM $mysqli_tbl_login WHERE ID = $personID";
                                $resultPerson = $con->query($sqlSelectPerson);
                                while ($rowPerson = $resultPerson->fetch_assoc()) {
                                    $status = $rowPerson["active"];
                                }
                                $profileImg = $row["target_file"];?>

                                    <tbody>
                                        <tr>
                                            <td scope="row"><?php echo $personID; ?></th>
                                            <td><?php echo $salutation; ?></th>
                                            <td><?php echo $firstname; ?></th>
                                            <td><?php echo $lastname; ?></th>
                                            <td><?php echo $street; ?></th>
                                            <td><?php echo $housenumber; ?></th>
                                            <td><?php echo $zip; ?></th>
                                            <td><?php echo $city; ?></th>
                                            <td><?php echo $email; ?></th>
                                            <td><?php echo $tel; ?></th>
                                            <?php if ($role == 1) { ?>
                                                <td>Admin</th>
                                            <?php } else { ?>
                                                <td>User</th>
                                            <?php } ?>
                                            <?php if ($profileImg == "") { ?>
                                                <td><a style="color:lightgrey">Profilbild anzeigen</a></th>
                                            <?php } else { ?>
                                                <td><a href="./res/img/img profile/<?php echo $profileImg; ?>" target="_blank">Profilbild anzeigen</a></th>
                                            <?php } ?>
                                            <?php if ($status == 1) { ?>
                                                <td><span style="color:green">Aktiv</span></th>
                                            <?php } else { ?>
                                                <td><span style="color:red">Inaktiv</span></th>
                                            <?php } ?>
                                            <td><a href="./passwordEditAdmin.php?personID=<?php echo $personID; ?>">Neues Passwort</a></th>
                                            <td><a href="./profileEditAdmin.php?personID=<?php echo $personID; ?>">Profil bearbeiten</a></th>
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