<main id="site-main">
    <div id="conversation-list-container">
        <?php
        // Ce fichier permet de tester les fonctions développées dans le fichier malibforms.php
        
        // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
        if (basename($_SERVER["PHP_SELF"]) == "conversationList.php") {
            header("Location:../index.php?view=conversationList");
            die("Please login first!");
        }
        // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
        if (basename($_SERVER["PHP_SELF"]) != "index.php") {
            $qs = "?view=conversationList";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $host = $_SERVER['HTTP_HOST'];
            $script = dirname($_SERVER['SCRIPT_NAME']);

            $urlBase = $protocol . $host . $script . "/index.php";
            header("Location:" . $urlBase . $qs);
        }
        include_once ("libs/modele.php"); // listes
        include_once ("libs/maLibUtils.php");// tprint
        include_once ("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...
        
        // 检查表单提交
        $selectedId = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selectedId = $_POST['conversation'] ?? '';
        }
        // enregistrerMessage(1, 1, "Bonjour");
        
        $idConv = $_COOKIE['idConv'] ?? ''; // 这里使用 GET 方式获取 idConv
        ?>
        <form id="createConversationForm" class="mb-4" onsubmit="event.preventDefault(); createConversation();">
            <input type="text" id="conversationTitleInput" placeholder="Titre de la nouvelle conversation"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-<?php echo getCouleur($_SESSION["idUser"]); ?>-500">
            <button type="submit"
                class="w-full mt-2 px-4 py-2 bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 text-white rounded-lg hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 focus:outline-none focus:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600">
                Créer la conversation
            </button>
        </form>
        <p id="info-create-conversation"></p>
        <h3 class="text-lg font-semibold mb-2">Conversations</h3>
        <ul class="divide-y divide-gray-200 list-none px-1" id="conversationsList">
        </ul>
    </div>
</main>

<script src="js/conversationList.js"></script>