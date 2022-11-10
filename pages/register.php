<!---können noch Placeholder überlegen einzusezten-->
<!--bei name autocomplete empfehlung der browser verwenden-->

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

<h1>Reservierungsformular</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        Anrede: *<br>
        <input type="radio" id="frau" name="anrede" value="frau">
        <label for="frau">Frau</label><br>


        <input type="radio" id="herr" name="anrede" value="herr">
        <label for="herr">Herr</label><br>

        <input type="radio" id="neutral" name="anrede" value="neutral">
        <label for="neutral">Neutrale Anrede</label>

        <span class="error"> <?php echo $anredeErr;?></span><br><br>

        <label for="fname">Vorname:</label>
        <input type="text" id="fname" name="fname">
        <span class="error">* <?php echo $fnameErr;?></span><br><br>

        <label for="lname">Nachname:</label>
        <input type="text" id="lname" name="lname">
        <span class="error">* <?php echo $lnameErr;?></span><br><br>

        <label for="mail">E-Mail:</label>
        <input type="email" id="mail" name="mail">
        <span class="error">* <?php echo $mailErr;?></span><br><br>

        <label for="uname">Username:</label>
        <input type="text" id="uname" name="uname">
        <span class="error">* <?php echo $unameErr;?></span><br><br>

        <label for="pw">Passwort:</label>
        <input type="password" id="pw" name="pw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
        <span class="error">* <?php echo $pwErr;?></span><br><br>
        <label for="pw2">Wiederholung Passwort:</label>
        <input type="password" id="pw2" name="pw2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten">
        <span class="error">* <?php echo $pw2Err;?></span><br><br>

        <button type="reset">Zurücksetzen</button>
        <button type="submit">Asenden</button>
    </form>