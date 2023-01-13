<!--Stylesheet-->
<link rel="stylesheet" type="text/css" href="res/css/mystyle.css">

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class=" navbar-brand " href=" index.php">
            <img id="logo-nav" src="res\img\distant-logo-nobg.PNG" alt="Logo Hotel Distant">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="aboutus.php">Über uns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQ</a>
                </li>
                <li>

                <li class="nav-item">
                    <a class="nav-link btn btn-warning btnNav" href="rooms.php"> Zimmer Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-warning btnNav" href="booking.php"> Zimmer buchen</a>
                </li>
            </ul>

            <!--Für eingeloggten Zustand-->
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <span class="navbar-text d-flex align-items-center">
                        <?php echo "Willkommen " . $_SESSION["username"] . "!  "; ?>
                    </span>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Profil
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" id="navbar-dropdown-menu"
                        aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href=".\profile.php">Profil</a></li>
                        <li><a class="dropdown-item" href="bookingsMyList.php">Buchungen</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="components\logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>