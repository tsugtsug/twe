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
?>
<main id="site-main">
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="container" style="height: 70vh">
        <div class="container d-flex justify-content-center align-items-center" style="height: 20vh">
            <svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" fill="gray"
                 class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd"
                      d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>
            <img src="test.png" class="rounded-circle" width="160" height="160" alt="" style="position: absolute">
        </div>
        <div class="container d-flex flex-column">
            <div class="row align-items-center d-flex flex-column">
                <div class="col text-center pt-3">
                    <!-- 用户名或其他信息 -->
                    <h3><?php echo "$_SESSION[pseudo]"; ?></h3>
                    <!-- <p>User message</p> -->
                </div>
            </div>
            <a class="link-light text-white text-center text-decoration-none rounded h1 m-2 bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 d-flex align-items-center justify-content-center"
               href="index.php?view=configuration" style="height: 7vh">Config</a>
            <!-- <a class="link-light text-white text-center text-decoration-none rounded h1 m-2 bg-primary d-flex align-items-center justify-content-center"
               href="index.php?view=cars" style="height: 7vh">Histories</a> -->
            <a class="link-light text-white text-center text-decoration-none rounded h1 m-2 bg-danger d-flex align-items-center justify-content-center"
               href="controleur.php?action=Logout" style="height: 7vh">Log out</a>
        </div>
    </div>
</div>
</main>