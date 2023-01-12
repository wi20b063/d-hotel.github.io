<?php
if (isset($_SESSION["role"]) && $_SESSION["role"] === "2") {

    include "navUser.php";

} elseif (isset($_SESSION["role"]) && $_SESSION["role"] === "1") {

    include "navAdmin.php";

} else {

    include "navGuest.php";
}


?>