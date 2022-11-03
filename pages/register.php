<!---können noch Placeholder überlegen einzusezten-->
        <!--bei name autocomplete empfehlung der browser verwenden-->
        <form action="/action_page.php" method="post" target="_blank">
            <p>
                <strong>Anrede:</strong>
            </p>
            <input type="radio" id="frau" name="anrede" value="frau" required>
            <label for="frau">Frau</label><br>

            <input type="radio" id="herr" name="anrede" value="herr">
            <label for="herr">Herr</label><br>

            <input type="radio" id="neutral" name="anrede" value="neutral">
            <label for="neutral">Neutrale Anrede</label><br><br>

            <label for="fname">Vorname:</label>
            <input type="text" id="fname" name="fname" required><br><br>
            <label for="lname">Nachname:</label>
            <input type="text" id="lname" name="lname" required><br><br>
            <label for="mail">E-Mail:</label>
            <input type="email" id="mail" name="mail" required><br><br>

            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" required><br><br>
            <label for="pw">Passwort:</label>
            <input type="password" id="pw" name="pw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten"
                required><br><br>
            <label for="pw2">Wiederholung Passwort:</label>
            <input type="password" id="pw2" name="pw2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                title="Muss mindestens eine Zahl und einen Groß- und Kleinbuchstaben sowie mindestens 8 oder mehr Zeichen enthalten"
                required><br><br>

            <button type="reset">Zurücksetzen</button>
            <button type="submit">Asenden</button>
        </form>