<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* PARTIE 1 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL
include_once ("maLibSQL.pdo.php");

function listerUtilisateurs($classe = "both", $format = "asso")
{
    // Cette fonction liste les utilisateurs de la base de données
    // et renvoie un tableau d'enregistrements.
    // Chaque enregistrement est un tableau associatif contenant les champs
    // id,pseudo,blacklist,connecte,couleur

    // Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
    // Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
    // Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

    $SQL = "SELECT * FROM users";
    if ($classe == "bl")
        $SQL .= " WHERE blacklist='1'";
    if ($classe == "nbl")
        $SQL .= " WHERE blacklist='0'";

    $SQL .= " ORDER BY pseudo ASC";

    $tabR = parcoursRs(SQLSelect($SQL));

    if ($format == "asso")
        return $tabR;
    else
        return json_encode($tabR);

}


function interdireUtilisateur($idUser)
{
    // cette fonction affecte le booléen "blacklist" à vrai pour l'utilisateur concerné
    $SQL = "UPDATE users SET blacklist='1' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function interdireUtilisateurParLogin($login)
{
    // cette fonction affecte le booléen "blacklist" à vrai pour l'utilisateur concerné
    $SQL = "UPDATE users SET blacklist='1' WHERE pseudo='$login'";
    SQLUpdate($SQL);
}


function autoriserUtilisateur($idUser)
{
    // cette fonction affecte le booléen "blacklist" à faux pour l'utilisateur concerné
    $SQL = "UPDATE users SET blacklist='0' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function verifUserBdd($login, $passe)
{
    // Vérifie l'identité d'un utilisateur
    // dont les identifiants sont passes en paramètre
    // renvoie faux si user inconnu
    // renvoie l'id de l'utilisateur si succès

    $SQL = "SELECT id FROM users WHERE pseudo='$login' AND passe='$passe'";
    return SQLGetChamp($SQL);
    // $res = parcoursRs(SQLSelect($SQL));
    // if(count($res) == 0) return false;
    // else return $res[0]["id"];

    // si on avait besoin de plus d'un champ
    // on aurait du utiliser SQLSelect
}


function isAdmin($idUser)
{
    // vérifie si l'utilisateur est un administrateur
    $SQL = "SELECT admin FROM users WHERE id='$idUser'";
    return SQLGetChamp($SQL);
}

/********* PARTIE 2 *********/

function mkUser($pseudo, $passe, $admin = false, $couleur = "blue")
{
    // 检查是否已经存在相同的 pseudo
    $SQL = "SELECT COUNT(*) as count FROM users WHERE pseudo = '$pseudo'";
    $result = parcoursRs(SQLSelect($SQL));
    echo $result;
    if ($result[0]['count'] > 0) {
        // 如果存在相同的 pseudo，返回 false
        return false;
    }

    // 如果不存在相同的 pseudo，插入新用户
    $SQL = "INSERT INTO users(pseudo, passe, admin, couleur) VALUES('$pseudo', '$passe', '"
        . (($admin) ? "1" : "0")
        . "', '$couleur')";
    return SQLInsert($SQL);
}


// if (condition) {// bloc si} else {// bloc sinon }
// VARIABLE =  (condition) ? valeur_si : valeur_sinon


function getIdByPseudo($pseudo)
{
    $SQL = "SELECT id FROM users WHERE pseudo='$pseudo'";
    $tab = parcoursRs(SQLSelect($SQL));

    if (count($tab) == 1) {
        return $tab[0]['id']; // 返回找到的用户ID
    } else {
        return false; // 如果未找到用户，返回false
    }
}

function getPseudo($userId)
{
    $SQL = "SELECT pseudo FROM users WHERE id='$userId'";
    $tab = parcoursRs(SQLSelect($SQL));

    if (count($tab) == 1) {
        return $tab[0]['pseudo']; // 返回找到的用户伪昵称
    } else {
        return false; // 如果未找到用户，返回false
    }
}


function connecterUtilisateur($idUser)
{

    // cette fonction affecte le booléen "connecte" à vrai pour l'utilisateur concerné
    $SQL = "UPDATE users SET connecte='1' WHERE id='$idUser'";

    SQLUpdate($SQL);

}

function deconnecterUtilisateur($idUser)
{
    // cette fonction affecte le booléen "connecte" à faux pour l'utilisateur concerné
    $SQL = "UPDATE users SET connecte='0' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function changerCouleur($idUser, $couleur = "black")
{
    // cette fonction modifie la valeur du champ 'couleur' de l'utilisateur concerné
    $SQL = "UPDATE users SET couleur='$couleur' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function getCouleur($idUser)
{
    // Cette fonction renvoie la couleur d'un utilisateur donné par son id
    $SQL = "SELECT couleur FROM users WHERE id='$idUser' AND blacklist=0 LIMIT 1";
    $result = parcoursRs(SQLSelect($SQL));

    if (count($result) > 0) {
        return $result[0]['couleur'];
    } else {
        return "black"; // Retourne null si l'utilisateur n'existe pas ou est blacklisté
    }
}


function changerPasse($idUser, $passe)
{
    // cette fonction modifie le mot de passe d'un utilisateur
    $SQL = "UPDATE users SET passe='$passe' WHERE id='$idUser'";
    // NEVER TRUST USER INPUT
// Attention aux injections SQL, exemple si passe="toto' WHERE id=1; drop table users;" 
    SQLUpdate($SQL);
}

function changerPseudo($idUser, $pseudo)
{
    // cette fonction modifie le pseudo d'un utilisateur
    $SQL = "UPDATE users SET pseudo='$pseudo' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function promouvoirAdmin($idUser)
{
    // cette fonction fait de l'utilisateur un administrateur
    $SQL = "UPDATE users SET admin='1' WHERE id='$idUser'";
    SQLUpdate($SQL);
}

function retrograderUser($idUser)
{
    // cette fonction fait de l'utilisateur un simple mortel
    $SQL = "UPDATE users SET admin='0' WHERE id='$idUser'";
    SQLUpdate($SQL);
}


function supprimerUser($idUser)
{
    // TODO : penser à supprimer les messages de cet utilisateur !
    $SQL = "DELETE FROM users WHERE id='$idUser'";
    SQLDelete($SQL);
}

function reautoriserTous()
{
    $SQL = "Update users SET blacklist=0 WHERE id IN (SELECT * FROM users WHERE blacklist=1)";
    SQLDelete($SQL);
}

/********* PARTIE 3 *********/

function listerUtilisateursConnectes()
{
    // Liste les utilisteurs connectes
    $SQL = "SELECT * FROM users  WHERE connecte='1'";
    return parcoursRs(SQLSelect($SQL));
}

function listerConversations($mode = "tout")
{
    // 获取当前用户的ID
    $idUser = $_SESSION["idUser"];

    // 初始SQL查询，使用JOIN语句确保只获取当前用户有权限访问的聊天记录
    $SQL = "SELECT c.* FROM conversations c
            JOIN conversation_visibility cv ON c.id = cv.idConversation
            WHERE cv.idUser = $idUser";

    // 根据模式追加相应的过滤条件
    if ($mode == "actives") {
        $SQL .= " AND c.active = '1'";
    } elseif ($mode == "inactives") {
        $SQL .= " AND c.active = '0'";
    }

    // 按ID升序排列结果
    $SQL .= " ORDER BY c.id ASC";

    // 执行SQL查询并返回结果
    return parcoursRs(SQLSelect($SQL));
}

function getTheme($idConv)
{
    if (!isAvailable($idConv)) {
        return false;
    }
    $SQL = "SELECT * FROM conversations WHERE id = '$idConv'";
    return parcoursRs(SQLSelect($SQL))[0]["theme"];
}

function archiverConversation($idConversation)
{
    // rend une conversation inactive
    $SQL = "UPDATE conversations SET active='0' WHERE id='$idConversation'";
    SQLUpdate($SQL);
}

function reactiverConversation($idConversation)
{
    // rend une conversation active
    $SQL = "UPDATE conversations SET active='1' WHERE id='$idConversation'";
    SQLUpdate($SQL);
}


function creerConversation($theme)
{
    // 获取当前用户的ID
    $adminId = $_SESSION["idUser"];

    // 准备 SQL 查询语句，将 theme 和 admin_id 插入 conversations 表
    $SQL = "INSERT INTO conversations(theme, admin_id) VALUES('$theme', '$adminId')";
    $conversationId = SQLInsert($SQL);

    // 将当前用户添加到新会话的可见性列表中
    $SQL = "INSERT INTO conversation_visibility(idUser, idConversation) VALUES($adminId, $conversationId)";
    SQLInsert($SQL);

    // 返回新会话的ID
    return $conversationId;
}

function isAdminOfConversation($idUser, $idConv)
{
    // 查询 conversations 表，检查给定 idConv 是否存在并且管理员是当前用户
    $SQL = "SELECT admin_id FROM conversations WHERE id = $idConv";
    $result = parcoursRs(SQLSelect($SQL));

    if (count($result) == 1 && $result[0]['admin_id'] == $idUser) {
        return true;
    } else {
        return false;
    }
}

function addUsertoConversation($idUser, $conversationId)
{
    // 首先检查用户是否已经在该对话中
    if (!isUserInConversation($idUser, $conversationId)) {
        // 如果用户不在对话中，则执行插入操作
        $SQL = "INSERT INTO conversation_visibility(idUser, idConversation) VALUES($idUser, $conversationId)";
        SQLInsert($SQL);
    } else {
        // 如果用户已经在对话中，可以选择返回错误或者采取其他操作
        echo "User [" . getPseudo($idUser) . "] is already in conversation [" . getTheme($conversationId) . "].";
        // 或者抛出异常，返回错误信息等等
    }
}

// 检查用户是否在对话中的函数
function isUserInConversation($idUser, $conversationId)
{
    $SQL = "SELECT COUNT(*) AS count FROM conversation_visibility WHERE idUser = $idUser AND idConversation = $conversationId";
    $result = parcoursRs(SQLSelect($SQL));
    return $result[0]['count'] > 0;
}

function supprimerUserFromConversation($idUser, $conversationId)
{
    $SQL = "DELETE FROM conversation_visibility WHERE idUser = $idUser AND idConversation = $conversationId";
    SQLUpdate($SQL); // Assuming SQLUpdate handles DELETE queries
}

function supprimerConversation($idConv)
{
    // supprime une conversation et ses messages
    $SQL = "DELETE FROM messages WHERE idConversation='$idConv'";
    SQLDelete($SQL);

    $SQL = "DELETE FROM conversations WHERE id='$idConv'";
    SQLDelete($SQL);

    // NB : on aurait pu aussi demander à mysql de supprimer automatiquement
    // les messages lorsqu'une conversation est supprimée,
    // en déclarant idConversation comme clé étrangère vers le champ id de la table
    // des conversations et en définissant un trigger
}

function isAvailable($idConv)
{
    if (!$idConv) {
        return false;
    }
    // 获取当前用户的ID
    $idUser = $_SESSION["idUser"];

    // 检查给定的 idConv 是否存在于 conversations 表中
    $SQL = "SELECT COUNT(*) as count FROM conversations WHERE id = $idConv";
    $result = parcoursRs(SQLSelect($SQL));
    // echo tprint($result);
    if ($result[0]['count'] == 0) {
        // 如果 idConv 不存在，返回 false
        return false;
    }

    // 检查当前用户是否有资格访问该 idConv
    $SQL = "SELECT COUNT(*) as count FROM conversation_visibility 
            WHERE idConversation = $idConv AND idUser = $idUser";
    $result = parcoursRs(SQLSelect($SQL));

    // // 返回是否有访问权限
    return $result[0]['count'] > 0;
}

function getUsersWithAccess($idConv, $format = "asso")
{
    // 检查给定的 idConv 是否存在于 conversations 表中
    $SQL = "SELECT COUNT(*) as count FROM conversations WHERE id = $idConv";
    $result = parcoursRs(SQLSelect($SQL));

    if ($result[0]['count'] == 0) {
        // 如果 idConv 不存在，返回空数组
        return [];
    }

    // 查询所有有资格访问 idConv 的用户
    $SQL = "SELECT u.* FROM users u
            INNER JOIN conversation_visibility cv ON u.id = cv.idUser
            WHERE cv.idConversation = $idConv";

    $tabR = parcoursRs(SQLSelect($SQL));

    if ($format == "asso")
        return $tabR;
    else
        return json_encode($tabR);
}

function modifierConversationName($idConversation, $newTheme)
{
    // supprime une conversation et ses messages
    $SQL = "UPDATE conversations SET theme='$newTheme' WHERE id='$idConversation'";
    SQLUpdate($SQL);

    // NB : on aurait pu aussi demander à mysql de supprimer automatiquement
    // les messages lorsqu'une conversation est supprimée,
    // en déclarant idConversation comme clé étrangère vers le champ id de la table
    // des conversations et en définissant un trigger
}

function enregistrerMessage($idConversation, $idAuteur, $contenu)
{
    // echo "enregistrer";
    // Enregistre un message dans la base en encodant les caractères spéciaux HTML : <, > et & pour interdire les messages HTML

    // ATTENTION AUX FAILLES XSS 'cross-site-scripting'
    // AKA 'injection JS'
    // ATTENTION AUX FAILLES XSS 'cross-site-scripting'
    // AKA 'injection JS'

    // Échapper le contenu pour prévenir les injections SQL et encoder les caractères spéciaux HTML
    $contenu = htmlspecialchars($contenu);

    // Utiliser NOW() pour obtenir le timestamp actuel
    $SQL = "INSERT INTO messages(contenu, idAuteur, idConversation, dateEnvoi) 
            VALUES ('$contenu', '$idAuteur', '$idConversation', NOW())";
    // echo $SQL;
    // Exécuter la requête SQL et retourner le résultat de l'insertion
    return SQLInsert($SQL);
}


function listerMessages($idConv, $format = "asso")
{
    // Liste les messages de cette conversation, au format JSON ou tableau associatif
    // Champs à extraire : contenu, auteur, couleur
    // en ne renvoyant pas les utilisateurs blacklistés
    $SQL = "SELECT m.contenu, u.pseudo, u.couleur, m.dateEnvoi FROM messages m INNER JOIN users u ON m.idAuteur=u.id WHERE idConversation='$idConv' AND u.blacklist=0 ORDER BY m.id ASC";

    $tabR = parcoursRs(SQLSelect($SQL));

    if ($format == "asso")
        return $tabR;
    else
        return json_encode($tabR);
}

function listerMessagesFromIndex($idConv, $index)
{
    // Liste les messages de cette conversation,
    // dont l'id est superieur à l'identifiant passé
    // Champs à extraire : contenu, auteur, couleur
    // en ne renvoyant pas les utilisateurs blacklistés

}

function getConversation($idConv)
{
    if (!isAvailable($idConv)) {
        return false;
    }
    // Récupère les données de la conversation (theme, active)
    $SQL = "SELECT theme, active FROM conversations WHERE id='$idConv'";
    // au plus un enregistrement
    $tab = parcoursRs(SQLSelect($SQL));
    if (count($tab) == 1)
        return $tab[0];
    else
        return array();
}

function listerPlans($idUser = 0)
{
    $SQL = "SELECT * FROM plans";
    // if idUser=0, return all plans
    // else return the plans of idUser
    if ($idUser) {
        $SQL = "SELECT plan_id FROM user_plan WHERE user_id=$idUser";
        $planIDs = parcoursRs(SQLSelect($SQL));
        $plans = [];
        foreach ($planIDs as $planID) {
            $SQL = "SELECT * FROM plans WHERE id=$planID[plan_id]";
            $plan = parcoursRs(SQLSelect($SQL));
            $plans[] = $plan[0];
        }
        return $plans;
    }
    return parcoursRs(SQLSelect($SQL));

}

function listerReservations($idUser)
{
    $SQL = "SELECT * FROM reservations WHERE id_user=$idUser";
    return parcoursRs(SQLSelect($SQL));
}

function getPlanById($idPlan)
{
    $SQL = "SELECT * FROM plans WHERE id=$idPlan";
    return parcoursRs(SQLSelect($SQL));
}

function getReservationById($idReservation)
{
    $SQL = "SELECT * FROM reservations WHERE id=$idReservation";
    return parcoursRs(SQLSelect($SQL));
}

function getUsersOfPlan($idPlan)
{
    $SQL = "SELECT user_id FROM user_plan WHERE plan_id=$idPlan";
    $usersIds = parcoursRs(SQLSelect($SQL));
    //tprint($usersIds);
    $users = [];
    foreach ($usersIds as $userId) {
        $SQL = "SELECT * FROM users WHERE id=$userId[user_id]";
        $user = parcoursRs(SQLSelect($SQL));
        $users[] = $user[0];
    }
    //tprint($users);
    return $users;
}

function getUsersOfReservation($idReservation)
{
    $SQL = "SELECT id_cars_avail FROM reservations WHERE id=$idReservation";
    $id_car_avail = parcoursRs(SQLSelect($SQL))[0]["id_cars_avail"];
    $SQL = "SELECT id_user FROM reservations WHERE id_cars_avail=$id_car_avail";
    return parcoursRs(SQLSelect($SQL));

}

function getCarAvailOfReservation($idConservation)
{
    $SQL = "SELECT id_cars_avail FROM reservations WHERE id='$idConservation'";
    $id_car_avail = parcoursRs(SQLSelect($SQL))[0];
    $SQL = "SELECT * FROM car_availability WHERE id=$id_car_avail[id_cars_avail]";
    $carAvail = parcoursRs(SQLSelect($SQL));
    return $carAvail[0];
}

// --- CAR PART  ---

function getAllAvailableCars()
{
    $SQL = "SELECT * FROM car_availability";
    $cars = parcoursRs(SQLSelect($SQL));
    return $cars;
}

function getAllAvailableCarsID() {
    $SQL = "SELECT car_id FROM car_availability";
    $carsId = parcoursRs(SQLSelect($SQL));
    return $carsId;
}

function getCarInfo($carid) {
    $SQL = "SELECT name FROM cars WHERE id = $carid";
    $result = parcoursRs(SQLSelect($SQL));
    if (count($result) > 0) {
        $carName = $result[0]['name'];
    }
    else
        $carName = false;
    return $carName;
}

function searchCars($departure, $destination, $time, $format = "asso")
{
    // 构建 SQL 查询语句，使用条件判断来处理空值情况
    $SQL = "SELECT * FROM car_availability WHERE available = 1";
    
    if (!empty($departure)) {
        $SQL .= " AND departure = '$departure'";
    }
    
    if (!empty($time)) {
        $SQL .= " AND available_from <= '$time' AND available_to >= '$time'";
    }
    
    // 执行 SQL 查询并处理结果
    $tabR = parcoursRs(SQLSelect($SQL));

    // 获取每辆车的名称并添加到结果中，并检查预订状态
    foreach ($tabR as &$car) {
        $car_id = $car['car_id'];
        $car['carName'] = getCarInfo($car_id); // 假设getCarInfo函数可以获取车辆名字
        
        // 检查当前用户是否已经预订了这辆车
        $user_id = $_SESSION["idUser"];
        $reservationSQL = "SELECT * FROM reservations WHERE id_cars_avail = '{$car['id']}' AND id_user = '$user_id' AND status='Ready'";
        $reservation = parcoursRs(SQLSelect($reservationSQL));
        
        // 设置预订标志
        $car['isReserved'] = !empty($reservation) ? 1 : 0;
    }
    unset($car); // 释放引用

    if ($format == "asso") {
        return $tabR;
    } else {
        return json_encode($tabR);
    }
}

function toggleReservation($idAvailable, $user_id) {
    // Check if a reservation already exists
    $checkSQL = "SELECT status FROM reservations WHERE id_cars_avail = '$idAvailable' AND id_user = '$user_id'";
    $existingReservation = parcoursRs(SQLSelect($checkSQL));

    if (empty($existingReservation)) {
        // If no reservation exists, insert a new one with status "Ready"
        $insertSQL = "INSERT INTO reservations (id_cars_avail, id_user, time_reservation, status)
                      VALUES ('$idAvailable', '$user_id', NOW(), 'Ready')";
        SQLInsert($insertSQL);
        updateCarAvailable($idAvailable, "add");
    } else {
        // If a reservation exists, toggle the status
        $currentStatus = $existingReservation[0]['status'];
        if ($currentStatus == 'Ready') {
            // Change status to "Canceled" and reduce reservation number
            $newStatus = 'Canceled';
            $updateSQL = "UPDATE reservations 
                          SET status = '$newStatus' 
                          WHERE id_cars_avail = '$idAvailable' AND id_user = '$user_id'";
            SQLUpdate($updateSQL);
            updateCarAvailable($idAvailable, "reduce");
        } else {
            // Change status to "Ready" and add reservation number
            $newStatus = 'Ready';
            $updateSQL = "UPDATE reservations 
                          SET status = '$newStatus' 
                          WHERE id_cars_avail = '$idAvailable' AND id_user = '$user_id'";
            SQLUpdate($updateSQL);
            updateCarAvailable($idAvailable, "add");
        }
    }
}


function isReserved($user_id, $car_id) {
    $SQL = "SELECT * FROM reservations WHERE id_user = $user_id AND id_cars_avail = $car_id";
    $reservation = parcoursRs(SQLSelect($SQL));
    return $reservation;
}

function updateCarAvailable($car_id, $operation) {
    // 查询当前的 passenger_limit 和 reservation_number
    $SQL = "SELECT passenger_limit, reservation_number FROM car_availability WHERE id = $car_id";
    $result = parcoursRs(SQLSelect($SQL));

    if (!empty($result)) {
        $passenger_limit = $result[0]['passenger_limit'];
        $reservation_number = $result[0]['reservation_number'];

        // 确保 passenger_limit 存在且大于0
        if ($passenger_limit > 0) {
            if ($operation === 'add' && $reservation_number < $passenger_limit) {
                // 增加 reservation_number
                $reservation_number += 1;
            } elseif ($operation === 'reduce' && $reservation_number > 0) {
                // 减少 reservation_number
                $reservation_number -= 1;
            }

            // 计算新的 available 状态
            $new_available = ($reservation_number < $passenger_limit) ? 1 : 0;

            // 更新 car_availability 表
            $sql = "UPDATE car_availability 
                    SET reservation_number = '$reservation_number', available = '$new_available' 
                    WHERE id = '$car_id'";
            SQLUpdate($sql);
        }
    }
}


// function cancelReservation($idAvailable, $user_id) {
//     $SQL = "DELETE FROM reservations WHERE id_cars_avail = $idAvailable AND id_user = $user_id";
//     SQLDelete($SQL);
// }

// function returnCarAvailable($idAvailable) {
//     $SQL = "SELECT passenger_limit FROM car_availability WHERE id = $idAvailable";
//     $passenger_limit = parcoursRs(SQLSelect($SQL))[0]['passenger_limit'];
//     $new_passenger_limit = $passenger_limit + 1;
//     $sql = "UPDATE car_availability SET passenger_limit = '$new_passenger_limit', available = 1 WHERE id = '$idAvailable'";
//     SQLUpdate($sql);
// }

function registerCar($name, $license_plate, $user_id) {
    $SQL = "INSERT INTO cars (name, license_plate, owner_id)
    VALUES ('$name', '$license_plate', '$user_id')";
    SQLInsert($SQL);
}

function listerAllCarsOwend($user_id) {
    $SQL = "SELECT * FROM cars WHERE owner_id = '$user_id'";
    $cars = parcoursRs(SQLSelect($SQL));
    return $cars;
}

function uploadCar($car_id, $available_from, $available_to, $departure, $passenger_limit, $idConversation) {
    $SQL = "INSERT INTO car_availability (car_id, available_from, available_to, departure, passenger_limit, idConversation)
    VALUES ('$car_id', '$available_from', '$available_to', '$departure', '$passenger_limit', '$idConversation')";
    SQLInsert($SQL);
}

function getIdConversation($carid) {
    $SQL = "SELECT idConversation FROM car_availability WHERE car_id = $carid";
    $idConversation = parcoursRs(SQLSelect($SQL))[0]['idConversation'];
    return $idConversation;
}

function removeCar($idAvailable) {
    $SQL = "DELETE FROM car_availability WHERE id = $idAvailable";
    SQLDelete($SQL);
}

function getIdAvailable($car_id) {
    $SQL = "SELECT id FROM car_availability WHERE car_id = $car_id && available = 1";
    $idAvailable = parcoursRs(SQLSelect($SQL))[0]['id'];
    return $idAvailable;
}

function cancelAllReservations($idAvailable) {
    $SQL = "UPDATE reservations SET status = 'Canceled' WHERE id_cars_avail = $idAvailable";
    SQLUpdate($SQL);
}

function deleteReservations($idAvailable) {
    $SQL = "DELETE FROM reservations WHERE id_cars_avail = $idAvailable";
    SQLDelete($SQL);
}

?>