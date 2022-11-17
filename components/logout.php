<?php

include "session.php";

// remove all session variables
session_unset();

// destroy the session
session_destroy();

//gehe zu Startseite
header('Refresh: 0; URL = ../index.php');

?>