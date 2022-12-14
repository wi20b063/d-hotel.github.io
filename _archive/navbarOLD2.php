<!--NAVBAR (basic concept -> componenet from bootstrap 5)-->
<style>
/* Modify the background color */

.navbar-custom {
    background-color: lightgreen;
}

/* Modify brand and text color */

.navbar-custom .navbar-brand,
.navbar-custom .navbar-text {
    color: green;
}
</style>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">

        <!--hotel logo in navbar-->
        <a class="navbar-brand" href="index.php">
            <img id="distant-logo-nav" src="res\img\distant-logo.PNG" alt="distant-logo" height="65" border="0">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Das Hotel
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="pages\aboutus.php">Über uns</a></li>
                        <li><a class="dropdown-item" href="pages\news.php">News</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="pages\register.php">Registrierung</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>

            <!-- navbar elements right -->
            <ul class="navbar-nav navbar-right me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>

            <!-- Search Panel -->
            <!-- <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->

        </div>
    </div>
</nav>