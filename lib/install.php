<?php
session_start();

$configFile = __DIR__ . '/config.php';
$privateKeyFile = __DIR__ . '/private_key.pem';
$publicKeyFile = __DIR__ . '/public_key.pem';


// Check if already installed
if (file_exists($configFile) && file_exists($privateKeyFile) && file_exists($publicKeyFile)) {
   http_response_code(404);
    echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghalib-Mail Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white  p-6 w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Ghalib-Mail Installed!</h1>
          
       <p  class="w-full bg-blue-500 text-white px-4 py-2 rounded"><a href="/ghalib-mail/routes" class="text-white">GotO Ghalib Mail Ui (MailBox) </a></p>
       
            <p class="text-gray-600 text-center mt-4">Ghalib Corporation</p>
        </div>
    </div>
</body>
</html>';
    die();

}

// Form submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "hhh";
    $dbHost = $_POST['db_host'] ?? '';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPassword = $_POST['db_password'] ?? '';
    $dbName = $_POST['db_name'] ?? '';

    // Validate inputs
    if (empty($dbHost) || empty($dbUser) || empty($dbName)) {
        $error = "All fields are required!";
    } else {
        try {
            // Create database connection
            $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPassword);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
            $pdo->exec("USE `$dbName`");

            // Save configuration
            $configContent = "<?php\nreturn [\n    'db_host' => '$dbHost',\n    'db_user' => '$dbUser',\n    'db_password' => '$dbPassword',\n    'db_name' => '$dbName',\n];";
            file_put_contents($configFile, $configContent);

            // Generate encryption keys
            require_once __DIR__ . '/generate_keys.php';
            generate_keys($privateKeyFile, $publicKeyFile);

            // Create tables
            $schemaFile = __DIR__ . '/../database/schema.sql';
            $pdo->exec(file_get_contents($schemaFile));

            $success = true;
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghalib-Mail Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">Ghalib-Mail Installation</h1>
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    Installation successful! Please remove the `install.php` file for security.
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Database Host</label>
                    <input type="text" name="db_host" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Database Username</label>
                    <input type="text" name="db_user" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Database Password</label>
                    <input type="password" name="db_password" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Database Name</label>
                    <input type="text" name="db_name" class="w-full border px-3 py-2 rounded" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">Install</button>
            </form>
            <p class="text-gray-600 text-center mt-4">Ghalib Corporation</p>
        </div>
    </div>
</body>
</html>
