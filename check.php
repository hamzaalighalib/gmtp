<?php

require_once __DIR__ . '/lib/helpers.php';

try {
    // Define the path to the public key
    $publicKeyPath = __DIR__ . '/lib/public_key.pem';

    // Check if the public key file exists
    if (!file_exists($publicKeyPath)) {
        throw new Exception('Public key not found');
    }

    // Read the public key file
    $publicKey = file_get_contents($publicKeyPath);
    if (!$publicKey) {
        throw new Exception('Failed to read public key');
    }

    // Respond with the public key as plain text (not JSON)
    header('Content-Type: application/x-pem-file');
    echo $publicKey;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([ 'status' => false , 'error' => $e->getMessage()]);
    exit;
}
