<?php

include "session.php";

/* $_SESSION = array();

unset($_SESSION['userID']);
setcookie("userID", @$_POST["userID"], time() - 3600);
setcookie("username", @$_POST["username"], time() - 3600);
setcookie("password", @$_POST["password"], time() - 3600);
setcookie("logincookie", @$_POST["logincookie"], time() - 3600);
session_destroy();
header('Refresh: 1; URL=index.php'); */



// remove all session variables
session_unset();

// destroy the session
session_destroy();

//gehe zu Startseite
header('Refresh: 0; URL = ../index.php');

?>