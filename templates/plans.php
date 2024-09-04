<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (!valider("connecte", "SESSION")) {
    $qs = "?view=login";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);

    $urlBase = $protocol . $host . $script . "/index.php";
    header("Location:" . $urlBase . $qs);
    die("Please login first!");
}
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    $qs = "?view=plans";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);

    $urlBase = $protocol . $host . $script . "/index.php";
    header("Location:" . $urlBase . $qs);
}
if (basename($_SERVER["PHP_SELF"]) == "plans.php") {
    header("Location:../index.php?view=plans");
    die("");
}
include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/modele.php";
?>
<script>
    function changeScope(select) {
        console.log(select);
        console.log(select.value);
        window.location = "index.php?view=plans&scope=" + select.value;
    }

</script>
<main id="site-main" class="overflow-auto rounded shadow" style="margin-top: 10vh;max-height: 70vh">
    <div class="container-fluid d-flex flex-column h-100">
        <div class="container-fluid d-flex justify-content-between align-items-center p-0">
            <h1 class="display-1">Plans</h1>
        </div>

        <div class="container-fluid p-0">
            <label for="scope"></label><select class="form-select w-100" id="scope" onchange="changeScope(this)">
                <?php
                if (valider("scope") === "history") {
                    echo "<option value='history' selected>History</option>
                <option>Plans</option>";
                } else {
                    echo "<option value='history'>History</option>
                <option selected>Plans</option>";
                }
                ?>

            </select>
        </div>
        <?php
        if (valider("connecte", "SESSION")) {

            $idUser = valider("idUser", "SESSION");
            $reservations = listerReservations($idUser);

            usort($reservations, function ($a, $b) {
                return strtotime(getCarAvailOfReservation($a['id'])['available_from']) - strtotime(getCarAvailOfReservation($b['id'])['available_from']);
            });
            $timeNow = new DateTime();
            if (valider("scope") !== "history") {
               

                // 使用 array_filter 过滤 $reservations 数组
                $filteredReservations = array_filter($reservations, function ($reservation) use ($timeNow) {
                    // 获取预订的开始时间
                    $availableFrom = getCarAvailOfReservation($reservation['id'])['available_from'];
                    // 将字符串时间转换为 DateTime 对象
                    $availableFromDateTime = new DateTime($availableFrom);
                    // echo 'Avaiable From: ' . $availableFromDateTime->format('Y-m-d H:i:s') . '<br>Time Now:' . $timeNow->format('Y-m-d H:i:s') . '<br>';
                    // 比较两个 DateTime 对象并输出结果
                    if ($availableFromDateTime >= $timeNow) {
                        // echo "result: true<br>";
                        return true;
                    } else {
                        // echo "result: false<br>";
                        return false;

                        // return true;
                    }
                    // 如果预订的开始时间大于当前时间，保留这个预订
                    // return $availableFromDateTime >= $timeNow;
                });
                $reservations = $filteredReservations;

            } else {
                // tprint($reservations);
                // 使用 array_filter 过滤 $reservations 数组
                $filteredReservations = array_filter($reservations, function ($reservation) use ($timeNow) {
                    // 获取预订的开始时间
                    $availableFrom = getCarAvailOfReservation($reservation['id'])['available_from'];
                    // 将字符串时间转换为 DateTime 对象
                    $availableFromDateTime = new DateTime($availableFrom);
                    // echo 'Avaiable From: ' . $availableFromDateTime->format('Y-m-d H:i:s') . '<br>Time Now:' . $timeNow->format('Y-m-d H:i:s') . '<br>';
                    // 比较两个 DateTime 对象并输出结果
                    if ($availableFromDateTime >= $timeNow) {
                        // echo "result: true<br>";
                        return false;
                    } else {
                        // echo "result: false<br>";
                        return true;
                        // return true;
                    }
                    // 如果预订的开始时间大于当前时间，保留这个预订
                    // return $availableFromDateTime >= $timeNow;
                });
                $reservations = $filteredReservations;
                // tprint($reservations);
            }

            if ($reservations) {
                // tprint($reservations);
                $dateStartSimple = null;
                foreach ($reservations as $reservation) {
                    $planDetail = getCarAvailOfReservation($reservation['id']);
                    $newDateStart = new DateTime($planDetail['available_from']);
                    $newDateEnd = new DateTime($planDetail['available_to']);
                    $newDateStartSimple = $newDateStart->format('d/m');
                    if ($dateStartSimple != $newDateStartSimple) {
                        echo "<h2>$newDateStartSimple :</h2>";
                        $dateStartSimple = $newDateStartSimple;
                    }
                    $planStatus = $reservation['status'];
                    $stateColor = 0;
                    switch ($planStatus) {
                        case 'Planning':
                            $stateColor = 'bg-primary-subtle';
                            break;
                        case 'Ready':
                            if (valider("scope") !== "history") {
                                $stateColor = 'bg-success-subtle';
                            } else {
                                $stateColor = 'bg-gray-300';
                            }
                            break;
                        case 'Done':
                            $stateColor = 'bg-gray-300';
                        case 'Cancel':
                            $stateColor = 'bg-danger-subtle';
                            break;
                    }
                    echo "<a href='index.php?view=planDetails&reservationID=" . $reservation['id'] . "' class='container text-decoration-none  rounded m-1 text-black d-flex align-items-center justify-between $stateColor' style='height:10vh'>" . "<h4>" . $planDetail['departure'] . "</h4><h4>" . $newDateStart->format('H:i') . "-" . $newDateEnd->format('H:i') . "</h4></a><br>";
                }
            }

        }
        ?>
    </div>

</main>