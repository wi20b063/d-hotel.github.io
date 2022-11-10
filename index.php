<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Stylesheet-->
    <link rel="stylesheet" type="text/css" href="res/css/mystyle.css">
    <!--CDN to use font awesome-->
    <script src="https://use.fontawesome.com/19e7f602a2.js"></script>
    <!-- font awesome for social media icons-->
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Bootstrap 5 -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css
        integrity=" sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>Distant Hotel | Home</title>
</head>

<body>


    <nav>
        <?php include "pages/navbar.php";?>
    </nav>

    <main>
        <?php include "pages/home-carousel.php";?>
        <?php include "pages/someText.php";?>
    </main>

    <footer>
        <?php include "pages/footer.php";?>
    </footer>

    <!-- // Use a switch statement to compose the webpages
    /*
    switch (n) {
      case label1:
        code to be executed if n=label1;
        break;
      case label2:
        code to be executed if n=label2;
        break;
      case label3:
        code to be executed if n=label3;
        break;
        ...
      default:
        code to be executed if n is different from all labels;
    }
    */ -->



</body>

</html>