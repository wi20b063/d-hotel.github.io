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
    <?php include "components/head.php";?>
    <title>Distant Hotel | Login</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>
        <div class="content">
            <div class="container">
                <div class="row col-8">
                    <form class="data-form" action="" method="post" target="_blank">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Username"
                                class="form-control">
                            <!--required-->
                            <?php if ($error["username"]) echo "<div>Error</div>"?>
                        </div>

                        <div class="mb-3">
                            <label for="current-password" class="form-label">Passwort:</label>
                            <input type="text" id="current-password" name="current-password" placeholder="Passwort"
                                class="form-control">
                            <!--required-->
                            <?php if ($error["current-password"]) echo "<div>Error</div>"?>
                        </div>

                        <div class="mb-3">
                            <input type="checkbox" id="save" name="save">
                            <label for="save">Username und Passwort merken</label>
                            <?php if ($error["save"]) echo "<div>Error</div>"?>
                        </div>

                        <button type="submit" class="btn">Bestätigen</button>
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