<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php");
    die("");
}

?>
<p id="site-info">
    &copy; 2024 <a href="http://localhost/projet/">Mini-projet</a>
    &#183; Bon vent !
    &#183; Made by <a href="about-us" target="_blank" rel="noopener"
        style="text-decoration: underline; color: blue;">our team</a>
</p>
<footer id="site-footer" class="section-inner thin animated fadeIn faster w-100 fixed-bottom">

    <!-- <script defer src="/script.js"></script> -->
    <div id="footer-nav" class="container-fluid p-0">
        <nav class="navbar navbar-expand bg-gray-800 w-full d-md-none p-0">
            <ul class="navbar-nav flex justify-between items-center w-full">
                <li class="nav-item" style="width: 30vh">
                    <a class="nav-link text-white text-decoration-none d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600"
                        href="index.php?view=cars" style="font-size: 1em">Cars</a>
                </li>
                <li class="nav-item" style="width: 30vh">
                    <a class="nav-link text-white text-decoration-none d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600"
                        href="index.php?view=plans" style="font-size: 1em">Plans</a>
                </li>
                <li class="nav-item" style="width: 30vh">
                    <a class="nav-link text-white text-decoration-none d-flex justify-content-center align-items-center bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600"
                        href="index.php?view=conversations" style="font-size: 1em">Conversations</a>

                </li>
            </ul>
        </nav>
    </div>
</footer>


<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion 
if (valider("connecte", "SESSION")) {
    echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; ";
    echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>