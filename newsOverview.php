<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");

    $msg = $newsIDdelete = $newsIDdeleteErr = "";

    // Check if valid user is logged in
    if (!isset($_SESSION["username"])) {
        $msg = "Bitte einloggen um die Übersicht der News-Beiträge zu sehen!";
        exit(); }

    if ($_SESSION["role"] != "1") {
        $msg = "Sie haben keine Berechtigung die Übersicht der News-Beiträge zu sehen!";
        exit(); }
    
    // Check if session is expired.
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        // last request was more than 30 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        $msg = "Session ist abgelaufen. Bitte neu einloggen!";
        exit(); }

    // If tbl_news is empty, display "No news articles yet."
    $sqlSelectNews = "SELECT * FROM $mysqli_tbl_news";
    $result = mysqli_query($con, $sqlSelectNews);
    if (mysqli_num_rows($result) == 0) {
        $msg = "Keine News-Beiträge vorhanden."; } 
        
    // delete news if delete button is pressed
    $readyForSubmit = true;

    if (isset($_POST['delete']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {

        // combined generic Validations (isempty, errorMsgs, open for expansion)
        $readyForSubmit = $readyForSubmit & genericValidation($newsIDdeleteErr, $_POST["newsIDdelete"]);
    
        if ($readyForSubmit == true) {
        // get the data from the form
        $newsIDdelete = $_POST["newsIDdelete"];

        // Submit to database SQL Statemnt for prepared statements
        $sqlDeleteNews = "DELETE FROM $mysqli_tbl_news WHERE id = ?";
        $stmtReservStatus = $con->prepare($sqlDeleteNews);
        $stmtReservStatus -> bind_param("i", $newsIDdelete);
        $stmtReservStatus -> execute();

        $msg = "Newsbeitrag wurde erfolgreich gelöscht!";
        header("Refresh: 3; url=newsOverview.php");
        
        } else {
        $msg = "Fehler beim Löschen des Newsbeitrags!";
        }
    
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
            <div class="container">
                    <h1 class="headline">News-Beiträge Übersicht</h1>

                    <div class="row g-3">
                        <div class="col-md-6 mb-4" style="background-color:lightgrey"><?php echo $msg; ?></div>
                    </div>                    

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">News-ID</th>
                                    <th scope="col">Erstellt von</th>
                                    <th scope="col">Erstellt am</th>
                                    <th scope="col">Headline</th>
                                    <th scope="col">Text</th>
                                    <!-- <th scope="col">Thumb Anzeige</th>
                                    <th scope="col">Thumb Download</th>
                                    <th scope="col">Löschung</th> -->
                                </tr>
                            </thead>

                            <?php                                  

                            // Get all data from tbl_news
                            $sqlSelectNews = "SELECT * FROM $mysqli_tbl_news ORDER BY publicationDate DESC";
                            $result = $con->query($sqlSelectNews);
                            while ($row = $result->fetch_assoc()) {
                                $headline = $row["headline"];
                                $text = $row["text"];
                                $personID = $row["personID"];
                                $newsImgPath = $row["newsImgPath"];
                                $newsImgThumbPath = $row["newsImgThumbPath"];
                                $newsID = $row["id"];
                                $publicationDate = $row["publicationDate"];
                                $date = date("d.m.Y", strtotime($publicationDate));
                                $sqlSelectPerson = "SELECT * FROM $mysqli_tbl_u_profile WHERE personID = $personID";
                                $resultPerson = $con->query($sqlSelectPerson);
                                while ($rowPerson = $resultPerson->fetch_assoc()) {
                                    $firstname = $rowPerson["firstName"];
                                    $lastname = $rowPerson["lastName"];
                                } ?>

                            <tbody>
                                <tr>
                                    <td scope="row"><?php echo $newsID; ?></td>
                                    <td><?php echo $firstname . " " . $lastname; ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $headline; ?></td>
                                    <td><?php echo $text; ?></td>
                                    <td><a href="<?php echo $newsImgThumbPath; ?>" target="_blank">Zeige Thumb</a></td>
                                    <td><a href="<?php echo $newsImgThumbPath; ?>" download="<?php echo $newsImgThumbPath; ?>">Download Thumb</a></td>
                                    <!-- Delete news article TODO-->
                                    <td><button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#deletNews_<?php echo $newsID; ?>">
                                            Löschen
                                        </button>
                                    </td>

                                    <!-- Modal Delet News -->
                                    <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="container">
                                                <div class="modal fade" id="deletNews_<?php echo $newsID; ?>" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Newsbeitrag löschen</h5>
                                                            <input type="hidden" id="newsIDdelete" name="newsIDdelete" value="<?php echo $newsID; ?>">
                                                        </div>
                                                        <div class="modal-body">                            
                                                            <p>Sind Sie sich sicher, dasss Sie den Newsbeitrag mit der ID <?php echo $newsID; ?> löschen möchten?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                            <button type="submit" name="delete" id="delete" class="btn btn-danger">Löschen</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>


                                </tr>
                            </tbody>
                            <?php } ?>
                                        
                        </table> 
                    </div>                                 
                                
            </div>


    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>