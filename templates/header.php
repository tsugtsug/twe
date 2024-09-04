<header class="bg-white fixed top-0 w-full shadow-md z-10 d-flex justify-content-center align-items-center"
        style="height: 6vh">
    <nav class="container mx-auto h-100 p-4">
        <div class="flex justify-between items-center h-100">
            <a href="index.php?view=home" id="branding"
               class="text-2xl font-bold text-gray-800">CentraleBlaBla</a>
            <div class="flex space-x-4">
                <a href="index.php?view=cars" class="text-gray-800 hidden md:block">Cars</a>
                <a href="index.php?view=plans" class="text-gray-800 hidden md:block">Plans</a>
                <a href="index.php?view=conversations" class="text-gray-800 hidden md:block">Conversations</a>
                <a class="text-white hover:text-gray-400" href="index.php?view=<?php if(valider("connecte", "SESSION")) echo "user"; else echo "login";  ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                         class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd"
                              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                    </svg>
                </a>
            </div>
        </div>
    </nav>
</header>