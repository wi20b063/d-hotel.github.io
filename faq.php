<?php include "components/session.php";?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | FAQ</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

        <section>
            <div class=" container">
                <div class="accordion">
                    <div class="accordion-item" id="question1">
                        <a class="accordion-link" href="#question1">
                            Wie können Reservierungen vorgenommen werden?
                            <ion-icon class="add-outline" name="add-outline"></ion-icon>
                            <ion-icon class="remove-outline" name="remove-outline"></ion-icon>
                        </a>
                        <div class="answer">
                            <p>
                                Reservierungen können über unser Online-Reservierungssystem vorgenommen werden.
                                Nachdem die Verfügbarkeit des Zimmers geprüft wurde, werden Sie gebeten, Ihre
                                Daten in unser Online-Reservierungsformular einzugeben. Sobald das System Ihre
                                Reservierung bestätigt hat, erhalten Sie eine E-Mail-Nachricht mit der
                                eigentlichen Bestätigung einschließlich der Reservierungsnummer. Sie können jedoch
                                auch ein Zimmer in unserem Hotel zu buchen, indem Sie sich an einen unseren Kollegen
                                im Distant Hotel wenden. Sie können die Bestätigung Ihrer Buchung per Fax
                                oder E-Mail anfordern.
                            </p>
                        </div>
                    </div>

                    <div class="accordion-item" id="question2">
                        <a class="accordion-link" href="#question2">
                            Wozu werden meine Kreditkartendetails benötigt?
                            <ion-icon class="add-outline" name="add-outline"></ion-icon>
                            <ion-icon class="remove-outline" name="remove-outline"></ion-icon>
                        </a>
                        <div class="answer">
                            <p>
                                Gemäß unserer Hotelrichtlinie werden die Kreditkartendaten als Garantie für
                                Nichterscheinen des Kunden verwendet. Das Hotel garantiert, dass die
                                Buchung Ihre Buchung bis zu Ihrer Ankunft gehalten wird. Beim Check-in
                                hat man die Möglichkeit, die Buchung in bar oder mit  einer anderen
                                Kreditkarte zu bezahlen.
                            </p>
                        </div>
                    </div>

                    <div class="accordion-item" id="question3">
                        <a class="accordion-link" href="#question3">
                            Wie sicher ist die Eingabe meiner persönlichen Daten auf Ihrer Website?
                            <ion-icon class="add-outline" name="add-outline"></ion-icon>
                            <ion-icon class="remove-outline" name="remove-outline"></ion-icon>
                        </a>
                        <div class="answer">
                            <p>
                                Der Schutz der Daten unserer Kunden ist uns sehr wichtig. Ihre persönlichen Daten
                                werden durch einen sicheren Server geschützt. Wir arbeiten mit der sogenannten
                                SSL-Technologie (Secure Sockets Layer), die alle Daten zunächst verschlüsselt,
                                bevor sie an unseren Server gesendet werden.
                            </p>
                        </div>
                    </div>

                    <div class="accordion-item" id="question4">
                        <a class="accordion-link" href="#question4">
                            Stornierung einer Reservierung
                            <ion-icon class="add-outline" name="add-outline"></ion-icon>
                            <ion-icon class="remove-outline" name="remove-outline"></ion-icon>
                        </a>
                        <div class="answer">
                            <p>
                                Wenn Sie Ihre Buchung stornieren möchten, müssen Sie dies innerhalb der angegebenen
                                Stornierungsfrist tun, um eine unnötige Kreditkartenbelastung zu vermeiden.
                                Wenn Sie vergessen, Ihre Reservierung innerhalb des geforderten Zeitraums zu
                                stornieren, wird Ihnen das Hotel voraussichtlich eine Übernachtung in Rechnung stellen.
                            </p>
                        </div>
                    </div>

                    <div class="accordion-item" id="question5">
                        <a class="accordion-link" href="#question5">
                            Was ist zu tun, wenn ich keine Reservierungsbestätigung erhalte?
                            <ion-icon class="add-outline" name="add-outline"></ion-icon>
                            <ion-icon class="remove-outline" name="remove-outline"></ion-icon>
                        </a>
                        <div class="answer">
                            <p>
                                Sollten Sie innerhalb von 48 Stunden keine Buchungsbestätigung erhalten, bitten wir
                                Sie, sich direkt mit dem Hotel in Verbindung zu setzen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        </div>

    </main>

    <footer>
        <?php include "components/footer.php";?>
    </footer>

    <!-- ion icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>