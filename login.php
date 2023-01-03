<?php
    require (dirname(__FILE__,1) . "\components\session.php");

    $error = [];
    $error["username"] = false;
    $error["current-password"] = false;
    $error["save"] = false;
    

    if ((isset($_POST['submit'])) ) { //&& ($_SERVER["REQUEST_METHOD"] == "POST")
        if (empty($_POST["username"])) {
        $error["username"] = true;
    }
    if (empty($_POST["current-password"])) {
        $error["current-password"] = true;
    }
    if (isset($_POST["save"])) {
        $error["save"] = true;
    }
    if ((!empty($_POST["username"])) && (!empty($_POST["current-password"]))) {
        $cookie_name = "username";
        $cookie_value = $_POST["username"];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day / secure, httponly

        // connect to database
        if (!$con) {
            die('Error connecting to login database: ' . mysqli_error($con)); 
        }
        //verify login data with database
        //first strip and clean the user input against SQL injections
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $_REQUEST['username']);

        $password = stripslashes($_REQUEST['current-password']);
        $password = mysqli_real_escape_string($con, $_REQUEST['current-password']);
       
        
         //run  the SQL query (in import)
            query_UserData($username, md5($password));
         
            header('Refresh: 0; URL = index.php');
            /* echo "<div class='row col-8'>
                <H1> SUCCESS....</H1>
                </div>"; */
            
        //}

     
    }
}

function query_UserData($username, $passwordhash)
{
    global $mysqli_tbl_login, $mysqli_tbl_u_profile, $con;
    $query = "SELECT * FROM ($mysqli_tbl_login t  JOIN $mysqli_tbl_u_profile u ON t.id=u.personID)  WHERE username= '$username' and t.password='" . $passwordhash . "'";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $rows = mysqli_num_rows($result);
    if ($rows == 1) { // if we have 1 row as result, the user login was successful
        // getting data into SESSION variable for later. 
        $row = mysqli_fetch_array($result);
        $_SESSION["role"] = $row["role"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["firstName"] = $row["firstName"];
        $_SESSION["lastName"] = $row["lastName"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["zipcode"] = $row["zipcode"];
        $_SESSION["city"] = $row["city"];
        $_SESSION["address"] = $row["address"];
        $_SESSION["address2"] = $row["address2"];
        $_SESSION["target_file"] = $row["target_file"];
        $_SESSION["password"] = $row["password"];
        $_SESSION["salutation"] = $row["salutation"];
        $_SESSION["tel"] = $row["tel"];
        $_SESSION["personID"] = $row["personID"];
        // additional variables for error&feedback messages used in profile.php, booking.php...
        $_SESSION["transactNotice"] = false;
        $_SESSION["transactInfoType"] = "";    //Info, Error or ""
        $_SESSION["transactFeedback"] = "";
    }
    else{
        echo "<div class='row col-8'>
            <H2> Username/Password is incorrect.</H2>
            </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include (dirname(__FILE__,1) . "\components\head.php");?>
    <title>Distant Hotel | Login</title>
</head>

<body>
    <nav>
        <?php include (dirname(__FILE__,1) . "\components\\navbar.php");?>
    </nav>

    <main>
        <div class="content">
            <div class="container">
                <h1 class="headline">Login</h1>
                <div class="row col-8">
                    <form class="data-form" action="login.php" method="post" autocomplete="on">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" autocomplete="username" placeholder="Username"
                                class="form-control">
                            <!--required-->
                            <?php if ($error["username"]) echo "<div>Please enter Username!</div>"?>
                        </div>

                        <div class="mb-3">
                            <label for="current-password" class="form-label">Passwort:</label>
                            <input type="password" id="current-password" name="current-password" placeholder="Passwort"
                                class="form-control">
                            <!--required-->
                            <?php if ($error["current-password"]) echo "<div>Please enter Password!</div>"?>
                        </div>

                        <div class="mb-3">
                            <input type="checkbox" id="save" name="save">
                            <label for="save">Username und Passwort merken</label>
                            <?php if ($error["save"]) echo "<div>Error</div>"?>
                        </div>

                        <button type="submit" name="submit" class="btn">Bestätigen</button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <footer>
        <?php include (dirname(__FILE__,1) . "\components\\footer.php");?>
    </footer>

</body>

</html>