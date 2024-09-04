<?php
// Color Configuration
$colorConfig = [
    'red' => 'red',
    'green' => 'green',
    'blue' => 'blue',
    'gray' => 'gray',
    'yellow' => 'yellow'
];

// Passe Configuration
$passeConfig = [
    'passwordMinLength' => 8, // Minimum length of password
    'passwordRequireSpecial' => true, // Require special characters
    'passwordRequireNumbers' => true, // Require numbers
    'passwordRequireUppercase' => true // Require uppercase letters
];

?>
<style>
    .color-circle {
        display: inline-block;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 10px;
        cursor: pointer;
    }
</style>
<main id="site-main">
    <h2>Color Configuration</h2>
    <ul>
        <?php foreach ($colorConfig as $colorName => $colorValue): ?>
            <li class="color-circle" style="background-color: <?= $colorValue ?>;"
                onclick="chooseColor('<?= $colorValue ?>')"></li>
        <?php endforeach; ?>
    </ul>
<!-- 
    <h2>Pseudo Configuration</h2>
    <form id="pseudoForm">
        <label for="newPseudo">New Pseudo:</label>
        <input type="text" id="newPseudo" name="newPseudo">
        <button type="button" onclick="changePseudo()">Change Pseudo</button>
    </form> -->

    <h2>Passe Configuration</h2>
    <form id="passwordForm">
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword">
        <button type="button" onclick="changePassword()">Change Password</button>
    </form>



</main>

<script>
    function chooseColor(color) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Color changed to: ' + color);
                console.log(xhr.response);
            }
        };
        xhr.send("action=Change%20Color&color=" + encodeURIComponent(color)+"&idUser=<?php echo $_SESSION['idUser'] ?>");
    }

    // function changePseudo() {
    //     var newPseudo = document.getElementById('newPseudo').value;
    //     var xhr = new XMLHttpRequest();
    //     xhr.open("POST", "controleur.php", true);
    //     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState == 4 && xhr.status == 200) {
    //             alert('Pseudo changed to: ' + newPseudo);
    //             console.log(xhr.response);
    //         }
    //     };
    //     xhr.send("action=Change%20Pseudo&newPseudo=" + encodeURIComponent(newPseudo) + "&idUser=<?php echo $_SESSION['idUser']; ?>");
    // }

    function changePassword() {
        var newPassword = document.getElementById('newPassword').value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "controleur.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Password changed');
                console.log(xhr.response);
            }
        };
        xhr.send("action=Modifier%20Passe&passe=" + encodeURIComponent(newPassword));
        // xhr.send("action=Logout");
        window.location.href =  "controleur.php?action=Logout";
    }

</script>