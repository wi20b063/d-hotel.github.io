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

        <div id="carouselHomepage" class="carousel slide" data-bs-ride="carousel">

            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselHomepage" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselHomepage" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselHomepage" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">                
                <div class="carousel-item active">
                    <img src="res\img\hotel-view.png" class="d-block w-100" alt="Hotel View">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Willkomen im Distant Hotel!</h1>
                        <h2>Your HOME Away From HOME</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="res\img\hotel-rooms.png" class="d-block w-100" alt="Hotel Rooms">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Die wundervollen Hotel-Zimmer</h1>
                        <h2>Jedes Zimmer ist eine Insel der Erholung!</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae
                            delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="res\img\hotel-pool.png" class="d-block w-100" alt="Hotel Infinity-Pool">
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Der Distant-Pool</h1>
                        <h2>Ein Infinty-Pool zum Seele baumeln lassen!</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium sit repellat excepturi,
                            beatae
                            delectus soluta et modi incidunt aliquam.</p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHomepage" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHomepage" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
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
                <h1>Pariatur magnam et quasi</h1>
                <p>
                Lorem ipsum dolor sit amet. Eos dolorem dolore ut perspiciatis labore et tenetur ipsum aut ullam numquam 
                sit aliquid quia. Et esse deserunt eos consequatur error nam adipisci vero ut natus adipisci non neque 
                debitis. Ut sapiente molestias aut quisquam esse non obcaecati vitae aut minima assumenda! Est rerum 
                deserunt ut sint rerum et deleniti porro in omnis dolor ut repellendus autem aut repellendus voluptas! 
                Sit rerum placeat eos ullam atque id optio fugiat sed sint quibusdam aut vitae placeat ut nemo obcaecati 
                est fugit quia. Ab iusto libero id provident quae ut similique beatae ut maiores eius. A veritatis aliquid 
                est harum voluptas vel explicabo officiis sed consequatur quia sed minima illum aut tempora quas. Quo quia 
                odio quo deleniti cupiditate quo laborum neque et saepe galisum aut mollitia quis qui omnis alias. Non 
                voluptatem blanditiis ab natus esse aut voluptates illo et unde reiciendis.
                </p>
            </div>
        </div>

    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>