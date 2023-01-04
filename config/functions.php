<?php

require(dirname(__FILE__, 1) . "\components\session.php");
require(dirname(__FILE__, 1) . "\config\dbaccess.php");



function getDbConnection () {

    $con = mysqli_connect($mysqli_sname, $mysqli_uname, $mysqli_password, $mysqli_database);
    if(!$con){
        echo "Datenbankverbindung fehlgeschlagen!";
        exit();
    }
    //echo "db connection open<br>";
    return $con;
}



?>