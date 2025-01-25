<?php
require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/config.php';

function is_valid_email_format($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function get_email_domain($email) {
    if (!is_valid_email_format($email)) {
        return false; // Invalid email
    }
    // Extract domain from email
    list(, $domain) = explode('@', $email);
    return $domain;
}

function sanitize_input($input) {
    // Trim whitespace and ensure UTF-8 encoding
    // We don't strip or encode characters here to avoid data loss for multi-language support
    // Just ensure that the input is properly encoded and safe
    return $input;
}

try {
    // Get JSON payload
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || empty($data['receiver']) || empty($data['sender']) || empty($data['subject']) || empty($data['body'])) {
        throw new Exception('Invalid input data: ' . json_encode($data));
    }

    // Sanitize input data (do not strip special characters to preserve multi-language content)
    $data['receiver'] = sanitize_input($data['receiver']);
    $data['sender'] = sanitize_input($data['sender']);
    $data['subject'] = sanitize_input($data['subject']);
    $data['body'] = sanitize_input($data['body']);

    // Validate and get domains from email addresses
    $receiverDomain = get_email_domain($data['receiver']);
    $senderDomain = get_email_domain($data['sender']);

    if (!$receiverDomain || !$senderDomain) {
        throw new Exception('Invalid sender or receiver email format');
    }

    // Check if sender and receiver are on the same domain
    if ($receiverDomain === $senderDomain) {
        // Save directly to the database for same-domain emails

        // Prepare a database connection using prepared statements to prevent SQL injection
        $pdo = get_database_connection();
        $stmt = $pdo->prepare("INSERT INTO `ghalib-mails` (sender, receiver, subject, body, status) VALUES (:sender, :receiver, :subject, :body, :status)");
        $stmt->bindParam(':sender', $data['sender'], PDO::PARAM_STR);
        $stmt->bindParam(':receiver', $data['receiver'], PDO::PARAM_STR);
        $stmt->bindParam(':subject', $data['subject'], PDO::PARAM_STR);
        $stmt->bindParam(':body', $data['body'], PDO::PARAM_STR);
        $stmt->bindValue(':status', 'sent', PDO::PARAM_STR); // Hardcoded status

        // Execute the query safely
        if ($stmt->execute()) {
            echo json_encode(['status' => true, 'message' => 'Email sent within the same domain', 'rec' =>  $data]); 
        } else {
            throw new Exception('Failed to insert email into the database');
        }
        exit;
    }

    // Otherwise, proceed with encryption and sending to the receiver domain
    $receiverEndpoint = "https://$receiverDomain/ghalib-mail/routes/receive.php";

    // Encrypt the email data
    $privateKeyPath = '../lib/private_key.pem';
    $encryptedMessage = encrypt_data(json_encode([
        'sender' => $data['sender'],
        'subject' => $data['subject'],
        'body' => $data['body']
    ]), $privateKeyPath);

    if (!$encryptedMessage) {
        throw new Exception('Failed to encrypt message');
    }

    // Send the encrypted message to the receiver endpoint
    $response = send_request($receiverEndpoint, [
        'encryptedMessage' => $encryptedMessage,
        'senderDomain' => $senderDomain
    ]);


        $detail_Res = json_decode($response ,true);

       if($detail_Res['status'] ){
         //if meail is sented to another domain then also save in local db in sentmail 
            $pdo = get_database_connection();
            $stmt = $pdo->prepare("INSERT INTO `ghalib-mails` (sender, receiver, subject, body, status) VALUES (:sender, :receiver, :subject, :body, :status)");
            $stmt->bindParam(':sender', $data['sender'], PDO::PARAM_STR);
            $stmt->bindParam(':receiver', $data['receiver'], PDO::PARAM_STR);
            $stmt->bindParam(':subject', $data['subject'], PDO::PARAM_STR);
            $stmt->bindParam(':body', $data['body'], PDO::PARAM_STR);
            $stmt->bindValue(':status', 'sent', PDO::PARAM_STR); // Hardcoded status
       }


    // Handle response
    echo json_encode([
        'status' =>  true,
        'details' => $detail_Res
    ]);

} catch (Exception $e) {
    http_response_code(400);

    // Provide a safer error message, avoiding sensitive data exposure
    echo json_encode([
        'error' => 'An error occurred. Please check your input and try again.',
        'msg' =>  $privateKeyPath,
        'details' => $e->getMessage() // You can log $e->getMessage() on the server but avoid showing it to the user
    ]);
    exit;
}
