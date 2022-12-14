<?php

require(dirname(__FILE__, 1) . "\components\session.php");
require(dirname(__FILE__, 1) . "\config\dbaccess.php");
require(dirname(__FILE__, 1) . "\components\inputValidation.php");

//define variables and set to empty values
$salutationErr = $firstNameErr = $lastNameErr = $emailErr = $usernameErr = $newPasswordErr = $newPasswordRepeatedErr = "";
$salutation = $firstName = $lastName = $email = $username = $newPassword = $newPasswordRepeated = "";

$readyForSubmit = true;

if (isset($_POST['submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    // combined generic Validations (isempty, errorMsgs, open for expansion)
    $readyForSubmit = $readyForSubmit & genericValidation($usernameErr,$_POST["username"]);
    $readyForSubmit = $readyForSubmit & genericValidation($salutationErr,$_POST["salutation"]);
    $readyForSubmit = $readyForSubmit & genericValidation($firstNameErr,$_POST["firstName"]);
    $readyForSubmit = $readyForSubmit & genericValidation($lastNameErr,$_POST["lastName"]);
    $readyForSubmit = $readyForSubmit & genericValidation($emailErr,$_POST["mail"]);
    $readyForSubmit = $readyForSubmit & genericValidation($newPasswordErr,$_POST["new-password"]);
    $readyForSubmit = $readyForSubmit & genericValidation($newPasswordRepeatedErr,$_POST["new-passwordRepeated"]);

    if($readyForSubmit){
        $username = test_input($_POST["username"]);
        $newPassword = test_input($_POST["new-password"]);
        $salutation = test_input($_POST["salutation"]);
        $firstName = test_input($_POST["firstName"]);
        $lastName = test_input($_POST["lastName"]);
        $email = test_input($_POST["mail"]);
    }

    //Additional validation: Passwords equal, Username needs to be unique (check if it already exists in database)
    $readyForSubmit = $readyForSubmit & pwd_equalValidation($_POST["new-password"], $_POST["new-passwordRepeated"], $newPasswordRepeatedErr);
    
    if ($readyForSubmit == true) {
        // submit finally to DB... (and call Profile??)

        if (!$con) {
            die('Error connecting to login database: ' . mysqli_error($con));
        }
        $salutation = mysqli_real_escape_string($con, $salutation);
        $firstName = mysqli_real_escape_string($con, $firstName);
        $lastName = mysqli_real_escape_string($con, $lastName);
        $username = mysqli_real_escape_string($con, $username);
        $newPassword = mysqli_real_escape_string($con, $newPassword);
        $email = mysqli_real_escape_string($con, $email);


        //build the SQL query. first check if userName exists already
        $query = "SELECT * FROM $mysqli_tbl_login   WHERE username= '$username' ";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));

        $rows = mysqli_num_rows($result);
        if ($rows == 0) {
            $query = "INSERT INTO $mysqli_tbl_login (username, password) VALUES ('$username', '" . md5($newPassword) . "')";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            if ($result >0) { // insert into user_login_table was successful, now we need to add the remaining info into user_profile table, 
                //including the foreign key of the  user_login_table PK getting it via $lastID...
                $lastID = mysqli_insert_id($con);
                $query = "INSERT INTO $mysqli_tbl_u_profile (firstName, lastName, email, salutation, personID) VALUES 
                ('$firstName', '$lastName', '$email', '$salutation', '$lastID')";
                $result = mysqli_query($con, $query) or die(mysqli_error($con));
                if ($result >0) {
                    //success
                    header('Refresh: 3; URL = login.php');
                    echo "<div class='row col-8'>
                    <H2> Successfully created profile, please log in...</H2>
                    </div>";
                    
                } else {
                    echo "<div class='row col-8'>
                    <H2> Something went terribly wrong while creating your Profile...</H2>
                    </div>";
                }
            }
        }


    } else {
        // user exists already, cancel
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    //$data = mysqli_real_escape_string($conn, $data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php"; ?>
    <title>Distant Hotel | ??ber uns</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php"; ?>
    </nav>

    <main>

        <!--Autocomplete Empfehlung von mozilla eingebaut-->

        <div class="content">
            <div class="container form-element">
                <div class="row col-8">
                    <h1 class="headline">Registrierungsformular</h2>
                        <form class="data-form" method="post" autocomplete="on"
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                            <div class="mb-3">
                                Anrede: *<br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" value="male"
                                        id="male">
                                    <label class="form-check-label" for="male">
                                        Herr
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" value="female"
                                        id="female" checked>
                                    <label class="form-check-label" for="female">
                                        Frau
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" value="neutral"
                                        id="neutral" checked>
                                    <label class="form-check-label" for="neutral">
                                        Neutrale Anrede
                                    </label>
                                </div>
                                <span style="color:red; font-size:small">
                                    <?php echo $salutationErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="firstName" class="form-label">Vorname: *</label>
                                <input type="text" id="firstName" name="firstName" class="form-control"
                                    autocomplete="given-name" placeholder="Vorname">
                                <span style="color:red; font-size:small">
                                    <?php echo $firstNameErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="lastName" class="form-label">Nachname: *</label>
                                <input type="text" id="lastName" name="lastName" class="form-control"
                                    autocomplete="family-name" placeholder="Nachname">
                                <span style="color:red; font-size:small">
                                    <?php echo $lastNameErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="mail" class="form-label">E-Mail: *</label>
                                <input type="email" id="mail" name="mail" class="form-control" autocomplete="off"
                                    placeholder="E-Mail-Adresse">
                                <span style="color:red; font-size:small">
                                    <?php echo $emailErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username: *</label>
                                <input type="text" id="username" name="username" class="form-control"
                                    autocomplete="username" placeholder="Username">
                                <span style="color:red; font-size:small">
                                    <?php echo $usernameErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="new-password" class="form-label">Passwort: *</label>
                                <input type="password" id="new-password" name="new-password" class="form-control"
                                    autocomplete="new-password" placeholder="Neues Passwort"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Gro??- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span style="color:red; font-size:small">
                                    <?php echo $newPasswordErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="new-passwordRepeated" class="form-label">Wiederholung Passwort: *</label>
                                <input type="password" id="new-passwordRepeated" name="new-passwordRepeated"
                                    class="form-control" autocomplete="new-password"
                                    placeholder="Neues Passwort Wiederholung"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Gro??- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span style="color:red; font-size:small">
                                    <?php echo $newPasswordRepeatedErr; ?>
                                </span>
                            </div>

                            <p style="font-size:small; margin-top:20px;">* Pflichtfelder</p>


                            <button type="reset" name="reset" class="btn">Zur??cksetzen</button>
                            <button type="submit" name="submit" class="btn">Absenden</button>

                        </form>
                </div>
            </div>
        </div>

    </main>

    <footer>
        <?php include "components/footer.php"; ?>
    </footer>

</body>

</html>