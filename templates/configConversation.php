<?php
$idConv = $_GET['idConv'] ?? '';
?>

<div id="config-container" class="mb-0">
    <form id="addUserForm">
        <input type="text" id="pseudo" placeholder="Pseudo de l'utilisateur"
            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        <button type="button" onclick="addUser()"
            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Ajouter
            utilisateur</button>
    </form>
    <div id="user-suggestions" class="mt-2"></div>
    <p id="info-add-member"></p>
    <h3 class="ml-10">User List</h3>
    <ul id="member-list" class="divide-y divide-gray-300 rounded-lg mt-4">

    </ul>

    <?php if (isAdminOfConversation($_SESSION["idUser"], valider("idConv"))): ?>
        <button onclick="deleteConversation()"
            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Delete Conversation
        </button>
    <?php else: ?>
        <button onclick="quitConversation()"
            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Quit Conversation
        </button>
    <?php endif; ?>
</div>