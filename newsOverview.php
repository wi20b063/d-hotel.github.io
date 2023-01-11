<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");

    $msg = "";

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

    // If tbl_news is empty, display "No news articles yet." in red font
    $sqlSelectNews = "SELECT * FROM $mysqli_tbl_news";
    $result = mysqli_query($con, $sqlSelectNews);
    if (mysqli_num_rows($result) == 0) {
        $msg = "Keine News-Beiträge vorhanden."; }    

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

                    <div class="table-responsive-md">
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
                            $sqlSelectNews = "SELECT * FROM $mysqli_tbl_news";
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
                                    <td scope="row"><?php echo $newsID; ?></th>
                                    <td><?php echo $firstname . " " . $lastname; ?></th>
                                    <td><?php echo $date; ?></th>
                                    <td><?php echo $headline; ?></th>
                                    <td><?php echo $text; ?></th>
                                    <td><a href="<?php echo $newsImgThumbPath; ?>" target="_blank">Zeige Thumb</a></th>
                                    <td><a href="<?php echo $newsImgThumbPath; ?>" download="<?php echo $newsImgThumbPath; ?>">Download Thumb</a></th>
                                    <!-- Delete news article TODO-->
                                    <td><a href="news_delete.php?id=<?php echo $newsID; ?>">Löschen</a></th>
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