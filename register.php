<?php

        include "components/session.php";

        //define variables and set to empty values
        $salutationErr = $firstNameErr = $lastNameErr = $emailErr = $usernameErr = $newPasswordErr = $newPasswordRepeatedErr = "";
        $salutation = $firstName = $lastName= $email= $username = $newPassword = $newPasswordRepeated =  ""; 

        if (isset($_POST['submit']) && ($_SERVER["REQUEST_METHOD"] == "POST") ){
            if (empty($_POST["anrede"])) {
              $salutationErr = "Anrede ist erforderlich";
            } else {
              $salutation = test_input($_POST["anrede"]);
            }            
            
            if (empty($_POST["firstName"])) {
              $firstNameErr = "Vorname ist erforderlich";
            } else {
              $firstName = test_input($_POST["firstName"]);
            }              

            if (empty($_POST["lastName"])) {
                $lastNameErr = "Nachname ist erforderlich";
            } else {
                $lastName = test_input($_POST["lastName"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "Email ist erforderlich";
              } else {
                $email = test_input($_POST["email"]);
              }

              //Username needs to be unique, check if it already exists in database
              if (empty($_POST["username"])) {
                $usernameErr = "Username ist erforderlich";
            } else {
                $username = test_input($_POST["username"]);
            }
          
            if (empty($_POST["new-password"])) {
              $newPasswordErr = "Passwort ist erforderlich";
            } else {
              $newPassword = test_input($_POST["new-password"]);
            }

            if (empty($_POST["new-passwordRepeated"])) {
                $newPasswordRepeatedErr = "Wiederholung Passwort ist erforderlich";
              } else {
                $newPasswordRepeated = test_input($_POST["new-passwordRepeated"]);
              }
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

          if (!empty($_POST["username"]) && !empty($_POST["new-password"]) && !empty($_POST["new-passwordRepeated"]) && (($_POST["new-password"]) === ($_POST["new-passwordRepeated"]))) {
            $cookie_name = "username";
            $cookie_value = $_POST["username"];
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day / secure, httponly
    
            $_SESSION["username"] = $_POST["username"];
            
            header('Refresh: 0; URL = index.php');
        }
          ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | Über uns</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

        <!--Autocomplete Empfehlung von mozilla eingebaut-->

        <div class="content">
            <div class="container form-element">
                <div class="row col-8">
                    <h1 class="headline">Reservierungsformular</h2>
                        <form class="data-form" method="post" autocomplete="on"
                            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

                            <div class="mb-3">
                                Anrede: *<br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" id="male">
                                    <label class="form-check-label" for="male">
                                        Herr
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" id="female" checked>
                                    <label class="form-check-label" for="female">
                                        Frau
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="salutation" id="neutral" checked>
                                    <label class="form-check-label" for="neutral">
                                        Neutrale Anrede
                                    </label>
                                </div>
                                <span style="color:red; font-size:small"><?php echo $salutationErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="firstName" class="form-label">Vorname: *</label>
                                <input type="text" id="firstName" name="firstName" class="form-control" autocomplete="given-name" placeholder="Vorname">
                                <span style="color:red; font-size:small"><?php echo $firstNameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="lastName" class="form-label">Nachname: *</label>
                                <input type="text" id="lastName" name="lastName" class="form-control" autocomplete="family-name" placeholder="Nachname">
                                <span style="color:red; font-size:small"><?php echo $lastNameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="mail" class="form-label">E-Mail: *</label>
                                <input type="email" id="mail" name="mail" class="form-control" autocomplete="off" placeholder="E-Mail-Adresse">
                                <span style="color:red; font-size:small"><?php echo $emailErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username: *</label>
                                <input type="text" id="username" name="username" class="form-control" autocomplete="username" placeholder="Username">
                                <span style="color:red; font-size:small"> <?php echo $usernameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="new-password" class="form-label">Passwort: *</label>
                                <input type="password" id="new-password" name="new-password" class="form-control" autocomplete="new-password" placeholder="Neues Passwort"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span style="color:red; font-size:small"><?php echo $newPasswordErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="new-passwordRepeated" class="form-label">Wiederholung Passwort: *</label>
                                <input type="password" id="new-passwordRepeated" name="new-passwordRepeated" class="form-control" autocomplete="new-password" placeholder="Neues Passwort Wiederholung"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span style="color:red; font-size:small"><?php echo $newPasswordRepeatedErr;?></span>
                            </div>

                            <p  style="font-size:small; margin-top:20px;">* Pflichtfelder</p>


                            <button type="submit" name="submit" class="btn">Zurücksetzen</button>
                            <button type="submit" name="submit" class="btn">Absenden</button>

                        </form>
                </div>
            </div>
        </div>

    </main>

    <footer>
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>