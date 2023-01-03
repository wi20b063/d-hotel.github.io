<?php
if (isset($_SESSION["role"]) && $_SESSION["role"] === "0") {

    include "navUser.php";

} elseif (isset($_SESSION["role"]) && $_SESSION["role"] === "1") {

    include "navAdmin.php";

} else {

    include "navGuest.php";
}


?>