<?php

// Check if the config file exists
if (!file_exists("lib/config.php")) {
    // If the config file doesn't exist, render the landing page
    echo renderLandingPage();
} else {
    // If the config file exists, include the index2.php file
    include "index2.php";
}

// Landing page content function
function renderLandingPage() {
    return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GMTP - Ghalib Mail Transfer Protocol || Developed by Hamza Ali Ghalib Senior Web Developer</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-900 text-white">
        <div class="flex items-center justify-center min-h-screen flex-col">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-6 animate__animated animate__fadeInDown">Welcome to GMTP!</h1>
                <p class="text-lg mb-6 animate__animated animate__fadeIn animate__delay-1s">
                    Ghalib Mail Transfer Protocol (GMTP) is a revolutionary mail transfer protocol designed for secure, encrypted email communication.
                </p>
                <div class="mb-6 animate__animated animate__fadeIn animate__delay-2s">
                    <p class="text-lg">With GMTP, you can:</p>
                    <ul class="list-disc list-inside text-lg">
                        <li>Send encrypted emails</li>
                        <li>Ensure secure communication</li>
                        <li>Send emails across different domains using our protocol</li>
                    </ul>
                </div>
                <a href="/ghalib-mail/lib/install.php?by=ghalib_corporation" class="text-lg bg-green-500 px-6 py-3 rounded-lg text-white hover:bg-green-600 transition">
                    Install GMTP
                </a>
            </div>
        </div>
    </body>
    </html>
    ';
}
?>
