<?php
//necessary for every session access
session_start();

require (dirname(__FILE__,2) . "\config\dbaccess.php");

// check if DB access is available
$con = mysqli_connect($mysqli_sname, $mysqli_uname, $mysqli_password, $mysqli_database);
if(!$con){
	echo "Datenbankverbindung fehlgeschlagen!";
	exit();
}
?>