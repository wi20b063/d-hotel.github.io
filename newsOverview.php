<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");
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

                    <?php
                        // Check if valid user is logged in
                        if (!isset($_SESSION["username"])) {
                            echo '<span style="color:red; font-size:small">Bitte einloggen um die Übersicht der News-Beiträge zu sehen!</span>';
                            exit();
                        }
                        if ($_SESSION["role"] != "1") {
                            echo '<span style="color:red; font-size:small">Sie haben keine Berechtigung die Übersicht der News-Beiträge zu sehen!</span>';
                            exit();
                        }
                        
                        // Check if session is expired.
                        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
                            // last request was more than 30 minutes ago
                            session_unset();     // unset $_SESSION variable for the run-time
                            session_destroy();   // destroy session data in storage
                            echo '<span style="color:red; font-size:small">Session ist abgelaufen. Bitte neu einloggen!</span>';
                            exit();
                        }
                        
                        ?>
                            
                                <?php

                                    // If tbl_news is empty, display "No news articles yet." in red font
                                    $sqlSelectNews = "SELECT * FROM $mysqli_tbl_news";
                                    $result = mysqli_query($con, $sqlSelectNews);
                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <span style="color:red; font-size:small">Keine News-Beiträge vorhanden.</span>
                                    <?php } ?>

                                    <div class="table-responsive-md">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col-sm-1">News-ID</th>
                                                    <th scope="col-sm-1">Erstellt von</th>
                                                    <th scope="col">Erstellt am</th>
                                                    <th scope="col">Headline</th>
                                                    <th scope="col-sm-5">Text</th>
                                                    <th scope="col">Thumb Anzeige</th>
                                                    <th scope="col">Thumb Download</th>
                                                    <th scope="col">Löschung</th>
                                                </tr>
                                            </thead>

                                            <?php                                  

                                            // Link each uploaded file. Hint: keep in mind to use the correct path!

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
                                                            <th scope="row"><?php echo $newsID; ?></th>
                                                            <th><?php echo $firstname . $lastname; ?></th>
                                                            <th><?php echo $date; ?></th>
                                                            <th><?php echo $headline; ?></th>
                                                            <th><?php echo $text; ?></th>
                                                            <th><a href="<?php echo $newsnewsImgThumbPathImgPath; ?>">Zeige Thumb</a></th>
                                                            <th><a href="<?php echo $$newsnewsImgThumbPathImgPath; ?>" download="<?php echo $newsnewsImgThumbPathImgPath; ?>">Download Thumb</a></th>
                                                            <!-- Delete news article TODO-->
                                                            <th><a href="news_delete.php?id=<?php echo $newsID; ?>">Löschen</a></th>
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