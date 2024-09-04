<main id="site-main">
	<?php
	// Ce fichier permet de tester les fonctions développées dans le fichier malibforms.php
	if (!valider("connecte", "SESSION")) {
		$qs = "?view=login";
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$script = dirname($_SERVER['SCRIPT_NAME']);

		$urlBase = $protocol . $host . $script . "/index.php";
		header("Location:" . $urlBase . $qs);
		die("Please login first!");
	}
	if (basename($_SERVER["PHP_SELF"]) != "index.php") {
		$qs = "?view=conversations";
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$script = dirname($_SERVER['SCRIPT_NAME']);

		$urlBase = $protocol . $host . $script . "/index.php";
		header("Location:" . $urlBase . $qs);
	}
	// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
	if (basename($_SERVER["PHP_SELF"]) == "conversations.php") {
		header("Location:../index.php?view=conversations");
	}
	include_once ("libs/modele.php"); // listes
	include_once ("libs/maLibUtils.php");// tprint
	include_once ("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...
	
	// 检查表单提交
	$selectedId = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$selectedId = $_POST['conversation'] ?? '';
	}
	if (!isset($_GET['idConv'])) {
		$qs = "?view=conversationList";
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = $_SERVER['HTTP_HOST'];
		$script = dirname($_SERVER['SCRIPT_NAME']);

		$urlBase = $protocol . $host . $script . "/index.php";
		header("Location:" . $urlBase . $qs);
	}

	$idConv = $_GET['idConv'] ?? ''; // 这里使用 GET 方式获取 idConv
	?>
	<div id="cadre-conversations" class="grid grid-cols-3 gap-4">
		<div id="left-pane" class="col-span-1 p-6 bg-white rounded-lg shadow-lg">
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
		<div id="right-pane" class="col-span-2 p-6 bg-gray-100 rounded-lg shadow-lg relative">
			<div id="right-pane-header">
				<div id="toConversation" class="p-4">
					<a href="index.php?view=conversationList"
						class="bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 text-white px-4 py-2 rounded-lg hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 focus:outline-none focus:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 no-underline">
						Back
					</a>
				</div>

				<h2 id="message-theme"
					style="width: 70%; height: 40px; line-height: 40px; text-align: center; cursor: pointer;"
					ondblclick="enableEdit(this)">
					<?php echo getTheme($idConv); ?>
				</h2>
				<div id="config-button" style="top: 10px; right: 10px;">
					<a href="index.php?view=conversations&idConv=<?php echo $idConv; ?>&config=<?php $config = $_GET['config'] ?? '';
					   $newConfig = $config == 1 ? 0 : 1;
					   echo $newConfig; ?>">
						<svg version="1.1" x="0px" y="0px" width="30" viewBox="0 0 75.7 72.6"
							style="enable-background:new 0 0 75.7 72.6;" xml:space="preserve">
							<g id="XMLID_11_">
								<g id="XMLID_29_">
									<path id="XMLID_30_" class="st0" d="M65.2,36.9l7.7-2.4l-1.6-9.3l-8.1,0.6c-1-2.3-2.3-4.4-3.8-6.4l4.4-6.9l-7.2-6.1l-5.9,5.8
			c-2.1-1.1-4.4-1.9-6.9-2.4l-1.1-8.2h-9.5l-0.8,8.4c-2.3,0.6-4.6,1.4-6.6,2.5l-6.3-5.7L12.1,13l4.9,7.1c-1.4,1.8-2.5,3.9-3.4,6.1
			L5,25.8l-1.6,9.3l8.4,2.3c0.1,2.4,0.5,4.6,1.2,6.8l-6.8,5.3l4.7,8.2l7.9-3.6c1.6,1.7,3.4,3.2,5.4,4.5L22.3,67l8.9,3.2l3.7-7.6
			c1.2,0.2,2.4,0.3,3.7,0.3c1.2,0,2.4-0.1,3.5-0.2l3.9,7.4l8.9-3.2l-2.1-8c2.1-1.3,4-2.9,5.6-4.7l7.5,3.1l4.7-8.2l-6.6-4.7
			C64.7,41.9,65.1,39.5,65.2,36.9z" />
								</g>
								<g id="XMLID_25_">
									<path id="XMLID_26_" class="st1" d="M65.2,36.9l7.7-2.4l-1.6-9.3l-8.1,0.6c-1-2.3-2.3-4.4-3.8-6.4l4.4-6.9l-7.2-6.1l-5.9,5.8
			c-2.1-1.1-4.4-1.9-6.9-2.4l-1.1-8.2h-9.5l-0.8,8.4c-2.3,0.6-4.6,1.4-6.6,2.5l-6.3-5.7L12.1,13l4.9,7.1c-1.4,1.8-2.5,3.9-3.4,6.1
			L5,25.8l-1.6,9.3l8.4,2.3c0.1,2.4,0.5,4.6,1.2,6.8l-6.8,5.3l4.7,8.2l7.9-3.6c1.6,1.7,3.4,3.2,5.4,4.5L22.3,67l8.9,3.2l3.7-7.6
			c1.2,0.2,2.4,0.3,3.7,0.3c1.2,0,2.4-0.1,3.5-0.2l3.9,7.4l8.9-3.2l-2.1-8c2.1-1.3,4-2.9,5.6-4.7l7.5,3.1l4.7-8.2l-6.6-4.7
			C64.7,41.9,65.1,39.5,65.2,36.9z" />
								</g>
								<circle id="XMLID_14_" class="st2" cx="38.5" cy="36.1" r="23" />
								<circle id="XMLID_15_" class="st3" cx="38.5" cy="36.1" r="12.8" />
								<circle id="XMLID_16_" class="st4" cx="38.5" cy="36.1" r="10.5" />
							</g>

						</svg>
					</a>
				</div>
			</div>
			<?php
			// 根据 GET 参数 config 的值决定包含哪个 PHP 文件
			if (isset($_GET['config']) && $_GET['config'] == 1) {
				include ("templates/configConversation.php");
			} else {
				include ("templates/chat.php");
			}
			?>
		</div>
