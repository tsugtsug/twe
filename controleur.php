<?php
session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

$qs = "";

if ($action = valider("action")) {
    ob_start();
    // echo "Action = '$action' <br />";
    // ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents...
    // A EVITER si on ne maitrise pas ce type de problématiques

    /* TODO: A REVOIR !!
                                                          // Dans tous les cas, il faut etre logue...
                                                          // Sauf si on veut se connecter (action == Connexion)

                                                          if ($action != "Connexion")
                                                              securiser("login");
                                                          */

    // Un paramètre action a été soumis, on fait le boulot...
    switch ($action) {


        // Connexion //////////////////////////////////////////////////
        case 'Connexion':
            // On verifie la presence des champs login et passe
            $feedback = false;
            if ($login = valider("login")) {
                if ($passe = valider("passe")) {
                    // On verifie l'utilisateur,
                    // et on crée des variables de session si tout est OK
                    // Cf. maLibSecurisation
                    if (verifUser($login, $passe)) {
                        // tout s'est bien passé, doit-on se souvenir de la personne ?
                        if (valider("remember")) {
                            setcookie("login", $login, time() + 60 * 60 * 24 * 30);
                            setcookie("passe", $passe, time() + 60 * 60 * 24 * 30);
                            setcookie("remember", true, time() + 60 * 60 * 24 * 30);
                        } else {
                            setcookie("login", "", time() - 3600);
                            setcookie("passe", "", time() - 3600);
                            setcookie("remember", false, time() - 3600);
                        }
                    } else {
                        // Identifiants incorrects
                        // TODO: expliciter cryptage des mots de passe dans la bdd
                        // au moment de la création d'un compte :
                        // $SQL = "INSERT INTO users(login,passe) VALUES('tom',md5('passe'))"
                        // => la base de données ne contient pas les mots de passe en clair
                        // Fonctions possibles : crypt, md5...
                        // Au moment de la vérification des identifiants :
                        // $SQL = "SELECT id FROM users WHERE login='tom' AND passe=md5('passe')"
                        $feedback = "Identifiants incorrects !!!";
                    }
                } else {
                    // pas de mot de passe
                    $feedback = "Mot de passe absent !!!";
                }
            } else {
                // pas de login
                $feedback = "Login absent !!!";
            }

            // On redirigera vers la page index automatiquement
            if ($feedback) {
                $qs = "?view=login&msg_feedback=" . urlencode($feedback);
            } else {
                $qs = "?view=home&msg_feedback=" . urlencode("Bienvenue, " . $_SESSION["pseudo"] . " !");
            }
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";

            // On redirige vers la page index avec les bons arguments

            header("Location:" . $urlBase . $qs);
            break;
        case 'Sign Up':
            $feedback = false;
            if ($login = valider("login")) {
                if ($passe = valider("passe")) {
                    mkUser($login, $passe);
                    if (verifUser($login, $passe)) {
                        if (valider("remember")) {
                            setcookie("login", $login, time() + 60 * 60 * 24 * 30);
                            setcookie("passe", $passe, time() + 60 * 60 * 24 * 30);
                            setcookie("remember", true, time() + 60 * 60 * 24 * 30);
                        } else {
                            setcookie("login", "", time() - 3600);
                            setcookie("passe", "", time() - 3600);
                            setcookie("remember", false, time() - 3600);
                        }
                    }
                } else {
                    // pas de mot de passe
                    $feedback = "Mot de passe absent !!!";
                }
            } else {
                // pas de login
                $feedback = "Login absent !!!";
            }
            // On redirigera vers la page index automatiquement
            if ($feedback) {
                $qs = "?view=login&msg_feedback=" . urlencode($feedback);
            } else {
                $qs = "?view=accueil&msg_feedback=" . urlencode("Bienvenue, " . $_SESSION["pseudo"]);
            }
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";

            // On redirige vers la page index avec les bons arguments

            header("Location:" . $urlBase . $qs);
            break;
        case 'Logout':
        case 'logout':
            // traitement métier
            // NEVER TRUST USER INPUT !!
            if (valider("connecte", "SESSION")) {
                // id : $_SESSION["idUser"]
                deconnecterUtilisateur($_SESSION["idUser"]);
                session_destroy();
            }

            // On redirigera vers la vue connexion (view=login)
            $qs = "?view=login";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";

            // On redirige vers la page index avec les bons arguments

            header("Location:" . $urlBase . $qs);
            break;

        case 'Archiver':
            if ($idConv = valider("idConv"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"]) {
                        archiverConversation($idConv);
                    }
            $qs = "?view=conversations&lastIdConv=$idConv";
            break;

        case 'Réactiver':
            if ($idConv = valider("idConv"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"]) {
                        reactiverConversation($idConv);
                    }
            $qs = "?view=conversations&lastIdConv=$idConv";
            break;

        case 'Supprimer Conversation':
            if ($idConv = valider("idConv"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"]) {
                        supprimerConversation($idConv);
                    }
            $qs = "?view=conversations&lastIdConv=$idConv";
            break;

        case 'Créer Conversation':
            if ($theme = valider("theme"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"]) {
                        $idNouvelleConv = creerConversation($theme);
                    }
            $qs = "?view=conversations&lastIdConv=$idNouvelleConv";
            break;


        case 'Poster':
        case 'POSTER':
            if ($idConv = valider("idConv"))
                if ($contenu = valider("contenu"))
                    if (valider("connecte", "SESSION")) {
                        $idUser = $_SESSION["idUser"];
                        $dataConv = getConversation($idConv);
                        //NEVER TRUST USER INPUT
                        if ($dataConv["active"])
                            enregistrerMessage($idConv, $idUser, $contenu);
                    }
            $qs = "?view=chat&idConv=$idConv";
            break;


        // ACTIONS POUR ADMIN :

        case 'Supprimer':
            if ($idUser = valider("idUser"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"])
                        supprimerUser($idUser);

            $qs = "?view=users&idLastUser=$idUser";
            break;

        case 'Interdire':
            if ($idUser = valider("idUser"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"])
                        interdireUtilisateur($idUser);

            $qs = "?view=users&idLastUser=$idUser";
            break;

        case 'Autoriser':
            if ($idUser = valider("idUser"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"])
                        autoriserUtilisateur($idUser);

            $qs = "?view=users&idLastUser=$idUser";
            break;

        case 'Promouvoir Admin':
        case 'Promouvoir admin':
            if ($idUser = valider("idUser"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"])
                        promouvoirAdmin($idUser);

            $qs = "?view=users&idLastUser=$idUser";
            break;

        case 'Rétrograder':
            if ($idUser = valider("idUser"))
                if (valider("connecte", "SESSION"))
                    if ($_SESSION["isAdmin"])
                        retrograderUser($idUser);

            $qs = "?view=users&idLastUser=$idUser";
            break;


        case 'Changer Couleur':
			case 'Change Color':
				if ($idUser = valider("idUser")) {
					if ($couleur = valider("color")) {
						if (valider("connecte", "SESSION")) {
                            changerCouleur($idUser, $couleur);
						} else {
							echo json_encode(["status" => "error", "message" => "User not connected."]);
						}
					} else {
						echo json_encode(["status" => "error", "message" => "Color not specified."]);
					}
				} else {
					echo json_encode(["status" => "error", "message" => "User ID not specified."]);
				}
	
            $qs = "?view=users&idLastUser=$idUser";
			header("Location:" . $urlBase . $qs);
            break;

        // case 'Créer Utilisateur':
        // 	$idUser = false;
        // 	if ($pseudo = valider("pseudo"))
        // 		if ($passe = valider("passe"))
        // 			if ($couleur = valider("couleur"))
        // 				if (valider("connecte", "SESSION"))
        // 					if ($_SESSION["isAdmin"])
        // 						$idUser = mkUser($pseudo, $passe, false, $couleur);

        // 	$qs = "?view=users&idLastUser=$idUser";
        // 	break;

        case 'Modifier Couleur':
        case 'Modifier couleur':
            if ($couleur = valider("couleur"))
                if (valider("connecte", "SESSION")) {
                    $idUser = $_SESSION["idUser"];
                    changerCouleur($idUser, $couleur);
                }

            $qs = "?view=profil";
            break;

        case 'Modifier Passe':
        case 'Modifier passe':
            if ($passe = valider("passe"))
                if (valider("connecte", "SESSION")) {
                    $idUser = $_SESSION["idUser"];
                    changerPasse($idUser, $passe);
                }

            $qs = "?view=login";
			header("Location:" . $urlBase . $qs);
            break;
        case 'Envoyer Message':
            // 检查请求类型并处理
            // echo "Envoyer Message";
            $idConversation = valider('idConv');
            if (!isAvailable($idConversation)) {
                // La conversation n'existe pas !
                // header("Location:index.php?view=conversations");
                die("Vous n'avez pas accès à cette conversation !");
            }

            $idAuteur = $_SESSION["idUser"];
            $contenu = valider('message');
            $result = enregistrerMessage($idConversation, $idAuteur, $contenu);
            // 返回结果给前端
            if ($result) {
                echo "Message envoyé avec succès !";
            } else {
                echo "Erreur lors de l'envoi du message.";
            }
            break;
        case "Refresh Message":
            $idConv = valider('idConv');
            // echo $idConversation;
            // echo "Refresh";
            if (!$idConv) {
                // pas d'identifiant ! On redirige vers la page de choix de la conversation

                // NB : pose quelques soucis car on a déjà envoyé la bannière...
                // Il y a opportunité d'écrire cette bannière plus tard si on la place en absolu
                die('La conversation n\'existe pas');
            }

            // On récupère les paramètres de la conversation
            $dataConv = getConversation($idConv);
            if (!isAvailable($idConv)) {
                // La conversation n'existe pas !
                // header("Location:index.php?view=conversations");
                die("Vous n'avez pas accès à cette conversation !");
            }

            // Retrieve and display messages
            $messages = listerMessages($idConv);
            // tprint($messages);
            foreach ($messages as $message) {
                $contenu = $message['contenu'];
                $pseudo = $message['pseudo'];
                $couleur = $message['couleur'];
                $dateEnvoi = $message['dateEnvoi']; // Assuming dateEnvoi is in the format you desire
                $senderId = getIdByPseudo($pseudo);
                $senderId == $_SESSION["idUser"] ? $border = "right" : $border = "left";

                echo "<div class=\"chat-message mb-4 p-3 rounded-lg max-w-md clear-both float-$border\" style=\"border-$border: 5px solid $couleur;\">
					<div class=\"message-header font-bold\" style=\"color: $couleur;\">$pseudo</div>
					<div class=\"message-time text-gray-700 inline-block text-sm font-mono\">Envoyé le $dateEnvoi</div>
					<div class=\"message-body mt-1\">$contenu</div>
				  </div>";
            }
            echo '</div>';
            break;
        case "Creat Conversation":
            $theme = valider("theme");
            creerConversation($theme);
            break;
        case "Change Conversation Name":
            $newTheme = valider("newTheme");
            $idConv = valider("idConv");
            modifierConversationName($idConv, $newTheme);
            break;
        case "Refresh Conversations":
            $conversations = listerConversations("actives");
            // Generate the conversation options as a list
            $optionsList = '';
            foreach ($conversations as $conversation) {
                $id = $conversation['id'];
                $theme = $conversation['theme'];
                $optionsList .= "<li><a href=\"?view=conversations&idConv=$id\" data-id=\"$id\" class=\"block py-3 text-gray-800 hover:bg-gray-200 rounded-lg\">$theme</a></li>\n";
            }
            echo $optionsList;
            break;
        case "Config Conversation":
            include 'templates/configConversation.php';
            break;
        case "Add User":
            $id = getIdByPseudo(valider("pseudo"));
            $idConv = valider("idConv");
            addUsertoConversation($id, $idConv);
            break;
        case "Search Users":
            $pseudo = valider("pseudo");
            if ($pseudo) {
                $SQL = "SELECT pseudo FROM users WHERE pseudo LIKE '%$pseudo%'";
                $users = parcoursRs(SQLSelect($SQL));
                echo json_encode($users);
            } else {
                echo json_encode([]);
            }
            break;
        case "List Conversation Members":
            $idConv = valider("idConv");
            echo getUsersWithAccess($idConv, "json");
            break;
        case "Quit Conversation":
            $idConv = valider("idConv");
            supprimerUserFromConversation($_SESSION["idUser"], $idConv);
            break;
        case "Delete Conversation":
            $idConv = valider("idConv");
            archiverConversation($idConv);
            break;
        case "Delete Membre":
            $idConv = valider("idConv");
            $idMembre = valider("idMembre");
            supprimerUserFromConversation($idMembre, $idConv);
            break;
        // Search available cars on Cars page
        case "searchCar":
            $departure = valider("departure");
            $destination = valider("destination");
            $time = valider("time");
            // echo $departure;
            echo searchCars($departure, $destination, $time, "json");
            // $qs = "?view=cars";
            // $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            // $host = $_SERVER['HTTP_HOST'];
            // $script = dirname($_SERVER['SCRIPT_NAME']);

            // $urlBase = $protocol . $host . $script . "/index.php";

            // // On redirige vers la page index avec les bons arguments

            // header("Location:" . $urlBase . $qs);
            break;
        case "toggleCarReservation":
            $idAvailable = valider("idAvailable");
            $user_id = $_SESSION["idUser"];
            if ($idAvailable && $user_id) {
                toggleReservation($idAvailable, $user_id);
            }
            $qs = "?view=cars";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/" . "index.php";
            header("Location:" . $urlBase . $qs);
            break;
        // case "cancelReservation":
        //     $idAvailable = valider("idAvailable");
        //     $user_id = $_SESSION["idUser"];
        //     if ($idAvailable && $user_id) {
        //         toggleReservation($idAvailable, $user_id);
        //         updateCarAvailable($idAvailable, "reduce");
        //     }
        //     $qs = "?view=cars";
        //     $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        //     $host = $_SERVER['HTTP_HOST'];
        //     $script = dirname($_SERVER['SCRIPT_NAME']);

        //     $urlBase = $protocol . $host . $script . "/index.php";
        //     header("Location:" . $urlBase . $qs);
        //     break;
        case "registerCar":
            $user_id = $_SESSION["idUser"];
            $name = valider("nameCar");
            $license_plate = valider("license_plate");
            if ($user_id && $name && $license_plate) {
                registerCar($name, $license_plate, $user_id);
                $qs = "?view=cars";
            } else
                $qs = "?view=accueil";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";
            header("Location:" . $urlBase . $qs);
            break;
        case "uploadCar":
            $car_id = valider("carid");
            $carDeparture = valider("carDeparture");
            $available_from = valider("startTime");
            $available_to = valider("endTime");
            $passenger_limit = valider("passenger_limit");
            $idConversation = creerConversation($available_from);
            uploadCar($car_id, $available_from, $available_to, $carDeparture, $passenger_limit, $idConversation);
            $qs = "?view=cars";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";
            header("Location:" . $urlBase . $qs);
            break;
        case "removeCar":
            $car_id = valider("carid");
            $user_id = $_SESSION["idUser"];
            $idConversation = getIdConversation($car_id);
            $idAvailable = getIdAvailable($car_id);
            cancelAllReservations($idAvailable);
            deleteReservations($idAvailable);
            archiverConversation($idConversation);
            removeCar($idAvailable);

            $qs = "?view=cars";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";
            header("Location:" . $urlBase . $qs);
            break;
    } // fin switch(action)

} // fin if (action = ...)

// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat
// $urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
// // On redirige vers la page index avec les bons arguments
// On écrit seulement après cette entête
ob_end_flush();

?>