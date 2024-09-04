// 定义刷新会话列表的函数
function refreshConversations() {
	// // 创建一个新的 XMLHttpRequest 对象
	const xhr = new XMLHttpRequest();
	// console.log("refrezh");
	// 配置 AJAX 请求
	// const xhr = new XMLHttpRequest();
	xhr.open('POST', 'controleur.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	// 处理服务器响应
	xhr.onload = function () {
		if (xhr.status === 200) {
			// 成功接收服务器响应后的处理
			const response = xhr.responseText;
			document.getElementById('conversationsList').innerHTML = response;
			console.log('Refreshed conversations successfully.');
		} else {
			// 处理错误情况
			console.error('Error refreshing conversations:', xhr.status, xhr.statusText);
		}
	};

	// 发送请求
	const params = 'action=' + encodeURIComponent("Refresh Conversations");
	xhr.send(params);
}

// 页面加载时立即刷新会话列表
refreshConversations();

function createConversation() {
	// 获取表单元素
	const conversationTitle = document.getElementById('conversationTitleInput').value;
	if (conversationTitle == "") {
		document.getElementById("info-create-conversation").textContent = "Le titre de la conversation ne peut pas être vide.";
		document.getElementById("info-create-conversation").style.color = "red"; // 设置文本颜色为红色
		return;
	}
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
			document.getElementById('conversationTitleInput').value = '';
			// 可以根据服务器返回的数据进行进一步处理，例如显示成功消息
			document.getElementById("info-create-conversation").textContent = 'La conversation a été créée avec succès!';
			document.getElementById("info-create-conversation").style.color = "blue";
		} else {
			// 处理错误情况
			console.error('Erreur lors de la requête AJAX :', xhr.status, xhr.statusText);
			// 可以根据需要显示错误消息给用户
			document.getElementById("info-create-conversation").textContent = 'Erreur lors de la création de la conversation. Veuillez réessayer plus tard.';
			document.getElementById("info-create-conversation").style.color = "red";
		}
	};

	// 发送请求
	const params = 'theme=' + encodeURIComponent(conversationTitle) + "&action=" + encodeURIComponent("Creat Conversation");;
	xhr.send(params);
	refreshConversations();
}