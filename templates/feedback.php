<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

// Hyp : ce fichier est sensé etre inclus entre la banniere et le corps de la page 

// Ce qui est ici doit s'afficher entre la bannière et le corps de la page 
// Raisonnement : STRUCTURE, PRESENTATION, INTERACTION 

// Cahier des charges fonctionnel : 
// Message doit apparaitre centré
// associé à une image sous la forme d'un croix permettant de le supprimer 
// la croix doit s'afficher en haut à droite du message 
// Le feedback doit être positionné en relatif
// La croix en absolu, et etre enfant du div feedback 
// ALT : on ne l'affiche que 10 secondes 

if ($msg_feedback) { 
	echo '<div id="feedback">'; 
	echo stripslashes($msg_feedback); 
	echo '<img src="ressources/croix.png" onclick="hideFeedback();" />'; 
	echo '</div>'; 

	?>

	<script>
		function hideFeedback(){
			console.log("cacher feedback");
			var refFeedback = document.getElementById("feedback"); 
			refFeedback.style.display="none";
		}

		window.setTimeout(hideFeedback, 10000);

	</script>

<?php
}
?>





