<?php
require(dirname(__FILE__, 1) . "\components\session.php");

$error = []; //declaring an array to store the error messages
$error["username"] = false; //making sure the error message is not shown at the beginning (in case of a previous error - defensive programming)
$error["current-password"] = false;
$error["save"] = false;

//the following code is executed when the user clicks on the submit button
if ((isset($_POST['submit']))) { //&& ($_SERVER["REQUEST_METHOD"] == "POST")
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
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day / secure, http only

        // connect to database
        if (!$con) {
            die('Error connecting to login database: ' . mysqli_error($con));
        }
        //verify login data with database
        //first strip and clean the user input (maybe not needed with perpared statement)
        $username = mysqli_real_escape_string($con, $_REQUEST['username']);
        $password = mysqli_real_escape_string($con, $_REQUEST['current-password']);


        //run  the SQL query (in import) but already hash the password
        query_UserData($username, md5($password));

        header('Refresh: 0; URL = index.php');
        /* echo "<div class='row col-8'>
        <H1> SUCCESS....</H1>
        </div>"; */

        //}


    }
}

//function to query the database for user data & write it into SESSION variables
function query_UserData($username, $passwordhash)
{

    //global variables needed for DB access - they are defined already but we need to 
    //declare them again as global variables to be able to use them in this function
    global $mysqli_tbl_login, $mysqli_tbl_u_profile, $con;
    //building the s SQL query with prepared sqli statement
    $sqlLogin = "SELECT * FROM $mysqli_tbl_login   WHERE username= ? AND password= ?";
    $stmt = $con->prepare($sqlLogin);
    $stmt->bind_param("ss", $username, $passwordhash);
    $stmt->execute();

    $result = mysqli_stmt_get_result($stmt); // returns a result-Set

    if ($result->num_rows == 1) { // if we have 1 row as result, the user login was successful
        // getting data into SESSION variable for later. 
        $row = mysqli_fetch_assoc($result);
        $_SESSION["role"] = $row["role"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["password"] = $row["password"];
        $_SESSION["personID"] = $row["ID"];
    } else {
        //the user login was not successful, the username was not found in the database or the password was wrong
        echo "<div class='row col-8'>
            <H2> Username/Password is incorrect.</H2>
            </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- dirname(__FILE__,1) returns the path of the parent directory in case the relative path doesn't work 
    properly-->
    <?php include(dirname(__FILE__, 1) . "\components\head.php"); ?>
    <title>Distant Hotel | Login</title>
</head>

<body>
    <nav>
        <?php include(dirname(__FILE__, 1) . "\components\\navbar.php"); ?>
    </nav>

    <main>
        <div class="content">
            <div class="container">
                <h1 class="headline">Login</h1>
                <div class="row col-8">
                    <form class="data-form" action="login.php" method="post" autocomplete="on">

                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" name="username" autocomplete="username"
                                placeholder="Username" class="form-control">
                            <!--required-->
                            <!--error message if username is empty after clicking on the submit-->
                            <!--the text in the following echo is inserted into the html code rihgt after checking if 
                        the username empty is true-->
                            <?php if ($error["username"])
                                echo "<div>Please enter Username!</div>" ?>
                            </div>

                            <div class="mb-3">
                                <label for="current-password" class="form-label">Passwort:</label>
                                <input type="password" id="current-password" name="current-password" placeholder="Passwort"
                                    class="form-control">
                                <!--required-->
                            <?php if ($error["current-password"])
                                echo "<div>Please enter Password!</div>" ?>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox" id="save" name="save">
                                <label for="save">Username und Passwort merken</label>
                            <?php if ($error["save"])
                                echo "<div>Error</div>" ?>
                            </div>

                            <button type="submit" name="submit" class="btn">Bestätigen</button>
                        </form>
                    </div>
                </div>
            </div>

        </main>

        <footer>
        <?php include(dirname(__FILE__, 1) . "\components\\footer.php"); ?>
    </footer>

</body>

</html>