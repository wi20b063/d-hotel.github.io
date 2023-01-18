<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");
    
    function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = mysqli_real_escape_string($conn, $data);
    return $data; }
    
    $passwordErr = $passwordRepeatedErr = $msg = "";    

    if (!$con) {
        die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
    }

    // Check if valid user is logged in
    if (!isset($_SESSION["username"])) {
        $msg = "Bitte einloggen um das Passwort neu zu vergeben!";
        exit();
    }
    if ($_SESSION["role"] != "1") {
        $msg = "Sie haben keine Berechtigung das Passwort neu zu vergeben!";
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
    
    $sqlSelectLogin = "SELECT * FROM $mysqli_tbl_login WHERE ID = $id";
    /* $stmtPassword = $con->prepare($sqlSelectLogin);
    $personID = $_GET["personID"];
    $stmtPassword -> bind_param("i", $personID);
    $stmtPassword -> execute();
    $stmtPassword -> bind_result($ID, $username, $password, $status); */

    $result = $con->query($sqlSelectLogin);
    while ($row = $result->fetch_assoc()) {
        $username = $row["username"];
    }

    // SETTING NEW DATA

    $readyForSubmit = true;

    if (isset($_POST['submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

        // combined generic Validations (isempty, errorMsgs, open for expansion)
        $readyForSubmit = $readyForSubmit & genericValidation($passwordErr, $_POST["password"]);
        $readyForSubmit = $readyForSubmit & genericValidation($passwordRepeatedErr, $_POST["passwordRepeated"]);

        if($readyForSubmit){
            $password = test_input($_POST["password"]);
        }

        //Additional validation: Passwords equal, Username needs to be unique (check if it already exists in database)
        $readyForSubmit = $readyForSubmit & pwd_equalValidation($_POST["password"], $_POST["passwordRepeated"], $passwordRepeatedErr);

        /* if ($_POST["password"] != $_POST["passwordRepeated"]) {
            $passwordRepeatedErr = "Passwörter stimmen nicht überein.";
            $readyForSubmit = false;
        } */

        $password = mysqli_real_escape_string($con, $_POST["password"]);

        if ($readyForSubmit == true) {

            // get the data from the form
            $password = $_POST["password"];

            // Submit to database SQL Statemnt for prepared statements
            $sqlNewPassword = "UPDATE $mysqli_tbl_login SET password = ? WHERE ID = ?";
            $stmtPassword = $con->prepare($sqlNewPassword);
            $passwordHash = md5($password); // changed to md5() as in DB, login and profile updatePW. its less secure than
                                            //password_hash but should be sufficient.
            $stmtPassword -> bind_param("si", $passwordHash, $id);
            $stmtPassword -> execute();            
            
            $msg = "Passwort wurde erfolgreich aktualisiert!";
            header("Refresh: 3; url=userList.php");

        } else {
            $msg = "Passwort konnte nicht aktualisiert werden!";
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
                            <h1 class="headline">Passwort von "<?php echo $username; ?>"</h1>
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
                                            <!-- Password -->
                                            <div class="col-md-6">
                                                <p><label for="password" class="form-label"><strong>Passwort: *</strong></label></p>
                                                <p><input type="password" id="password" name="password" class="form-control" placeholder="Passwort"
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten"></p>
                                                <span style="color:red; font-size:small"><?php echo $passwordErr; ?></span>
                                            </div>

                                        </div>

                                        <div class="row g-3">
                                            <!-- Password Repeated -->
                                            <div class="col-md-6">
                                                <p><label for="passwordRepeated" class="form-label"><strong>Wiederholung Passwort: *</strong></label></p>
                                                <p><input type="password" id="passwordRepeated" name="passwordRepeated" class="form-control" placeholder="Passwort Wiederholung"
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten"></p>
                                                <span style="color:red; font-size:small"><?php echo $passwordRepeatedErr; ?></span>
                                            </div>                                            
                                        </div>

                                        <div><p style="font-size:small; margin-top:20px;">* Pflichtfelder</p></div>

                                        <div  class="row g-3">
                                            <!-- Buttons -->
                                            <div class="col-md-6">
                                                <button type="submit" name="submit" class="btn btn-blue">Speichern</button>
                                                <a href="./userList.php" class="btn btn-grey">Abbrechen</a>
                                                <!-- <button type="reset" name="reset" class="btn btn-primary">Abbrechen</button> -->
                                            </div>
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