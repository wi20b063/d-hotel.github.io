<?php
    if (isset($_SESSION["username"])) {
        
        include "navUser.php";

    } else {
        
        include "navGuest.php";
        
    }
?>