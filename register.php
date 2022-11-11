<?php

        //define variables and set to empty values

        $anredeErr = $fnameErr = $lnameErr = $mailErr = $unameErr = $pwErr = $pw2Err = "";

        $anrede = $fname = $lname= $mail= $uname = $pw= $pw2 =  ""; 

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["anrede"])) {
              $anredeErr = "anrede ist erforderlich";
            } else {
              $anrede = test_input($_POST["anrede"]);
            }
            
            
            if (empty($_POST["fname"])) {
              $fnameErr = "Vorname ist erforderlich";
            } else {
              $fname = test_input($_POST["fname"]);
            }
              

            if (empty($_POST["lname"])) {
                $lnameErr = "Nachname ist erforderlich";
            } else {
                $lname = test_input($_POST["lname"]);
            }

            if (empty($_POST["email"])) {
                $mailErr = "Email ist erforderlich";
              } else {
                $mail = test_input($_POST["email"]);
              }

              if (empty($_POST["uname"])) {
                $lnameErr = "Username ist erforderlich";
            } else {
                $uname = test_input($_POST["uname"]);
            }
          
            if (empty($_POST["pw"])) {
              $pwErr = "Passwort ist erforderlich";
            } else {
              $pw = test_input($_POST["pw"]);
            }

            if (empty($_POST["pw2"])) {
                $pw2Err = "Wiederholung Passwort ist erforderlich";
              } else {
                $pw2 = test_input($_POST["pw2"]);
              }
          }

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
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

        <!---können noch Placeholder überlegen einzusezten-->
        <!--bei name autocomplete empfehlung der browser verwenden-->

        <div class="content">
            <div class="container form-element">
                <div class="row col-8">
                    <h1>Reservierungsformular</h2>
                        <form class="data-form" method="post"
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
                                <span class="error"> <?php echo $anredeErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="fname" class="form-label">Vorname:</label>
                                <input type="text" id="fname" name="fname" class="form-control">
                                <span class="error">* <?php echo $fnameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="lname" class="form-label">Nachname:</label>
                                <input type="text" id="lname" name="lname" class="form-control">
                                <span class="error">* <?php echo $lnameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="mail" class="form-label">E-Mail:</label>
                                <input type="email" id="mail" name="mail" class="form-control">
                                <span class="error">* <?php echo $mailErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="uname" class="form-label">Username:</label>
                                <input type="text" id="uname" name="uname" class="form-control">
                                <span class="error">* <?php echo $unameErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="pw" class="form-label">Passwort:</label>
                                <input type="password" id="pw" name="pw" class="form-control"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span class="error">* <?php echo $pwErr;?></span>
                            </div>

                            <div class="mb-3">
                                <label for="pw2" class="form-label">Wiederholung Passwort:</label>
                                <input type="password" id="pw2" name="pw2" class="form-control"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                    title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
                                <span class="error">* <?php echo $pw2Err;?></span>
                            </div>

                            <button type="reset" class="btn">Zurücksetzen</button>
                            <button type="submit" class="btn">Absenden</button>
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