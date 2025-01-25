<?php
function generate_keys($privateKeyPath, $publicKeyPath) {
    // Generate a new RSA key pair (2048 bits)
    $keyPair = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
    
    // Check if the key generation was successful
    if ($keyPair === false) {
        throw new Exception("Failed to generate the key pair.");
    }

    // Export the private key to a variable
    $privateKey = null;
    if (!openssl_pkey_export($keyPair, $privateKey)) {
        throw new Exception("Failed to export the private key.");
    }

    // Extract the public key from the key pair
    $publicKeyDetails = openssl_pkey_get_details($keyPair);
    if ($publicKeyDetails === false) {
        throw new Exception("Failed to extract public key.");
    }
    $publicKey = $publicKeyDetails['key'];

    // Save the private key to the specified file
    if (file_put_contents($privateKeyPath, $privateKey) === false) {
        throw new Exception("Failed to write private key to file.");
    }

    // Save the public key to the specified file
    if (file_put_contents($publicKeyPath, $publicKey) === false) {
        throw new Exception("Failed to write public key to file.");
    }

    echo "Private and public keys have been successfully saved to the specified files.\n";
}

?>
