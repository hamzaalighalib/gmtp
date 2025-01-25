<?php

// Encrypt data with a private key (RSA)
function encrypt_data($data, $privateKeyPath) {
    // Load the private key
    $privateKey = load_key($privateKeyPath);
    
    if (!openssl_private_encrypt($data, $encryptedData, $privateKey)) {
         return false;
    }

    return base64_encode($encryptedData); // Encoding to store or transmit as text
}

// Decrypt data with a public key (RSA)
function decrypt_data($encryptedData, $publicKey) {
    // Load the public key

    $decodedData = base64_decode($encryptedData);

    if (!openssl_public_decrypt($decodedData, $decryptedData, $publicKey)) {
        return false;
    }

    return $decryptedData;
}

// Load key from file and verify the format
function load_key($keyPath) {
    // Read the key file
    $key = file_get_contents($keyPath);
    if (!$key) {
        throw new Exception("Failed to load key from: $keyPath");
    }

    // Verify the key format
    if (strpos($key, 'BEGIN PUBLIC KEY') !== false) {
        echo "Public key loaded successfully.\n";
    } elseif (strpos($key, 'BEGIN PRIVATE KEY') !== false) {
        // echo "Private key loaded successfully.\n";
    } else {
        throw new Exception("Key format is not correct.");
    }

    return $key;
}

// Example of sending the encrypted data using cURL
// Example of sending the encrypted data using cURL
function send_request($url, $data) {
    // Function to attempt the request
    $attempt = function($url, $data, $isHttps) {
        $ch = curl_init($url);

        // Set the User-Agent string (mimicking a real browser)
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent); // Set custom User-Agent

        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, true); // POST request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Data to send
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // JSON headers

        // Timeout settings (30 seconds for both connection and response)
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Set request timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Set connection timeout (10 seconds)

        // Follow redirects if any (useful for URLs that may redirect)
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

        // Optionally, you can set a referer header (e.g., if you're mimicking browser requests)
        $referer = $url;
        curl_setopt($ch, CURLOPT_REFERER, $referer); // Set referer header

        // Enable SSL certificate verification (important for production)
        if ($isHttps) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Ensure SSL cert is verified
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);   // Verify SSL certificate's host
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for HTTP fallback
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);     // Disable SSL verification for HTTP fallback
        }

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            curl_close($ch);
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        // Check for valid HTTP status code (200 OK)
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            curl_close($ch);
            throw new Exception("Request failed with status code $httpCode. Response: $response");
        }

        // Close the cURL resource
        curl_close($ch);

        // Return the response data (success)
        return $response;
    };

    // Try HTTPS first
    try {
        return $attempt($url, $data, true); // Attempt via HTTPS
    } catch (Exception $e) {
        // If HTTPS fails, try HTTP (fallback)
        if (strpos($url, 'https://') === 0) {
            $url = 'http://' . substr($url, 8); // Convert to HTTP if the URL started with HTTPS
        }

        // Retry the request via HTTP
        try {
            return $attempt($url, $data, false); // Attempt via HTTP
        } catch (Exception $e) {
            // If both HTTPS and HTTP fail, rethrow the error
            throw new Exception("Both HTTPS and HTTP requests failed. Error: " . $e->getMessage());
        }
    }
}



// Example database connection (remains unchanged)
function get_database_connection() {
    $config = require 'config.php';
    try {
        $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['db_user'], $config['db_password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}


?>
