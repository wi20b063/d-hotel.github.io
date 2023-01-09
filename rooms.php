<?php include "components/session.php"; ?>

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


</head>

<body>
    <nav>
        <?php include "components/navbar.php"; ?>
    </nav>

    <main>

        <div class="container">
            <h1 class="headline">Zimmer buchen</h1>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <img src="res\img\img rooms\budget room.png" class="card-img-top" alt="Budget Zimmer">
                        <div class="card-body">
                            <h5 class="card-title">Budget Zimmer</h5>
                            <p class="card-text">Das Budget Zimmer ist ein einfaches Zimmer für kleines Geld. Das Zimmer
                                ist als Einzel- oder Doppelzimmer buchbar und befindet sich im 1. Stock. Inkludiert sind
                                TV und gratis WLAN.</p>
                            <?php if ($isLoggedIn) { ?>
                                <a href="booking.php" button type="button" class="btn">Buchen</a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <img src="res\img\img rooms\standard room.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Standard Zimmer</h5>
                            <p class="card-text">Das Budget Zimmer ist ein hochwertiges Zimmer zu einem günsteren Preis.
                                Das Zimmer ist als Einzel- oder Doppelzimmer buchbar und befindet sich im 1. Stock.
                                Inkludiert sind TV und gratis WLAN.</p>
                            <?php if ($isLoggedIn) { ?>
                                <a href="booking.php" button type="button" class="btn">Buchen</a>
                            <?php } ?>
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
                            <p class="card-text">Das Premium Zimmer ist ein großes und einladendes Zimmer, dass viel
                                Komfort bietet. Das Zimmer ist als Einzel- oder Doppelzimmer buchbar und befindet sich
                                im 2. Stock. Inkludiert sind TV sowie gratis WLAN und Morgenzeitung.</p>
                            <?php if ($isLoggedIn) { ?>
                                <a href="booking.php" button type="button" class="btn">Buchen</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <img src="res\img\img rooms\modern suite.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Moderne Suite</h5>
                            <p class="card-text">Die moderne Suite ist eine weitläufige Suite im modernen Design mit
                                großem Balkon. Die Suite ist mit Einzel- oder Doppelbelegung buchbar und befindet sich
                                im 2. Stock. Inkludiert sind TV sowie gratis WLAN, Morgenzeitung und überdachter
                                Parkplatz.</p>
                            <?php if ($isLoggedIn) { ?>
                                <a href="booking.php" button type="button" class="btn">Buchen</a>
                            <?php } ?>
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
                            <p class="card-text">Die luxuriöse Suite ist eine weitläufige Suite im emperialen Design mit
                                großer Terrasse. Die Suite ist mit Einzel- oder Doppelbelegung buchbar und befindet sich
                                im Dachgeschoß. Inkludiert sind TV sowie gratis WLAN, Morgenzeitung und überdachter
                                Parkplatz.</p>
                            <?php if ($isLoggedIn) { ?>
                                <a href="booking.php" button type="button" class="btn">Buchen</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>

    <footer>
        <?php include "components/footer.php"; ?>
    </footer>

</body>

</html>