</main>

<!-- Refresh Conversations -->
<script src="js/conversationList.js">

</script>


<!-- About Conversation -->
<?php
// 如果 config 等于 1，则不输出该段 script
if ($idConv != '' and $_GET['config'] != 1) {
	?>
	<script>

		refreshMessages();

		document.getElementById('messageInput').addEventListener('input', function () {
			const messageLength = this.value.length;
			const maxLength = 255; // 设定最大长度为 200 字符
			document.getElementById('messageLengthWarning').style.color = "red";

			if (messageLength > maxLength) {
				// 超过最大长度，发出警告
				document.getElementById('messageLengthWarning').textContent = 'Message length exceeds maximum limit!';
				// 可以根据需要修改样式或者显示其他提示方式
			} else {
				// 未超过最大长度，清空警告
				document.getElementById('messageLengthWarning').textContent = '';
			}
		});

		function envoyerMessage() {
			// 获取表单元素

			const idConv = "<?php echo htmlspecialchars($idConv); ?>";
			if (idConv == "") {
				return;
			}
			const message = document.getElementById('messageInput').value;



			const action = document.getElementById('msg-submit-btn').value;
			// 打印数据进行调试
			console.log('idConv:', idConv);
			console.log('message:', message);
			console.log('action:', action);

			// 创建一个 XMLHttpRequest 对象
			const xhr = new XMLHttpRequest();

			// 配置 POST 请求
			xhr.open('POST', 'controleur.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

			// 处理服务器响应
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收服务器响应后的处理
					console.log(xhr.responseText);
					// 可以在这里根据需要执行其他操作，例如清空输入框
					document.getElementById('messageInput').value = '';
				} else {
					// 处理错误情况
					console.error('Erreur lors de la requête AJAX :', xhr.status, xhr.statusText);
				}
			};

			// 发送请求
			const params = 'idConv=' + encodeURIComponent(idConv) +
				'&message=' + encodeURIComponent(message) +
				'&action=' + encodeURIComponent(action);
			console.log(params);
			xhr.send(params);
			refreshMessages();
		}
		// 定义函数来定时刷新消息
		function refreshMessages() {
			if (document.getElementById('messages-container') == null) {
				return;
			}
			const idConv = "<?php echo htmlspecialchars($idConv); ?>";
			if (idConv == "") {
				return;
			}
			const xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					var messagesContainer = document.getElementById('messages-container');
					messagesContainer.innerHTML = xhr.responseText;
					// console.log(xhr.status, xhr.responseText);
				} else {
					console.error('Error fetching messages:', xhr.statusText);
				}
			};
			xhr.onerror = function () {
				console.error('Request failed');
			};
			const params = "idConv=" + encodeURIComponent(idConv) +
				"&action=" + encodeURIComponent("Refresh Message");
			// console.log(params);
			xhr.send(params);
		}

		// 每3秒刷新一次消息
		setInterval(refreshMessages, 3000); // 3000毫秒 = 3秒
		// 获取输入框和按钮元素
		var messageInput = document.getElementById('messageInput');
		var submitButton = document.getElementById('msg-submit-btn');

		// 当按下 Enter 键时触发发送消息
		messageInput.addEventListener('keypress', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				envoyerMessage();
			}
		});

		// 当按下 Esc 键时清空输入框内容
		messageInput.addEventListener('keyup', function (e) {
			if (e.key === 'Escape') {
				e.preventDefault();
				messageInput.value = '';
			}
		});

	</script>
	<?php
} // 结束条件语句
?>
<script>

	// edit conversation name
	function enableEdit(element) {
		// 获取当前主题名称
		const idConv = "<?php echo htmlspecialchars($idConv); ?>";
		if (idConv == "") {
			return;
		}
		const currentTheme = element.innerText.trim();

		// 创建一个输入框来编辑主题
		const input = document.createElement('input');
		input.type = 'text';
		input.value = currentTheme;
		input.classList.add('border', 'border-gray-300', 'rounded-lg', 'px-2', 'py-1', 'focus:outline-none', 'focus:border-blue-500');

		// 将输入框替换原来的 h2 元素
		element.innerHTML = '';
		element.appendChild(input);

		// 聚焦到输入框
		input.focus();

		// 监听键盘事件
		input.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				submitEdit();
			} else if (event.key === 'Escape') {
				event.preventDefault();
				cancelEdit();
			}
		});

		// 添加事件监听器，处理编辑完成事件
		function submitEdit() {
			let newTheme = input.value.trim();
			if (newTheme === '') {
				newTheme = 'New Conversation';
			}
			element.innerHTML = newTheme;

			// 发送 AJAX 请求保存新主题
			const xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					console.log('Le nom de la conversation a été modifié avec succès.');
				} else {
					console.error('Erreur lors de la modification du nom de la conversation :', xhr.status, xhr.statusText);
				}
			};
			const params = 'action=Change%20Conversation%20Name&newTheme=' + encodeURIComponent(newTheme) + '&idConv=' + encodeURIComponent(idConv);
			xhr.send(params);
			refreshConversations();
		}

		// 取消编辑
		function cancelEdit() {
			// element.innerHTML = '';
			console.log("cancel");
			element.innerHTML = currentTheme;
		}
	}
