<?php include "components/session.php";?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | Home</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

        <div id="carouselHomepasge" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carouselHomepasge" data-slide-to="0" class="active"></li>
                <li data-target="#carouselHomepasge" data-slide-to="1"></li>
                <li data-target="#carouselHomepasge" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img class="d-block w-100" src="res\img\hotel-view.png" alt="First slide">
                    <div class="container carousel-caption d-none d-md-block">
                        <h1>Willkomen im Distant Hotel!</h1>
                        <h2 class="lead slogan">Your HOME Away From HOME</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae
                            delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="res\img\hotel-rooms.png" alt="Second slide">
                    <div class="container carousel-caption d-none d-md-block">
                        <h1>Die wundervollen Hotel-Zimmer</h1>
                        <h2 class="lead slogan">Jedes Zimmer ist eine Insel der Erholung!</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae
                            delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>

                <div class="carousel-item">
                    <img class="d-block w-100" src="res\img\hotel-pool.png" alt="Third slide">
                    <div class="container carousel-caption d-none d-md-block">
                        <h1>Der Distant-Pool</h1>
                        <h2 class="lead slogan">Ein Infinty-Pool zum Seele baumeln lassen!</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae
                            delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="content">
            <div class="container">
                <h1>Atque eum porro cum quia</h1>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim recusandae, fugiat praesentium
                    excepturi
                    libero, id atque eum porro cum quia eius debitis aut autem, ex blanditiis? Possimus non facilis
                    reprehenderit!
                </p>
                <br>
                <h1>Porro cum quia</h1>
                <p>
                    Consectetur adipisicing elit. Beatae reprehenderit ea quos nesciunt ipsam,
                    praesentium eaque, minus iusto voluptas distinctio, id consectetur doloribus sunt consequuntur fugit
                    possimus asperiores laudantium! Cum. dolor sit amet, Lorem ipsum, dolor sit amet consectetur
                    adipisicing
                    elit. Illo non, quod saepe perferendis iure vero porro ea earum inventore doloribus, facere,
                    pariatur
                    delectus. Pariatur magnam et quasi repellat totam in!
                </p>
            </div>
        </div>



    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>