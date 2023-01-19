<?php
@session_start();
require(dirname(__FILE__, 2) . "\config\dbaccess.php");
require(dirname(__FILE__, 1) . "\inputValidation.php");

$error["email"] = false;
$newsletterSubscribeMsg = "";

if (isset($_POST["email"])) {
    if (empty($_POST["email"])) {
        $error["email"] = true;
        $newsletterSubscribeMsg = "Keine email Adresse angegeben";
    } else {
        if (emailValidation($_POST["email"])) {
            // valid email. now try to insert address to DB
            $sqlIns = "INSERT INTO tbl_newsletter_address (email) 
            VALUES (?)";
            $stmtIns = $con->prepare($sqlIns);
            $stmtIns->bind_param("s", $_POST["email"]);

            $stmtIns->execute();
            $result = mysqli_stmt_affected_rows($stmtIns);

            if ($result == 1) {
                //insert success
                $newsletterSubscribeMsg = "Vielen Dank für, der nächste Newsletter kommt auch zu Ihnen...";
            } else { //insert failed
                $newsletterSubscribeMsg = "Feher in Datenbank update. Bitte später nochmals versuchen";
                $error["email"] = true;
            }
        } else {
            $error["email"] = true;
            $newsletterSubscribeMsg = "Ungültige email-Adresse angegeben";
        }
    }
    echo '<script>alert("' . $newsletterSubscribeMsg . '");</script>';
}


?>
<!--Stylesheet-->
<link rel="stylesheet" type="text/css" href="res/css/mystyle.css">

<!-- class fixed-bottom or sticky-botton should make footer
stick to the bottom regardless of the lenght of the content -->

<!-- footer mt-auto py-3 bg-light -->

<div class="footer mt-auto">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="address">
                        <h4>KONTAKT</h4>
                        <p class="mb-3 mt-3">
                        <p> Traumstraße 1
                            <br>
                            1010 Wien | Österreich
                            <br>
                        </p>
                        <p>
                            <strong>Tel./Fax:</strong> +43 21234567
                            <br>
                            <strong>Email:</strong>
                            <a href="mailto:office@distant-hotel.at">office@distant-hotel.at</a>
                        </p>
                        </p>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6 footer-menus mt-4">
                    <ul>
                        <li> <a href="aboutus.php">ÜBER UNS</a></li>

                    </ul>
                </div>

                <div class="col-lg-3 col-sm-6 footer-menus mt-4">
                    <ul>
                        <li>
                            <a href="https://www.oesterreich.gv.at/themen/dokumente_und_recht/datenschutz.html"
                                target="_blank">DATENSCHUTZ</a>
                        </li>
                        <li>
                            <a href="imprint.php">IMPRESSUM</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-sm-6 newsletter">
                    <h4>NEWSLETTER</h4>
                    <form action="" method="post">
                        <input type="email" name="email">
                        <input type="submit" value="FOLGE UNS!" style="font-size:14px; font-weight:500;">
                    </form>
                    <br>
                    <div class="social-links mt-3">
                        <a href="https://www.instagram.com" class="btn btn-social-icon btn-instagram" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                        <a href="https://twitter.com" class="btn btn-social-icon btn-twitter" target="_blank"><i
                                class="fa fa-twitter"></i></a>
                        <a href="https://www.youtube.com" class="btn btn-social-icon btn-youtube" target="_blank"><i
                                class="fa fa-youtube"></i></a>
                        <a href="https://www.facebook.com/" class="btn btn-social-icon btn-facebook" target="_blank"><i
                                class="fa fa-facebook"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="footer-bottom">
        <div class="row">
            <p class="text-center mb-2">&copy; Copyright <strong>2023 Distant Hotel GmbH</strong></p>
        </div>
    </div>
</div>