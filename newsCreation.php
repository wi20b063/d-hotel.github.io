<?php

require(dirname(__FILE__, 1) . "\components\session.php");
require(dirname(__FILE__, 1) . "\config\dbaccess.php");
require(dirname(__FILE__, 1) . "\components\inputValidation.php");


//define variables and set to empty values
$headlineErr = $textErr = $newsImgErr = $msg = "";
$headline = $test = $personID = $newsImg = "";

// Check if valid user is logged in
if (!isset($_SESSION["username"])) {
    $msg = "Bitte einloggen um News Beiträge zu erstellen!";
    exit();
}
if ($_SESSION["role"] != "1") {
    $msg = "Sie haben keine Berechtigung News Beiträge zu erstellen!";
    exit();
}

// Check if session is expired.
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    $msg = "Session ist abgelaufen. Bitte neu einloggen!";
    exit();
}

$readyForSubmit = true;

if (isset($_POST['submit']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

    // combined generic Validations (isempty, errorMsgs, open for expansion)
    $readyForSubmit = $readyForSubmit & genericValidation($headlineErr, $_POST["headline"]);
    $readyForSubmit = $readyForSubmit & genericValidation($textErr, $_POST["text"]);
    
    // check if personID is set
    if (!isset($_SESSION["personID"])) {        
        exit("Error: personID not set!");
    }

    if ($readyForSubmit == true) {

        // get the data from the form
        $headline = $_POST["headline"];
        $text = $_POST["text"];
        $personID = $_SESSION["personID"];


        // handle the image upload
        $newsImg_target_dir = "./res/img/img news/";
        $newsImg_target_file = $newsImg_target_dir . basename($_FILES["newsImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($newsImg_target_file, PATHINFO_EXTENSION));

        // Check if the file is of the accepted file type
        if($imageFileType != "jpg") {?>
            <p>Leider sind nur Bild-Dateien im Format .jpg erlaubt!</p>
            <?php $uploadOk = 0;
        }         

        // Check if the file size is too large (max. 5MB)
        if ($_FILES["newsImg"]["size"] > 15000000) {?>
            <p>Die Datei ist zu groß, maximal 15 MB sind erlaubt!</p>
            <?php $uploadOk = 0;
        }        

        // Check if the file already exists
        if (file_exists($newsImg_target_file)) {?>
            <p>Die Datei existiert bereits!</p>
            <?php $uploadOk = 0;
        }

        // If everything is OK, upload the file
        if ($uploadOk == 0) {?>
            <p>Die Datei wurde nicht hochgeladen!</p>
            <?php
        } else {
            if (move_uploaded_file($_FILES["newsImg"]["tmp_name"], $newsImg_target_file)) { ?>
                <p>Die Datei <?php htmlspecialchars( basename( $_FILES["newsImg"]["name"])) ?> wurde erfolgreich hochgeladen.</p>
            <?php } else {?>
            <p>Die Datei wurde nicht hochgeladen!</p>
            <?php
            }
        }
        
        // create thumbnail
        $target_dir_thumb = "./res/img/img news/thumbs/";
        $thumb_newsImg_target_file = $target_dir_thumb . "thumb_" . basename($_FILES["newsImg"]["name"]);
        makeThumb($newsImg_target_file, $thumb_newsImg_target_file, 200, 200);

        
        // submit to database

        if (!$con) {
            die('Bei der Verbindung mit der Datenbank ist ein Fehler aufgetreten:  ' . mysqli_error($con));
        }

        // SQL Statemnt for prepared statements
        $sqlInsertNews = "INSERT INTO $mysqli_tbl_news (headline, text, personID, newsImgPath, newsImgThumbPath) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con -> prepare($sqlInsertNews);
        $stmt -> bind_param("ssiss", $headline, $text, $personID, $newsImg_target_file, $thumb_newsImg_target_file);
        $stmt -> execute();
        
        $msg = "Artikel wurde erfolgreich erstellt!";
        header("Refresh: 5; url=newsOverview.php");

    } else {
        $msg = "Artikel konnte nicht erstellt werden!";
    }
}

function makeThumb($src, $dest, $desired_width, $desired_height) {

    /* read the source image */
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagejpeg($virtual_image, $dest);
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | News Erstellung</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

    <div class="content">
            <div class="container form-element">
                <div class="row col-8">
                    <h1 class="headline">Newsbeitrag erstellen</h2>

                    <div class="row g-3">
                        <div class="col-md-6 mb-4" style="background-color:lightgrey"><?php echo $msg; ?></div>
                    </div>

                        <form class="data-form" method="post" enctype="multipart/form-data">
                          
                            <div class="mb-3">
                                <label for="headline" class="form-label">Titel Newsbeitrag: *</label>
                                <input type="text" id="headline" name="headline" class="form-control"
                                    placeholder="Titel Newsbeitrag">
                                <span style="color:red; font-size:small">
                                    <?php echo $headlineErr; ?>
                                </span>
                            </div>

                            <div class="mb-3">
                                <label for="text" class="form-label">Text Newsbeitrag: *</label>
                                <textarea id="text" name="text" class="form-control" rows="8"
                                    placeholder="Hier den Text einfügen."></textarea>
                                <span style="color:red; font-size:small">
                                    <?php echo $textErr; ?>
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <label for="newsImg" class="form-label">Bild Newsbeitrag: *</label>
                                <input type="file" class="form-control" id="newsImg" name="newsImg" aria-label="Upload" accept=".jpg">
                                <span style="color:red; font-size:small">
                                    <?php echo $newsImgErr; ?>
                                </span>
                            </div>
                                             

                            <p style="font-size:small; margin-top:20px;">* Pflichtfelder</p>

                            <button type="submit" name="submit" class="btn btn-blue">Veröffentlichen</button>
                            <button type="reset" name="reset" class="btn btn-grey">Abbrechen</button>
                        

                        </form>
                </div>
            </div>
        </div>



    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>