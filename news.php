<?php
    require(dirname(__FILE__, 1) . "\components\session.php");
    require(dirname(__FILE__, 1) . "\config\dbaccess.php");
    require(dirname(__FILE__, 1) . "\components\inputValidation.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | News</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>   
        <div class="content">
            <div class="container">
            <h1 class="headline">News-Beiträge</h1>

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
                //$date = date("d.m.Y h:i:s", strtotime($publicationDate));
                $sqlSelectPerson = "SELECT * FROM $mysqli_tbl_u_profile WHERE personID = $personID";
                $resultPerson = $con->query($sqlSelectPerson);
                while ($rowPerson = $resultPerson->fetch_assoc()) {
                    $firstname = $rowPerson["firstName"];
                    $lastname = $rowPerson["lastName"];
                } ?> 
                    <div class="row my-2 border border-1 shadow-sm p-3 mb-5 bg-body rounded">
                    <div class="col-md-8">
                        <p>Verfasser:in: <?php echo "$firstname $lastname"; ?> | Datum: <?php echo $date?> </p>
                        <h3><?php echo "$headline"; ?></h3>
                        <p><?php echo "$text"; ?></p>
                    </div>
                    <div class="col-sm-3 text-center">
                        <img src="<?php echo $newsImgThumbPath; ?>" alt="Bild News Beitrag" class="news-img text-center">
                    </div>
                    </div>
            <?php } ?>        
            
            

            </div>
        </div>
    </main>

    <footer>
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>