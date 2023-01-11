<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php"; ?>
    <title>Distant Hotel | Über uns</title>

    <?php
    $isLoggedIn = false;
    if (isset($_SESSION["username"]) && isset($_SESSION["role"])) {
        if ($_SESSION["role"] >= 0) {
            $isLoggedIn = true;
        }
    }
    ?>

    <!-- need jQuery for sending form data from modal. Necessary since we deviced for Modal for the reservation/booking
    (HTML and Modal is already loaded and cannot update Content or query the Database without reloading the page).
    >>>> function getroomssAvailable: 
            -   sends an ajax request with $GET parameters which calls  loadAvailableRooms.php and displays the result
                in the reserved DIV of the current page using Ajax innerHTML.
            -   gets called with JScript Eventhandler (button Click)
            - the data from the date input form requires another Eventhandler (intput value change or button click)
                similar to: https://www.geeksforgeeks.org/how-to-pass-data-into-a-bootstrap-modal/ 
            
            ALTERNATIVELY we had to discard the modal or use something simiar as in profile (If clauses and $POST requests
        -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js" defer="defer"></script>
    <script type="text/javascript">
        function getRoomsAvailable() {
            $.ajax({
                url: 'components/loadAvailableRooms.php',
                type: "get", //send through GET method (is not security relevant)
                data: {
                    // prepare $GET var with values from form input fields 
                    "arrivalDate": $('#arrivalDate').val(),
                    "departureDate": $('#departureDate').val(),
                    "guestsNo": $('#guestsNo').val()
                },
                success: function (html) {
                    // url loadAvailableRooms.php will be displayed in DIV roomBookDIV without the entire page relaod
                    var ajaxDisplay = document.getElementById("roomBookDiv");
                    ajaxDisplay.innerHTML = html;
                }
            });
        }

        function reserveAvailableRoom() {
            $.ajax({
                url: 'components/reserveRoom.php',
                type: "get", //send through  method (is not security relevant)
                data: {
                    // prepare $GET var with values from form input fields 
                    "arrivalDate": $('#arrivalDate').val(),
                    "departureDate": $('#departureDate').val(),
                    "roomCat": $('#roomSelection').val(),
                    "isBreakfast": $('#isBreakfast').val(),
                    "isParking": $('#isParking').val(),
                    "isPets": $('#isPets').val()
                },
                success: function (html) {
                    // url reserveRoom.php will be displayed in DIV roomBookDic3 without the entire page relaod
                    var ajaxDisplay = document.getElementById("roomBookDiv3");
                    ajaxDisplay.innerHTML = html;
                }
            });
        }
    </script>
</head>

<body>


    <main>

        <div class="container">
            <h1 class="headline">Zimmer buchen</h1>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <img src="res\img\img rooms\budget room.png" class="card-img-top" alt="Budget Zimmer">
                        <div class="card-body">
                            <h5 class="card-title">Los gehts</h5>
                            <p class="card-text">In drei Schritten zur Zimmer Auswahl und Reservierung:</p>
                            <?php if ($isLoggedIn) { ?>
                                <button type="button" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#buchungModalToggle">Start</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal for booking details-->
        <!-- Modal 1: Getting input from user: Dates From & To and number of guests. Then submit search, and open Modal 2
                JScript listens for inputs and button click, then calls loadAvailableRooms.php which returns the table 
                in DIV in Modal2  -->
        <div class="modal fade" id="buchungModalToggle" aria-hidden="true" aria-labelledby="buchungModalToggleLabel"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buchungModalToggleLabel">Schritt 1: Verfügbarkeit abfragen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-3">
                            <div class="form-group col-md-6">
                                <label for="arrivalDate">Anreisedatum:</label>
                                <!--  -------Date entry form. using php tp add TODAY date for SELECTED and MIN dates----  -->
                                <input type="date" class="form-control" id="arrivalDate" name="arrivalDate"
                                    value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                <script> $("#arrivalDate").validate();</script>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="departureDate">Abreisedatum:</label>
                                <!--  -------Date entry form. using php tp add TOMORROW date for SELECTED and MIN dates----  -->
                                <input type="date" class="form-control" id="departureDate"
                                    value="<?php echo date("Y-m-d", strtotime('tomorrow')); ?>"
                                    min="<?php echo date("Y-m-d", strtotime('tomorrow')); ?>">
                                <script> $("#departureDate").validate();</script>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="guestsNo">Wie viele Gäste werden in dem Zimmer residieren?" </label>
                            <select class="form-select" name="guestsNo" id="guestsNo"
                                aria-label="Default select example">
                                <option value="1">1 Person</option>
                                <option selected value="2">2 Personen</option>
                                <option value="3">3 Personen</option>
                                <option value="4">4 Personen</option>
                                <option value="5">5 Personen</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#buchungModalToggle2" data-bs-toggle="modal"
                            id="buchungModalToggle2Btn" data-bs-dismiss="modal" type="submit">Zimmer finden</button>
                    </div>
                </div>
            </div>
        </div>

        <!--  --------------       Modal 2: hidden until activated, hides Modal 1 when opened (toggle above)    -------------------------------------  -->

        <div class="modal fade" id="buchungModalToggle2" aria-hidden="true" aria-labelledby="buchungModalToggleLabel2"
            tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buchungModalToggleLabel2">Schritt 2: Zimmer und Extras auswählen
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p> <strong>Verfügbare Zimmer für Ihren geplanten Aufenthalt</strong></p>

                        <div id="roomBookDiv">
                        </div>
                        <!--  --------------       This is where we put the result of the query for available rooms:  #arrivalDate
                            identified by DIV ID "roomBookDiv AJAX will fill the php output Table here---------------  -->

                        <div class="form-group mb-3">
                            <p>Möchten Sie Frühstück für 25€/Tag dazubuchen?</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isBreakfast" id="isBreakfast"
                                    value="yes" checked="checked">
                                <label class="form-check-label" for="breakfastYes">Ja</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isBreakfast" id="isBreakfast"
                                    value="no">
                                <label class="form-check-label" for="breakfastNo">Nein</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <p>Möchten Sie eine Parkplatz für 15€/Tag dazubuchen?</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isParking" id="isParking"
                                    value="yes">
                                <label class="form-check-label" for="parkingYes">Ja</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isParking" id="isParking" value="no"
                                    checked="checked">
                                <label class="form-check-label" for="parkingNo">Nein</label>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <p>Möchten Sie Haustiere (nur Hunde und Katzen erlaubt) mitnehmen (Reinigungspauschale 50€)?
                            </p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isPets" id="isPets" value="yes">
                                <label class="form-check-label" for="petYes">Ja</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isPets" id="isPets" value="no"
                                    checked="checked">
                                <label class="form-check-label" for="petNo">Nein</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#buchungModalToggle" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Datum ändern</button>
                        <button class="btn btn-warning" data-bs-target="#buchungModalToggle3" data-bs-toggle="modal"
                            data-bs-dismiss="modal" id="book" name="book">Buchung senden</button>
                        <!----- calling php for updating the reservation table of DB  -->

                    </div>
                </div>
            </div>
        </div>
        <!---------------------  Modal 3 --------------------------------
    -------------- Here we display the reservation finish. Hiding previous modals -->

        <div class="modal fade" id="buchungModalToggle3" aria-hidden="true" aria-labelledby="buchungModalToggleLabel3"
            tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buchungModalToggleLabel3">Schritt 3: Reservierung abgeschlossen
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <p> <strong>Die Folgende Reservierung wurde abgeschlossen. </strong></p>
                        <p> Bitte notieren sie den Bestätigungscode, ihre Buchung können sie unter xxxxx jederzeit
                            einsehen. </p>

                        <div id="roomBookDiv3">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-target="#buchungModalToggle" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Datum ändern</button>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-dismiss="modal" id="end"
                            name="end">Verlassen</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        </div> <!--  --------------       Evenrt Handlers to trigger scripts      ---------------  -->

        <!--  --------------   Submit BUTTON  handler calling the booking functions via the Ajax function in the header: ---------------  -->

        <script type="text/javascript">
            $(document).ready(function () {
                $("#book").click(function () {
                    //reserveAvailableRoom($('#arrivalDate').val(), $('#departureDate').val(), $('#roomSelection').val(), $('#isBreakfast').val(), $('#isParking').val(), $('#isPets').val())
                    reserveAvailableRoom();
                });
            });
        </script>
        <!--  --------------   Search Rooms BUTTON handler calling the loadAvailableRoom via the Ajax function in the header---------------  -->

        <script type="text/javascript">
            $(document).ready(function () {
                $("#buchungModalToggle2Btn").click(function () {
                    getRoomsAvailable();
                });
            });
        </script>

    </main>


</body>

</html>