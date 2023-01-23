<?php
require(dirname(__FILE__, 2) . "\components\session.php");
if (!isset($_GET['arrivalDate']) && !isset($_GET['departureDate']) && !isset($_GET['guestsNo'])) {
    echo "Es ist ein Fehler aufgetreten, versuchen Sie es später nochmal";
    exit();
}



// checking if form selction  is valid
$fromDat = new DateTime($_GET['arrivalDate']);
$toDat = new DateTime($_GET['departureDate']);
$numGuest = $_GET['guestsNo'];
if ($fromDat >= $toDat) {
    echo "Ungültige Daten eingegeben, versuchen Sie es nochmal";
    exit();
}

// Checkout time is 10:00, so room is free for checkin at as of 12:00 on the same date!  
$fromDat->setTime(12, 0); //setting datetime to 12:00 for arrival date
$toDat->setTime(10, 0);


if (isset($fromDat) && isset($toDat) && isset($numGuest)) {
    $SQLfromDat = $fromDat->format('Y-m-d H:i:s'); // needed to make it a String for the query.
    $SQLtoDat = $toDat->format('Y-m-d H:i:s');

    /* 
    find available rooms in SQL: 
    1) count total rooms per category from room table
    2) count (negative, for later union) all reservations per category which have either arrival or departure date BETWEEN the newly requested arrival and departure date. attention: checkin is after 12:00, checkout before 10:00
    3) union the two counts per category and SUM up the total (minus) booked during the period in question
    4) outer join room Name, Price, Image for usage in HTML table. Could not make it simpler...*/

    //Prepared Statement did not work here...

    $query= "SELECT B.ROOMNAME AS Zimmer, B.ROOMCAT as CAT, A.XFrei AS Frei, ROUND(P.PRICE,2) AS Preis, B.GuestsMax AS Max, B.IMAGE AS Ansicht 
    FROM(
    SELECT result.ROOMCAT, SUM(result.frei) AS XFrei FROM 
        (SELECT ro.ROOMCAT, COUNT(ro.ROOMCAT) AS frei
         FROM $mysqli_tbl_room ro
         GROUP BY ro.ROOMCAT
         UNION ALL
         SELECT res.ROOMCAT, -COUNT(res.ROOMCAT) AS frei 
         FROM $mysqli_tbl_reservation res 
         WHERE ('$SQLfromDat' BETWEEN res.DATEARRIVAL  AND res.DATEDEPART 
                OR '$SQLtoDat' BETWEEN res.DATEARRIVAL  AND res.DATEDEPART ) AND (res.status='reserved' OR res.status='new')
        GROUP BY res.ROOMCAT) result
    GROUP BY result.ROOMCAT
    ORDER BY result.ROOMCAT) AS A
    LEFT JOIN (SELECT t.ROOMCAT, t.ROOMNAME, t.Guestsmax, t.IMAGE
               FROM $mysqli_tbl_room t
               GROUP BY ROOMCAT) As B
               ON A.ROOMCAT=B.ROOMCAT
               LEFT JOIN $mysqli_tbl_price P
               ON B.ROOMCAT = P.PRICECAT
    WHERE B.Guestsmax>='$numGuest'
    ORDER BY Preis ASC";

}
$result = mysqli_query($con, $query) or die(mysqli_error($con));
//writing query result (available room categories) to table 
// in DIV already prepared in Modal2 of rooms.php 
//echo '<class = "table table-bordered">';
?>

<table class="table-responsive">
    <caption> Verfügbare Zimmer für Ihre Auswahl </caption>
    <thead>
        <tr>
            <th>Auswahl</th>
            <th>Kategorie</th>
            <th>Frei</th>
            <th>Preis pN</th>
            <th>Max. Pers</th>
            <th>Info Bild</th>
        <tr>
    </thead>
    <tbody>
        <?php
        //fetching result of query row by row
        $i = 0;
        $radioValue = false;
        while ($row = $result->fetch_object()) {
            $target_image = $rooms_target_dir . $row->Ansicht;
            $roomType = $row->Zimmer;
            if ($row->Frei > 0) {   // only list room categories that are still available
                ?>
                <tr>
                    <td>
                        <!-- writing table row by row. 
                First row radio button is selected, also its the cheapest option-->
                        <input type='radio' name="roomSelection" style="height: 2em; width: 100%; vertical-align: middle;" value="<?php echo $row->CAT; ?>" id="roomSelection" <?php if ($i == 0) { ?> checked="checked" <?php } ?>>
                    </td>
                    <td>
                        <?php echo $row->Zimmer; ?>
                    </td>
                    <td>
                        <?php echo $row->Frei; ?></td>
                    <td>
                        <?php echo $row->Preis; ?>
                    </td>
                    <td>
                        <?php echo $row->Max; ?>
                    </td>
                    <td>
                        <?php echo "<img src= '$target_image' class=\"img-fluid\" alt='image not found' >"; ?>
                    </td>
                </tr>
                <?php
                echo "</br>" . PHP_EOL;
                $i++;

            }

        }
        ?>
    </tbody>
</table>
<?php
?>