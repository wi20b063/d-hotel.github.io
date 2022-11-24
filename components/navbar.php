<?php
    if (!isset($_SESSION["username"])) {

        include "navGuest.php";
    
    } else if ($_SESSION["username"] === "testuser") {
        
        include "navUser.php";

    } else if ($_SESSION["username"] === "admin") {
        
        include "navAdmin.php";
        
    }
?>