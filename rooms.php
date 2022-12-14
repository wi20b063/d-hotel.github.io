<?php include "components/session.php";?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | Über uns</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>
        <div class="content">
            <div class="container">
                <h1 class="headline">Zimmer buchen</h1>
                
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <img src="res\img\img rooms\budget room.png" class="card-img-top" alt="Budget Zimmer">
                            <div class="card-body">
                                <h5 class="card-title">Budget Zimmer</h5>
                                <p class="card-text">Das Budget Zimmer ist ein einfaches Zimmer für kleines Geld. Das Zimmer ist als Einzel- oder Doppelzimmer buchbar und befindet sich im 1. Stock. Inkludiert sind TV und gratis WLAN.</p>
                                <!-- <a href="components\booking.php" class="btn" id="modalBtn">Buchen</a> -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal">Buchen</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <img src="res\img\img rooms\standard room.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Standard Zimmer</h5>
                                <p class="card-text">Das Budget Zimmer ist ein hochwertiges Zimmer zu einem günsteren Preis. Das Zimmer ist als Einzel- oder Doppelzimmer buchbar und befindet sich im 1. Stock. Inkludiert sind TV und gratis WLAN.</p>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal">Buchen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <img src="res\img\img rooms\premium room.png" class="card-img-top" alt="Budget Zimmer">
                            <div class="card-body">
                                <h5 class="card-title">Premium Zimmer</h5>
                                <p class="card-text">Das Premium Zimmer ist ein großes und einladendes Zimmer, dass viel Komfort bietet. Das Zimmer ist als Einzel- oder Doppelzimmer buchbar und befindet sich im 2. Stock. Inkludiert sind TV sowie gratis WLAN und Morgenzeitung.</p>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal">Buchen</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <img src="res\img\img rooms\modern suite.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Moderne Suite</h5>
                                <p class="card-text">Die moderne Suite ist eine weitläufige Suite im modernen Design mit großem Balkon. Die Suite ist mit Einzel- oder Doppelbelegung buchbar und befindet sich im 2. Stock. Inkludiert sind TV sowie gratis WLAN, Morgenzeitung und überdachter Parkplatz.</p>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal">Buchen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <img src="res\img\img rooms\luxury suite.png" class="card-img-top" alt="Budget Zimmer">
                            <div class="card-body">
                                <h5 class="card-title">Luzoriöse Suite</h5>
                                <p class="card-text">Die luxuriöse Suite ist eine weitläufige Suite im emperialen Design mit großer Terrasse. Die Suite ist mit Einzel- oder Doppelbelegung buchbar und befindet sich im Dachgeschoß. Inkludiert sind TV sowie gratis WLAN, Morgenzeitung und überdachter Parkplatz.</p>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bookingModal">Buchen</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        
        <!--Modal for booking details-->
        <div class="container">
        <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingModalLabel">Buchungsdetails</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group mb-3">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Bitte wählen Sie das gewünschte Zimmer</option>
                                    <option value="1">Budget Zimmer</option>
                                    <option value="2">Standard Zimmer</option>
                                    <option value="3">Premium Zimmer</option>
                                    <option value="4">Moderne Suite</option>
                                    <option value="3">Luzoriöse Suite</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="arrivalDate">Anreisedatum:</label>
                                    <input type="date" class="form-control" id="arrivalDate">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="departureDate">Abreisedatum:</label>
                                    <input type="date" class="form-control" id="departureDate">
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Wie viele Gäste werden in dem Zimmer residieren?</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 Personen</option>
                                </select>
                            </div>                            
                            <div class="form-group mb-3">
                                <p>Möchten Sie Frühstück für 25€/Tag dazubuchen?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="breakfast" id="breakfastYes" value="yes">
                                    <label class="form-check-label" for="breakfastYes">Ja</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="breakfast" id="breakfastNo" value="no">
                                    <label class="form-check-label" for="breakfastNo">Nein</label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <p>Möchten Sie eine Parkplatz für 15€/Tag dazubuchen?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="parking" id="parkingYes" value="yes">
                                    <label class="form-check-label" for="parkingYes">Ja</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="parking" id="parkingNo" value="no">
                                    <label class="form-check-label" for="parkingNo">Nein</label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <p>Möchten Sie Haustiere (nur Hunde und Katzen erlaubt) mitnehmen (Reinigungspauschale 50€)?</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pets" id="petYes" value="yes">
                                    <label class="form-check-label" for="petYes">Ja</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pets" id="petNo" value="no">
                                    <label class="form-check-label" for="petNo">Nein</label>
                                </div>
                            </div>                                                 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                        <button type="button" class="btn btn-warning" name="book">Buchen</button>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </main>

    <footer>
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>