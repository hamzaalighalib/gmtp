<?php
require_once __DIR__ . '/../lib/config.php';
require_once __DIR__ . '/../lib/helpers.php';

header('Content-Type: application/json');

// Function to convert datetime to "time ago" format
function time_ago($timestamp) {
    $time = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time;
    $seconds = $time_difference;
    
    $minutes      = round($seconds / 60);           // value 60 is seconds
    $hours        = round($seconds / 3600);         // value 3600 is 60 minutes * 60 sec
    $days         = round($seconds / 86400);        // value 86400 is 24 hours * 60 minutes * 60 sec
    $weeks        = round($seconds / 604800);       // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
    $months       = round($seconds / 2629440);      // value 2629440 is ((365+365+365+365+365)/5/12) * 24 * 60 * 60
    $years        = round($seconds / 31553280);     // value 31553280 is 365.25 days * 24 hours * 60 minutes * 60 sec

    if ($seconds <= 60) {
        return "Just Now";
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hours ago";
        }
    } else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    } else if ($weeks <= 4.3) { // 4.3 == 30/7
        if ($weeks == 1) {
            return "a week ago";
        } else {
            return "$weeks weeks ago";
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "a month ago";
        } else {
            return "$months months ago";
        }
    } else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}

// Function to sanitize and prevent any potential errors from special characters
function sanitize_input($data) {
    // Remove any leading or trailing whitespace
    $data = trim($data);

    // Convert special characters to HTML entities to prevent XSS attacks
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    // Return sanitized input
    return $data;
}

// Ensure valid JSON output by escaping any special characters in the body
function cleanEmailBody($body) {
    // Strip HTML tags to remove unnecessary formatting
    $body = strip_tags($body);

    // Convert special characters to HTML entities
  //  $body = htmlspecialchars($body, ENT_QUOTES, 'UTF-8');

    // Escape quotes for JSON compatibility
    $body = addslashes($body);

    return $body;
}

// Respond with a JSON object
function respondWithJson($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit; // Ensure that no further code is executed after sending the response
}

try {
    // Establish database connection
    $config = include __DIR__ . '/../lib/config.php';
    $pdo = new PDO(
        'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'],
        $config['db_user'],
        $config['db_password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get query parameter
    $get = $_GET['get'] ?? null;

    // Debug: log the 'get' value to check if it's set properly
    error_log('GET parameter: ' . $get);

    if ($get == 'all') {
        // Fetch all emails
        $stmt = $pdo->query("SELECT id, sender, receiver, subject, body, status, created_at FROM `ghalib-mails` ORDER BY created_at DESC");

        // Check if the query returns any rows
        if ($stmt->rowCount() > 0) {
            $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format emails
            foreach ($emails as &$email) {
                // Add time ago field
                $email['timeAgo'] = time_ago($email['created_at']);
                // Truncate the body to 200 characters
                $email['body'] = substr($email['body'], 0, 150) . (strlen($email['body']) > 200 ? '...' : '');
                // Clean the email body
                $email['body'] = cleanEmailBody($email['body']);
            }

            echo json_encode([ 'success' => true, 'data' => $emails ]);
        } else {
            echo json_encode([ 'success' => true, 'message' => 'No emails found' ]);
        }

    } elseif ($get == 'read' && isset($_GET['id'])) {
        // Mark an email as read
        $emailId = sanitize_input($_GET['id']);  // Sanitize input
        $stmt = $pdo->prepare("UPDATE `ghalib-mails` SET status = 'read' WHERE id = :id");
        $stmt->execute(['id' => $emailId]);
        echo json_encode([ 'success' => true ]);

    } elseif ($get == 'one' && isset($_GET['id'])) {
        // Get a single email by ID
        $emailId = sanitize_input($_GET['id']);
        
        if (empty($emailId) || !is_numeric($emailId)) {
            respondWithJson(false, 'Invalid or missing email ID.');
        }

        // Fetch the main email
        $emailData = fetchEmailById($emailId);
        if (!$emailData) {
            respondWithJson(false, 'Email not found.');
        }

        // Add time ago field
        $emailData['timeAgo'] = time_ago($emailData['created_at']);

        // Fetch related emails
      //  $relatedEmails = fetchRelatedEmails($emailData['sender'], $emailData['receiver']);

        // $emailData['relatedEmails'] = sanitizeEmailBodies($relatedEmails);

        // Clean the main email body
        $emailData['body'] = cleanEmailBody($emailData['body']);

        respondWithJson(true, 'Email fetched successfully.', $emailData);
        
    } else {
        throw new Exception("Invalid request");
    }
} catch (PDOException $e) {
    // Handle database-related errors
    http_response_code(500);
    echo json_encode([ 'success' => false, 'error' => 'Database error: ' . $e->getMessage() ]);
} catch (Exception $e) {
    // Handle other errors
    http_response_code(500);
    echo json_encode([ 'success' => false, 'error' => $e->getMessage() ]);
}


/* Fetch an email by its ID using MySQLi.
 */
function fetchEmailById($id) {
    global $config;   
   // MySQLi Database connection
$mysqli = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

// Check connection
if ($mysqli->connect_error) {
    // Log the error and stop the script
    error_log('Connection failed: ' . $mysqli->connect_error);
    die('Database connection failed');
}

    // Validate ID to ensure it's a valid integer
    if (!is_numeric($id) || $id <= 0) {
        return null; // Invalid ID, return null or handle as needed
    }

    // Prepare query to fetch email by ID
    $query = "SELECT * FROM `ghalib-mails` WHERE id = ?";
    
    // Prepare the statement
    if ($stmt = $mysqli->prepare($query)) {
        // Bind the parameter to the query
        $stmt->bind_param('i', $id); // 'i' denotes integer for ID

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Fetch the email data (returns null if not found)
        $email = $result->fetch_assoc();

        if ($email) {
            // Return the email if found
            $stmt->close();
            return $email;
        } else {
            // No email found, return null
            $stmt->close();
            return null;
        }
    } else {
        // Log error if statement preparation fails
        error_log('Error preparing query: ' . $mysqli->error);
        return null; // Return null if an error occurred during preparation
    }
}



/**
 * Fetch related emails by sender and receiver.
 */
function fetchRelatedEmails($sender, $receiver) {
    global $pdo;
    $query = "
        SELECT id, sender, receiver, subject, body, status, created_at 
        FROM `ghalib-mails`
        WHERE sender = :sender OR receiver = :receiver
        ORDER BY created_at DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['sender' => $sender, 'receiver' => $receiver]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Sanitize email bodies for safety.
 */
function sanitizeEmailBodies($emails) {
    foreach ($emails as &$email) {
        $email['body'] = cleanEmailBody($email['body']);
    }
    return $emails;
}
