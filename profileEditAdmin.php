<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");

    if (!$con) {
        die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
    }

    $firstNameErr = $lastNameErr = $emailErr = $roleErr = $usernameErr = $statusErr = $msg = "";


    // Check if valid user is logged in
    if (!isset($_SESSION["username"])) {
        $msg = "Bitte einloggen um die Daten zu ändern!";
        exit();
    }
    if ($_SESSION["role"] != "1") {
        $msg = "Sie haben keine Berechtigung die Daten zu ändern!";
        exit();
    }
    
    // Check if session is expired.
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        $msg = "Session ist abgelaufen. Bitte neu einloggen!";
        exit();
    }


    // GETTING DATA FROM DATABASE

    $id = $_GET["personID"];
    $sqlSelectProfile = "SELECT * FROM $mysqli_tbl_u_profile WHERE personID = $id";
    /* $stmtProfile = $con->prepare($sqlSelectProfile);
    $stmtProfile -> bind_param("i", $personID);
    $personID = $_GET["personID"];
    $stmtProfile -> execute();
    $stmtProfile -> bind_result($personID, $role, $firstName, $lastName, $email, $zipcode, $city, $street, $housenumber, $phone, $salutation, $profileImg); */
    
    $result = $con->query($sqlSelectProfile);
    while ($row = $result->fetch_assoc()) {
        $personID = $row["personID"];
        $salutation = $row["salutation"];
        $firstName = $row["firstName"];
        $lastName = $row["lastName"];
        $street = $row["address"];
        $housenumber = $row["address2"];
        $zipcode = $row["zipcode"];
        $city = $row["city"];
        $email = $row["email"];
        $phone = $row["tel"];
        // $role = $row["role"]; moved in DB. Could also combine the 2 queries into 1 using same JOIN as in userList.php
        $profileImg = $row["target_file"];
    }
    
    $sqlSelectLogin = "SELECT * FROM $mysqli_tbl_login WHERE ID = $id";
    /* $stmtLogin = $con->prepare($sqlSelectLogin);
    $personID = $_GET["personID"];
    $stmtLogin -> bind_param("i", $personID);
    $stmtLogin -> execute();
    $stmtLogin -> bind_result($ID, $username, $password, $status); */

    $result = $con->query($sqlSelectLogin);
    while ($row = $result->fetch_assoc()) {
        $ID = $row["ID"];
        $username = $row["username"];
        $password = $row["password"];
        $status = $row["active"];
        $role = $row["role"];
    }

    // SETTING NEW DATA

    $readyForSubmit = true;

    if (isset($_POST['submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

        // combined generic Validations (isempty, errorMsgs, open for expansion)
        $readyForSubmit = $readyForSubmit & genericValidation($firstNameErr, $_POST["firstName"]);
        $readyForSubmit = $readyForSubmit & genericValidation($lastNameErr, $_POST["lastName"]);
        $readyForSubmit = $readyForSubmit & genericValidation($emailErr, $_POST["email"]);
        // $readyForSubmit = $readyForSubmit & genericValidation($roleErr, $_POST["role"]);
        $readyForSubmit = $readyForSubmit & genericValidation($usernameErr, $_POST["username"]);
        $readyForSubmit = $readyForSubmit & genericValidation($statusErr, $_POST["status"]);

        if ($readyForSubmit == true) {

            // get the data from the form
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $street = $_POST["street"];
            $housenumber = $_POST["housenumber"];
            $zipcode = $_POST["zipcode"];
            $city = $_POST["city"];
            $phone = $_POST["phone"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            $username = $_POST["username"];
            $status = $_POST["status"];


            // Submit to database SQL Statemnt for prepared statements
            $sqlUpdateProfile = "UPDATE $mysqli_tbl_u_profile SET firstName = ?, lastName = ?, address = ?, address2 = ?, zipcode = ?, city = ?, tel = ?, email = ? WHERE personID = ?";
            $stmtProfile = $con->prepare($sqlUpdateProfile);
            $stmtProfile->bind_param("ssssssssi", $firstName, $lastName, $street, $housenumber, $zipcode, $city, $phone, $email, $id);
            $stmtProfile->execute();

            $sqlUpdateLogin = "UPDATE $mysqli_tbl_login SET username = ?, active = ? , role = ? WHERE ID = ?";
            $stmtLogin = $con->prepare($sqlUpdateLogin);
            $stmtLogin->bind_param("siii", $username, $status,  $role, $id);
            $stmtLogin->execute();
            
            $msg = "Eintrag wurde erfolgreich aktualisiert!";
            header("Refresh: 3; url=userList.php");

        } else {
            $msg = "Eintrag konnte nicht aktualisiert werden!";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

    <div class="content">
		<div class="container">
			
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">

                        <!-- Page title -->
                        <div class="my-5">
                            <h1 class="headline">Profil von <?php echo $username; ?> </h1>
                            <hr>
                        </div>

                        <!-- Form START -->
                        <div class="row mb-5 gx-5">

                            <div class="col-xxl-8 mb-5 mb-xxl-0">
                                <div class="bg-secondary-soft px-4 py-5 rounded">
                                    <form class="data-form" method="post" autocomplete="off">
                                    
                                        <div class="row g-3">
                                            <div class="col-md-6 mb-4" style="background-color:lightgrey"><?php echo $msg; ?></div>
                                        </div>
                                    
                                        <div class="row g-3">
                                            <h4 class="mb-4 mt-0">Kontaktdaten</h4>
                                            
                                            <!-- First Name -->
                                            <div class="col-md-6">
                                                <p><label for="firstName" class="form-label"><strong>Vorname: *</strong></label></p>
                                                <p><input type="text" id="firstName" name="firstName" class="form-control" value=<?php echo $firstName;?>></p>
                                                <span style="color:red; font-size:small"><?php echo $firstNameErr; ?></span>
                                            </div>

                                            <!-- Last name -->
                                            <div class="col-md-6">
                                                <p><label for="lastName" class="form-label"><strong>Nachname: *</strong></label></p>
                                                <p><input type="text" id="lastName" name="lastName" class="form-control" value=<?php echo $lastName; ?>></p>
                                                <span style="color:red; font-size:small"><?php echo $lastNameErr; ?></span>
                                            </div>

                                            <!-- Address -->
                                            <div class="col-md-6">
                                                <p><label for="street" class="form-label"><strong>Straße:</strong></label></p>
                                                <p><input type="text" id="street" name="street" class="form-control" value=<?php echo $street; ?>></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="housenumber" class="form-label"><strong>Hausnummer/Stiege/Tür:</strong></label></p>
                                                <p><input type="text" id="housenumber" name="housenumber" class="form-control" value=<?php echo $housenumber; ?>></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="zipcode" class="form-label"><strong>PLZ:</strong></label></p>
                                                <p><input type="text" id="zipcode" name="zipcode" class="form-control" value=<?php echo $zipcode; ?>></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="city" class="form-label"><strong>Stadt:</strong></label></p>
                                                <p><input type="text" id="city" name="city" class="form-control" value=<?php echo $city; ?>></p>
                                            </div>
                                            
                                            
                                            <!-- Contact details -->
                                            <div class="col-md-6">
                                                <p><label for="email" class="form-label"><strong>E-Mailadresse: *</strong></label></p>
                                                <p><input type="text" id="email" name="email" class="form-control" value=<?php echo $email; ?>></p>
                                                <span style="color:red; font-size:small"><?php echo $emailErr; ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="phone" class="form-label"><strong>Telefonnummer:</strong></label></p>
                                                <p><input type="text" id="phone" name="phone" class="form-control" value=<?php echo $phone; ?>></p>
                                            </div>

                                            <!-- User information -->
                                            <div class="col-md-6">
                                                <p><label for="username" class="form-label"><strong>Username: *</strong></label></p>
                                                <p><input type="text" id="username" name="username" class="form-control" value=<?php echo $username; ?>></p>
                                                <span style="color:red; font-size:small"><?php echo $usernameErr; ?></span>
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="role" class="form-label"><strong>Userrolle: *</strong> <small>(1 = Admin, 2 = User)</small></label></p>
                                                <p><input type="text" id="role" name="role" class="form-control" value=<?php echo $role; ?>></p>
                                                <!-- <span style="color:red; font-size:small"><?php echo $roleErr; ?></span> -->
                                            </div>
                                            <div class="col-md-6">
                                                <p><label for="status" class="form-label"><strong>Userstatus: *</strong> <small>(1 = aktiv, 0 = inaktiv)</small></label></p>
                                                    <?php if ($status == "1") { ?>
                                                        <p><input type="text" id="status" name="status" class="form-control" value=<?php echo $status; ?> style="background-color:#7CFC0090"></p>
                                                    <?php } else { ?>
                                                    <p><input type="text" id="status" name="status" class="form-control" value=<?php echo $status; ?> style="background-color:#D42A0490"></p>
                                                <?php } ?>
                                                <span style="color:red; font-size:small"><?php echo $statusErr; ?></span>
                                            </div>

                                            <!-- Buttons -->
                                            <div class="text-center">
                                                <button type="submit" name="submit" class="btn btn-blue">Speichern</button>
                                                <a href="./userList.php" class="btn btn-grey">Abbrechen</a>
                                            </div>

                                        </form>
                                    </div> <!-- Row END -->
                                </div>
                            </div>

                        </div> <!-- Row END -->

                        
                    
                    </form>
                    
                </div>
            </div>
            </form>

		</div>
		</div>


    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>