<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login");
    die("");
}
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    $qs = "?view=login";
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);

    $urlBase = $protocol . $host . $script . "/index.php";
    header("Location:" . $urlBase . $qs);
}
// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE");
if ($checked = valider("remember", "COOKIE"))
    $checked = "checked";

?>

<main class="bg-gray-100" id="site-main">

    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
            <h1 class="text-4xl font-bold text-center mb-8">Login</h1>
            <form action="controleur.php" method="GET">
                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-700">Username:</label>
                    <input type="text" id="login" name="login"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Enter username">
                </div>

                <div class="mb-4">
                    <label for="passe" class="block text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" id="passe" name="passe"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Enter password" value="<?php echo $login; ?>">
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        value="<?php echo $passe; ?>">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="signup" name="signup"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        value="<?php echo $passe; ?>">
                    <label for="signup" class="ml-2 block text-sm text-gray-900">sign up</label>
                </div>
                <button id="signinButton" type="submit" name="action"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    value="Connexion">
                    Sign in
                </button>
                <button id="signupButton" type="submit" name="action"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hidden"
                    value="Sign Up">
                    Sign up
                </button>
            </form>
        </div>
    </div>

</main>

<script>
    document.getElementById('signup').addEventListener('change', function () {
        var signinButton = document.getElementById('signinButton');
        var signupButton = document.getElementById('signupButton');
        if (this.checked) {
            signinButton.classList.add('hidden');
            signupButton.classList.remove('hidden');
        } else {
            signinButton.classList.remove('hidden');
            signupButton.classList.add('hidden');
        }
    });
</script>