</script>

<!-- About Config -->
<?php
// 如果 config 等于 1，则不输出该段 script
if (isset($_GET['config']) and $_GET['config'] != 0) {
	?>
	<script>
		function addUser() {
			const idConv = "<?php echo htmlspecialchars($idConv); ?>";
			if (idConv == "") {
				return;
			}
			const userPseudo = document.getElementById("pseudo").value;
			// 创建一个 XMLHttpRequest 对象
			const xhr = new XMLHttpRequest();

			// 配置 POST 请求
			xhr.open('POST', 'controleur.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			// 处理服务器响应
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收服务器响应后的处理
					info = "User " + userPseudo + " added successfully"
					if (xhr.responseText) {
						info = xhr.responseText;
					}
					// 可以在这里根据需要执行其他操作，例如清空输入框
					// 可以根据服务器返回的数据进行进一步处理，例如显示成功消息
					document.getElementById("info-add-member").textContent = info;
					document.getElementById("info-add-member").style.color = "blue"; // 设置文本颜色为红色
				} else {
					// 处理错误情况
					console.error('Erreur lors de la requête AJAX :', xhr.status, xhr.statusText);
					// 可以根据需要显示错误消息给用户
					// document.getElementById("info-add-member").textContent = 'Erreur lors de l\'ajout de ce membre. Peut-être il n\'existe pas.';
					// document.getElementById("info-add-member").style.color = "red"; // 设置文本颜色为红色
				}
			};
			// 发送请求
			const params = "idConv=" + encodeURIComponent(idConv) + "&action=" + encodeURIComponent("Add User") + "&pseudo=" + encodeURIComponent(userPseudo);
			console.log(params);
			xhr.send(params);
			refreshConversations();
		}

		/*user suggestion*/
		document.addEventListener('DOMContentLoaded', function () {
			// 监听输入框的输入事件
			document.addEventListener('input', function (event) {
				const target = event.target;

				// 检查是否是输入框，并且是 id 为 'pseudo' 的输入框
				if (target && target.id === 'pseudo') {
					const pseudo = target.value.trim();

					// 如果输入为空，清空建议列表并返回
					if (pseudo === "") {
						document.getElementById('user-suggestions').innerHTML = "";
						return;
					}

					// 发送请求搜索用户
					fetch(`controleur.php?action=${encodeURIComponent("Search Users")}&pseudo=${encodeURIComponent(pseudo)}`)
						.then(response => response.json())
						.then(data => {
							let suggestions = '';
							if (data.length > 0) {
								suggestions = '<ul class="bg-white border border-gray-300 rounded-lg mt-2">';
								data.forEach(user => {
									suggestions += `<li class="px-3 py-2 border-b border-gray-200 cursor-pointer" onclick="fillInput('${user.pseudo}')">${user.pseudo}</li>`;
								});
								suggestions += '</ul>';
							} else {
								suggestions = '<div class="px-3 py-2 text-gray-700">Aucun utilisateur trouvé</div>';
							}
							document.getElementById('user-suggestions').innerHTML = suggestions;
						})
						.catch(error => console.error('Error:', error));
				}
			});

			// 初始刷新成员列表
			refreshMemberList();
		});
		// 定义填充输入框的函数
		function fillInput(pseudo) {
			document.getElementById('pseudo').value = pseudo;
			document.getElementById('user-suggestions').innerHTML = "";
		}

		/* Members List */
		function refreshMemberList() {
			const idConv = "<?php echo htmlspecialchars($idConv); ?>"; // 获取聊天ID
			if (idConv == "") {
				return;
			}

			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收响应
					var response = JSON.parse(xhr.responseText);
					updateMemberList(response);
				} else {
					console.error('Request failed. Status: ' + xhr.status);
				}
			};
			xhr.onerror = function () {
				console.error('Request error.');
			};
			xhr.send('action=' + encodeURIComponent("List Conversation Members") + '&idConv=' + encodeURIComponent(idConv));
		}

		// 更新成员列表
		function updateMemberList(members) {

			var idConv = "<?php echo htmlspecialchars($idConv); ?>"; // 获取聊天ID
			if (idConv == "") {
				return;
			}
			var memberList = document.getElementById('member-list');
			var isAdmin = "<?php echo isAdminOfConversation($_SESSION["idUser"], valider("idConv")); ?>";
			memberList.innerHTML = ''; // 清空列表

			members.forEach(function (member) {
				var li = document.createElement('li');
				li.classList.add('bg-white', 'rounded-lg', 'p-4', 'flex', 'items-center', 'justify-between', 'mb-2', 'shadow-sm');
				li.textContent = member.pseudo; // 假设这是成员的伪昵称字段
				memberList.appendChild(li);

				if (isAdmin) {
					var deleteButton = document.createElement('button');
					deleteButton.textContent = '×'; // 添加删除图标或文字
					deleteButton.classList.add('text-red-600', 'ml-2', 'focus:outline-none');
					deleteButton.onclick = function () {
						deleteUserFromConversation(member.id); // 调用删除用户的函数，传递成员 ID
					};
					li.appendChild(deleteButton);
				}
			});
		}

		/** 退出群聊 */
		function quitConversation() {
			var idConv = "<?php echo htmlspecialchars($idConv); ?>"; // 获取聊天ID
			if (idConv == "") {
				return;
			}
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收响应
					alert("Vous avez réussi à quitter la conversation !");
					window.location.href = 'index.php?view=conversations';
				} else {
					console.error('Request failed. Status: ' + xhr.status);
				}
			};
			xhr.onerror = function () {
				console.error('Request error.');
			};
			xhr.send('action=' + encodeURIComponent("Quit Conversation") + '&idConv=' + encodeURIComponent(idConv));
		}
		function deleteConversation() {
			var idConv = "<?php echo htmlspecialchars($idConv); ?>"; // 获取聊天ID

			if (idConv == "") {
				return;
			}
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收响应
					alert("Vous avez réussi à archiver la conversation !");
					window.location.href = 'index.php?view=conversations';
				} else {
					console.error('Request failed. Status: ' + xhr.status);
				}
			};
			xhr.onerror = function () {
				console.error('Request error.');
			};
			xhr.send('action=' + encodeURIComponent("Delete Conversation") + '&idConv=' + encodeURIComponent(idConv));
		}
		function deleteUserFromConversation(id) {
			var idConv = "<?php echo htmlspecialchars($idConv); ?>"; // 获取聊天ID
			if (idConv == "") {
				return;
			}
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'controleur.php');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function () {
				if (xhr.status === 200) {
					// 成功接收响应
					alert("Vous avez réussi à supprimer le membre !");
					window.location.href = 'index.php?view=conversations';
				} else {
					console.error('Request failed. Status: ' + xhr.status);
				}
			};
			xhr.onerror = function () {
				console.error('Request error.');
			};
			xhr.send('action=' + encodeURIComponent("Delete Membre") + '&idConv=' + encodeURIComponent(idConv) + '&idMembre=' + encodeURIComponent(id));
		}
	</script>

	<?php
} // 结束条件语句
?>