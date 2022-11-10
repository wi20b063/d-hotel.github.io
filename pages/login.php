<?php
    // echo "<pre>"; print_r($_SERVER); "</pre>";
    // echo "<pre>"; print_r($_POST); "</pre>";
    // echo $_POST["username"];

    $error = [];
    $error["username"] = false;
    $error["current-password"] = false;
    $error["save"] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $error["username"] = true;
    }
    if (empty($_POST["current-password"])) {
        $error["current-password"] = true;
    }
    if (isset($_POST["save"])) {
        $error["save"] = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distant Hotel | Login</title>
</head>

<body>
    <div class="login col-?">
        <form action="" method="post" target="_blank">
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username">
                <!--required-->
                <?php if ($error["username"]) echo "<div>Error</div>"?>
            </div>
            <div>
                <label for="current-password">Passwort</label>
                <input type="text" id="current-password" name="current-password" placeholder="Passwort">
                <!--required-->
                <?php if ($error["current-password"]) echo "<div>Error</div>"?>
            </div>
            <div>
                <input type="checkbox" id="save" name="save">
                <label for="save">Username und Passwort merken</label>
                <?php if ($error["save"]) echo "<div>Error</div>"?>
            </div>
            <button type="submit">Bestätigen</button>
        </form>
    </div>

</body>

</html>