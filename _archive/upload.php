<?php
//specifies the path to the session file
$target_dir ="uploads/";
//specifies the path to the session file
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
//is not used yet(will be used later)
$uploadOk = 1;
//holds the file extension of the file
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
?>