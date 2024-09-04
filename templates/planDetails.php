<?php
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "planDetails.php") {
    header("Location:../index.php?view=plans");
    die("");
}
include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/modele.php";
?>

<div class="container-fluid text-center pt-5" style="margin-top: 10vh">
    <h1>Plan Details</h1>
    <div class="container mt-3 border-5 border-primary-subtle bg-gray-50 rounded shadow">
        <div class="container p-2 d-flex justify-content-around">
            <?php
            $reservationId = valider("reservationID");
            if ($reservationId) {
                $reservation = getReservationById($reservationId);
                $reservationDetails = getCarAvailOfReservation($reservationId);
                $reservationStartDate = $reservationDetails['available_from'];
                $reservationEndDate = $reservationDetails['available_to'];
                $reservationStatus = $reservation[0]['status'];
                $reservationStartDate = new DateTime($reservationStartDate);
                $reservationEndDate = new DateTime($reservationEndDate);
                $reservationStartDateSimple = $reservationStartDate->format('d/m');
                echo "<h2>$reservationStartDateSimple</h2>";
                $stateColor = 0;
                switch ($reservationStatus) {
                    case 'Planning':
                        $stateColor = 'text-primary';
                        break;
                    case 'Ready':
                        $stateColor = 'text-success';
                        break;
                    case 'Done':
                        $stateColor = 'text-gray-500';
                        break;
                    case 'Canceled':
                        $stateColor = 'text-danger';
                        break;
                }

                echo "<h2 class='$stateColor'>$reservationStatus</h2>";
            } else {
                echo "<h2>XX/XX</h2>";
                echo "<h2 class='text-primary'>Planning</h2>";
            }
            ?>
        </div>
        <div class="container p-2 d-flex justify-content-center">
            <h2 class="text-primary mr-2">PlanDetail:</h2>
            <?php
            if ($reservationId) {
                echo "<h2><p class='text-warning d-inline'>" . $reservationStartDate->format('H:i') . "</p><br>  " . $reservationDetails['departure'] . "</h2>";
                echo "<h2>-</h2>";
                echo "<h2><p class='text-primary d-inline'>" . $reservationEndDate->format('H:i') . "</p><br>  " . $reservationDetails['destination'] . "</h2>";
            } else {
                echo "<h2>XX:XX</h2>";
            }
            ?>
        </div>
        <div class="container p-2 d-flex justify-content-center flex-column">
            <h2 class="text-primary mr-2">Carpoolers:</h2>
            <div class="container d-flex justify-content-center flex-column">
                <?php
                $carpoolers = getUsersOfReservation($reservationId);
                foreach ($carpoolers as $carpooler) {

                    echo "<h2 class='d-inline'>" . getPseudo($carpooler['id_user']) . "</h2>";
                }
                ?>
            </div>
        </div>
        <div class="container p-2 d-flex justify-content-center align-items-center">
            <h2 class="text-primary mr-2">Conversation:</h2>
            <a href="index.php?view=conversations">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                     class="bi bi-chat-dots" viewBox="0 0 16 16">
                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                </svg>
            </a>

        </div>
        <div class="container p-2 d-flex justify-content-center align-items-center">
            <h2 class="text-primary mr-2">Car:</h2>
            <?php
            $carId = $reservationDetails['car_id'];
            $car = getCarById($carId);
            $carName = $car['name'];
            echo "<h2>$carName</h2>";
            ?>

        </div>
    </div>

</div>