<?php
// Function to generate a new RSA key pair
function generate_rsa_key_pair($keySize = 2048) {
    $config = array(
        "private_key_bits" => $keySize,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    // Generate the private and public keys
    $res = openssl_pkey_new($config);

    // Extract the private key from the pair
    openssl_pkey_export($res, $privateKey);

    // Extract the public key from the pair
    $publicKeyDetails = openssl_pkey_get_details($res);
    $publicKey = $publicKeyDetails['key'];

    return array('privateKey' => $privateKey, 'publicKey' => $publicKey);
}

// Encrypt data with a private key (RSA)
function encrypt_with_private_key($data, $privateKey) {
    if (!openssl_private_encrypt($data, $encryptedData, $privateKey)) {
        throw new Exception("Encryption with private key failed.");
    }
    
    return base64_encode($encryptedData);
}

// Decrypt data with a public key (RSA)
function decrypt_with_public_key($encryptedData, $publicKey) {
    $decodedData = base64_decode($encryptedData);

    if (!openssl_public_decrypt($decodedData, $decryptedData, $publicKey)) {
        throw new Exception("Decryption with public key failed.");
    }

    return $decryptedData;
}

// Example data to encrypt
$originalData = "This is a test message for asymmetric encryption.";

try {
    // Generate RSA key pair
    $keyPair = generate_rsa_key_pair();

    // Extract the private and public keys
    $privateKeyPem = $keyPair['privateKey'];
    $publicKeyPem = $keyPair['publicKey'];

    // Display the generated keys (for demonstration purposes)
    echo "Private Key: \n" . $privateKeyPem . "\n\n";
    echo "Public Key: \n" . $publicKeyPem . "\n\n";

    // Encrypt the data using the private key
    $encryptedData = encrypt_with_private_key($originalData, $privateKeyPem);
    echo "Encrypted Data: " . $encryptedData . "\n";

    // Decrypt the data using the public key
    $decryptedData = decrypt_with_public_key($encryptedData, $publicKeyPem);
    echo "Decrypted Data: " . $decryptedData . "\n";

    // Verify if the decrypted data matches the original data
    if ($decryptedData === $originalData) {
        echo "Success! The decrypted data matches the original data.\n";
    } else {
        echo "Error! The decrypted data does not match the original data.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
