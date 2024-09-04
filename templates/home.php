<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=accueil");
    die("");
}
include_once ("libs/modele.php"); // listes
include_once ("libs/maLibUtils.php");// tprint
include_once ("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...
if (!valider("connecte", "SESSION")) {
    $qs = "?view=login";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);

    $urlBase = $protocol . $host . $script . "/index.php";
    header("Location:" . $urlBase . $qs);
    die("Please login first!");
}
?>
<!doctype html>
<html lang="en">

<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">-->
<!--    <title>Document</title>-->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"-->
<!--          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">-->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"-->
<!--            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"-->
<!--            crossorigin="anonymous"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"-->
<!--            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"-->
<!--            crossorigin="anonymous"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"-->
<!--            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"-->
<!--            crossorigin="anonymous"></script>-->
<!--</head>-->

<body>
<div class="container-fluid" style="height: 100vh">
    <div class="container" style="height: 10vh"></div>
    <div class="container h-25 d-flex flex-column justify-content-center align-items-center pt-2">
        <h1 class="display-1">BlaBla Car</h1>
        <h2>Centrale Lille</h2>
    </div>
    <div class="container-fluid h-65 d-flex justify-content-center align-items-center">
        <div class="row h-100 w-100">
            <div class="col-sm d-flex justify-content-center align-items-center w-100">
                <a href="index.php?view=cars"
                   class="d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white w-100 text-decoration-none rounded m-3"
                   style="height: 10vh;font-size: 1.5em">
                    Cars
                </a>
            </div>
            <div class="col-sm d-flex justify-content-center align-items-center w-100">
                <a href="index.php?view=plans"
                   class="d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white w-100 text-decoration-none rounded m-3"
                   style="height: 10vh;font-size: 1.5em">
                    Plans
                </a>
            </div>
            <div class="col-sm d-flex justify-content-center align-items-center w-100">
                <a href="index.php?view=conversations"
                   class="d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white w-100 text-decoration-none rounded m-3"
                   style="height: 10vh;font-size: 1.5em">
                    Conversations
                </a>
            </div>
        </div>

    </div>
</div>
</body>

</html>