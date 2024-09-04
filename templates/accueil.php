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

?>

<main id="site-main">
	<div class="flex flex-col">
		<!-- Header部分 -->
		<div class="h-1/4 flex flex-col justify-center items-center">
			<h1 class="text-6xl">BlaBla Car</h1>
			<h2>Centrale Lille</h2>
		</div>
		<!-- 主体部分 -->
		<div class="flex justify-between items-center bg-blue-600 px-4 py-2">
			<ul class="flex flex-col items-center space-y-4">
				<li>
					<a href="index.php?view=cars" class="text-gray-800 hover:text-gray-900 text-lg">Cars</a>
				</li>
				<li>
					<a href="index.php?view=plans" class="text-gray-800 hover:text-gray-900 text-lg">Plans</a>
				</li>
				<li>
					<a href="index.php?view=conversations"
						class="text-gray-800 hover:text-gray-900 text-lg">Conversations</a>
				</li>
			</ul>
		</div>


	</div>
	<?php
	// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
	if (!valider("connecte", "SESSION"))
		echo "<a href=\"index.php?view=login\">Se connecter</a>";
	?>
</main>