<?php
if (isset($_GET['view']) && $_GET['view'] === 'conversations' && isset($_GET['idConv'])) {
	$idConv = $_GET['idConv'];
	?>

	<div id="messages-container" class="mb-0">
		<!-- 聊天消息的显示区域，添加底部外边距留给表单 -->
	</div>

	<form id="messageForm" action="controleur.php" method="POST"
		class="sticky bottom-0 bg-white p-4 rounded-lg shadow-lg flex flex-row" style="right: 5%; max-width: 100%;">
		<!-- 消息输入框 -->
		<input type="text" id="messageInput" placeholder="Tapez votre message" name="message"
			class="focus:outline-none focus:border-<?php echo getCouleur($_SESSION["idUser"]); ?>-500">
		<!-- 提交按钮 -->
		<button type="button" name="action" value="Envoyer Message" onclick="envoyerMessage()" id="msg-submit-btn"
			class="ml-2 px-4 py-2 bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 text-white rounded-lg hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 focus:outline-none focus:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600">Envoyer
		</button>
	</form>
	<p id="messageLengthWarning"></p>

	<?php
} else {
	echo '<p id="conversation-info">Sélectionnez une conversation pour afficher le chat ici.</p>';
}
?>