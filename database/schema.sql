CREATE TABLE `ghalib-mails` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender VARCHAR(255) NOT NULL,
    receiver VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('sent', 'received', 'read', 'archived') DEFAULT 'received',
    INDEX (receiver),
    INDEX (created_at)
);
