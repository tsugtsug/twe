<main id="site-main car-main">
    <h2>Cars</h2>
    <?php

    if (!valider("connecte", "SESSION")) {
        header("Location:../index.php?view=login");
        die();
    }

    // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
    if (basename($_SERVER["PHP_SELF"]) != "index.php") {
        $qs = "?view=cars";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $script = dirname($_SERVER['SCRIPT_NAME']);

        $urlBase = $protocol . $host . $script . "/index.php";
        header("Location:" . $urlBase . $qs);
    }

    include_once ("libs/modele.php"); // listes
    include_once ("libs/maLibUtils.php");// tprint
    include_once ("libs/maLibForms.php");// mkTable, mkLiens, mkSelect ...
    
    $idUser = valider("idUser", "SESSION");

    $all_cars = getAllAvailableCars();
    $availableCarIds = getAllAvailableCarsID();
    $carsOwned = listerAllCarsOwend($idUser);
    ?>

    <main id="site-main">
        <h1>Cars</h1>
        <form id="searchForm">
            <div class="flex items-center">
                <label for="departure" class="w-32">Departure:</label>
                <input type="text" id="departure" name="departure"
                    class="shadow-md border-gray-300 border-2 rounded-lg m-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
            </div>
            <div class="flex items-center">
                <label for="Destination" class="w-32">Destination:</label>
                <input type="text" id="destination" name="destination"
                    class="shadow-md border-gray-300 border-2 rounded-lg m-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"><br>
            </div>
            <div class="flex items-center">
                <label for="time" class="w-32">Departure time:</label>
                <input type="datetime-local" id="time" name="time"
                    class="shadow-md border-gray-300 border-2 rounded-lg mt-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
            </div><br>
            <button type="button" name="action" value="searchCar" onclick="searchCar()" id="btn-search"
                class="button bg-<?= getCouleur($_SESSION["idUser"]) ?>-500 hover:bg-<?= getCouleur($_SESSION["idUser"]) ?>-700 mb-2">
                Search
            </button>
        </form>
        <?php
        ?>

        <div id="available-cars">
            <h3>Available Cars List</h3>
            <ul id="carList">
            </ul>
        </div>



        <div id="addCar">
            <button id="registerCarButton"
                class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg">Register
                a new car</button>
        </div>
        <br>
        <div id="uploadCar">
            <button id="uploadCarButton" name="action" value="uploadCar"
                class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg"
                style="display: inline;">Upload a car to available car list</button>
        </div>
        <br>
        <div id="removeCar">
            <button id="removeCarButton" name="action" value="removeCar"
                class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg"
                style="display: inline;">Remove a car from the available car list</button>
        </div>
        <br>
        <div id="CarFormContainer"></div>
    </main>
    <script>
        document.getElementById('registerCarButton').addEventListener('click', function () {
            var formHtml = `
            <form method="POST" action="controleur.php">
                <div class="form-group">
                    <label for="nameCar">Car Name</label>
                    <input type="text" class="form-control" id="nameCar" name="nameCar" required>
                </div>
                <div class="form-group">
                    <label for="license_plate">License Plate</label>
                    <input type="text" class="form-control" id="license_plate" name="license_plate" required>
                </div>
                <button type="submit" name="action" value="registerCar" class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg">Submit</button>
            </form>
        `;
            document.getElementById('CarFormContainer').innerHTML = formHtml;
        });

        document.getElementById('uploadCarButton').addEventListener('click', function () {
            var carsOwned = <?php echo json_encode($carsOwned); ?>;

            var options = carsOwned
                .map(car =>
                    `<option value="${car.id}">${car.name} - ${car.license_plate}</option>`
                ).join('');

            var formHtml = `
                <form method="POST" action="controleur.php">
                    <div class="form-group">
                        <label for="carid">Car you want to choose</label>
                        <select id="carid" name="carid" class="form-control" required>
                            ${options}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="carDeparture">Departure</label>
                        <input type="text" class="form-control" id="carDeparture" name="carDeparture" required>
                    </div>
                    <div class="form-group">
                        <label for="startTime">Start time</label>
                        <input type="datetime-local" class="form-control" id="startTime" name="startTime" required>
                    </div>
                    <div class="form-group">
                        <label for="endTime">End time</label>
                        <input type="datetime-local" class="form-control" id="endTime" name="endTime" required>
                    </div>
                    <div class="form-group">
                        <label for="passenger_limit">Passenger Limit</label>
                        <input type="number" class="form-control" id="passenger_limit" name="passenger_limit" required>
                    </div>
                    <button type="submit" name="action" value="uploadCar" class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg">Upload</button>
                </form>
            `;
            document.getElementById('CarFormContainer').innerHTML = formHtml;
        });

        document.getElementById('removeCarButton').addEventListener('click', function () {
            var carsOwned = <?php echo json_encode($carsOwned); ?>;
            var availableCarIds = <?php echo json_encode(array_column($availableCarIds, 'car_id')); ?>;

            var options = carsOwned
                .filter(car => availableCarIds.includes(car.id)) // cars_availabilityに存在する車のみをフィルタリング
                .map(car =>
                    `<option value="${car.id}">${car.name} - ${car.license_plate}</option>`
                ).join('');

            var formHtml = `
                <form method="POST" action="controleur.php">
                    <div class="form-group">
                        <label for="carid">Car you want to remove</label>
                        <select id="carid" name="carid" class="form-control" required>
                            ${options}
                        </select>
                    </div>
                    <button type="submit" name="action" value="removeCar" class="button bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600 text-white py-2 px-4 rounded-lg">Remove</button>
                </form>
            `;
            document.getElementById('CarFormContainer').innerHTML = formHtml;
        });
    </script>

    <script>
        function searchCar() {
            // 获取表单元素

            const departure = document.getElementById('departure').value;
            const destination = document.getElementById('destination').value;
            const startTime = document.getElementById('time').value;
            const action = document.getElementById('btn-search').value;

            const params = 'departure=' + encodeURIComponent(departure) +
                '&destination=' + encodeURIComponent(destination) +
                '&time=' + encodeURIComponent(startTime) +
                '&action=' + encodeURIComponent(action);
            // 创建一个 XMLHttpRequest 对象
            const xhr = new XMLHttpRequest();

            // 配置 POST 请求
            xhr.open('POST', 'controleur.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            // 处理服务器响应
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // 成功接收服务器响应后的处理
                    console.log(xhr.responseText)
                    console.log(JSON.parse(xhr.responseText));
                    // 可以在这里根据需要执行其他操作，例如清空输入框
                    document.getElementById('departure').value = '';
                    document.getElementById('destination').value = '';
                    document.getElementById('time').value = '';
                    refreshCarList(params);
                } else {
                    // 处理错误情况
                    console.error('Erreur lors de la requête AJAX :', xhr.status, xhr.statusText);
                }
            };

            // 发送请求
            console.log(params);
            xhr.send(params);
        }

        document.addEventListener('DOMContentLoaded', function () {
            // 初始化页面加载时刷新汽车列表
            refreshCarList();

            // 定时每隔一段时间刷新汽车列表（例如每5分钟）
            setInterval(refreshCarList, 5 * 60 * 1000); // 5分钟为间隔，单位是毫秒
        });

        // 刷新汽车列表函数
        function refreshCarList(params = 'action=searchCar') {
            // 这里假设你的控制器路径为 'controleur.php'，并且有一个用于获取汽车列表的动作 'List Cars'
            fetch('controleur.php?' + params)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    updateCarList(data); // 调用更新汽车列表的函数，并传递从服务器获取的汽车数据
                })
                .catch(error => console.error('Error:', error));
        }

        // 更新汽车列表函数
        function updateCarList(cars) {
            var carList = document.getElementById('carList');
            carList.innerHTML = ''; // 清空当前列表内容

            cars.forEach(function (car) {
                var li = document.createElement('li');
                li.classList.add('mb-6');
                // 创建 car-details 和 car-actions 的 HTML 结构
                var carDetailsHTML = `
        <div class="car-details mb-4 p-4 bg-gray-50 rounded-lg shadow-inner">
            <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-lg">Car Name:</span>
                <span class="text-gray-700">${escapeHtml(car.carName)}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-lg">Departure:</span>
                <span class="text-gray-700">${escapeHtml(car.departure)}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-lg">Available from:</span>
                <span class="text-gray-700">${escapeHtml(car.available_from)}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="font-semibold text-lg">Available to:</span>
                <span class="text-gray-700">${escapeHtml(car.available_to)}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-semibold text-lg">Seats left:</span>
                <span class="text-gray-700">${escapeHtml(car.passenger_limit)}</span>
            </div>
        </div>
    `;
                var buttonColorClass = car.isReserved ? 'bg-red-500 hover:bg-red-600' : 'bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-500 hover:bg-<?php echo getCouleur($_SESSION["idUser"]); ?>-600';
                var carActionsHTML = `
        <div class="car-actions">
            <form method="GET" action="controleur.php" class="text-right">
                <input type="hidden" name="idAvailable" value="${escapeHtml(car.id)}">

                </button>
                                <button type="submit" name="action" value="toggleCarReservation" class="button ${buttonColorClass} text-white py-2 px-4 rounded-lg">
                    ${car.isReserved ? 'Cancel' : 'Reserve'}
                </button>
            </form>
        </div>
    `;

                // 将 car-details 和 car-actions 的 HTML 结构添加到 li 元素中
                li.innerHTML = carDetailsHTML + carActionsHTML;

                // 将 li 元素添加到页面中的搜索结果列表中
                var carList = document.getElementById('carList');
                carList.appendChild(li);
            });
        }
        // 使用函数转义HTML实体，防止XSS攻击
        function escapeHtml(unsafe) {
            if (typeof unsafe === 'string')
                return unsafe.replace(/[&<"']/g, function (m) {
                    switch (m) {
                        case '&':
                            return '&amp;';
                        case '<':
                            return '&lt;';
                        case '"':
                            return '&quot;';
                        case "'":
                            return '&#39;';
                        default:
                            return m;
                    }
                });
            else return unsafe;
        }
    </script>