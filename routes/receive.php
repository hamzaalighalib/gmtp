<?php
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/config.php';

try {
    // Get JSON payload
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data || empty($data['encryptedMessage']) || empty($data['senderDomain'])) {
        throw new Exception('Invalid input data');
    }

    // Fetch sender's public key
    $senderDomain = $data['senderDomain'];
    $validationEndpoint = "https://$senderDomain/ghalib-mail/check.php";
    $publicKey = send_request($validationEndpoint, ['request' => 'publicKey']);

    if (!$publicKey) {
        throw new Exception('Failed to retrieve sender public key');
    }

    // Decrypt the incoming message

    $decryptedMessage = decrypt_data($data['encryptedMessage'], $publicKey);

    if (!$decryptedMessage) {
        throw new Exception('Failed to decrypt message from receiver');
    }

    // Parse decrypted message
    $messageData = json_decode($decryptedMessage, true);
    if (empty($messageData['sender']) || empty($messageData['subject']) || empty($messageData['body'])) {
        throw new Exception('Decrypted data is incomplete');
    }

    // Save email to the database
    $pdo = get_database_connection();
    $stmt = $pdo->prepare("INSERT INTO `ghalib-mails` (sender, receiver, subject, body, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $messageData['sender'],
        'admin@' . $_SERVER['SERVER_NAME'], //receiver you can costomize this later...
        $messageData['subject'],
        $messageData['body'],
        'received'
    ]);

    echo json_encode(['success' => true, 'message' => 'Email received and saved']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
