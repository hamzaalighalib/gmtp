

# GMTP - Ghalib Mail Transfer Protocol

GMTP is a custom HTTP-based communication protocol designed as an alternative to SMTP for email transmission. Developed by Hamza Ali Ghalib, GMTP simplifies email handling by offering a user-friendly installation process and no need for custom domain or DNS configuration. This library is written entirely in **PHP** and requires **cURL** for making HTTP requests, **MySQLi** for database interactions, and **RSA encryption** for secure email transmission.

## Project Structure

The GMTP library is organized as follows:

```
ghalib-mail/
│
├── index.php           # Handles all routes and requests under `site.com/ghalib-mail`.
├── index2.php          # Customizable UI for the GMTP interface (users can modify this as needed).
├── lib/                
│   ├── generate_keys.php   # Dynamically generates private/public keys.
│   ├── helpers.php        # Utility functions like encryption, decryption, etc.
│   └── install.php        # Dynamically creates necessary routes.
├── routes/
│   ├── receive.php        # Endpoint for receiving emails (`/ghalib-mail/receive`).
│   └── send.php           # Endpoint for sending emails (`/ghalib-mail/send`).
└── database/
    └── schema.sql         # SQL file containing the database schema.
```

## Requirements

Before you begin, ensure that your server meets the following requirements:

- **PHP**: Version 7.0 or higher.
- **cURL**: For making HTTP requests.
- **MySQLi**: For database interactions.
- **RSA Keys**: Public and private keys for encryption/decryption.

Make sure these are enabled and configured in your PHP installation to run GMTP successfully.

## Features

- **No DNS Configuration Needed**: Unlike traditional email systems, GMTP does not require custom domain setup or DNS configuration.
- **Dynamically Generated Keys**: GMTP automatically generates public and private keys for email encryption using **RSA**.
- **User-Friendly Installation**: Installation is simple and requires minimal configuration.
- **Customizable Email Receiver**: The `receive.php` endpoint is customizable, allowing you to tailor the email receiving functionality to your needs.
- **Customizable UI**: The `index2.php` file provides a flexible UI that users can freely modify to fit their design preferences.
- **PHP-Only**: The entire library is written in PHP and does not require additional external services or frameworks beyond PHP, cURL, and MySQLi.

## Installation

Follow these steps to install and use GMTP:

1. **Download/Clone the Repository**:  
   Download or clone the GMTP repository into the root folder of your website (e.g., `/ghalib-mail`).

2. **Navigate to the Installation URL**:  
   Once you've placed the library in your root folder, visit the installation page by going to `site.com/ghalib-mail`.

3. **Configure Database**:  
   During installation, you will be prompted to provide your database configuration details (e.g., database name, username, and password). Make sure your server has **MySQLi** enabled.

4. **Click to Install**:  
   After entering your database details, click the "Install" button to complete the process. The system will automatically create the necessary database schema and routes for GMTP.

5. **Finish Setup**:  
   After installation, the library will be ready to use!

## Encryption and Keys

GMTP uses **RSA encryption** for secure email transmission:

- The system generates **public** and **private** keys automatically during installation.
- The **private key** is used for decrypting messages, and the **public key** is used for encrypting messages.

Make sure to store these keys securely.

## cURL for HTTP Requests

GMTP uses **cURL** to send encrypted email data securely via **HTTPS** or **HTTP**. The library attempts requests over **HTTPS** first, and falls back to **HTTP** if HTTPS is unavailable.

## Important Notes

- **Install in Root Folder**:  
  For proper functionality, ensure the GMTP library is installed in the root folder of your website (i.e., `/ghalib-mail`).
  
- **Custom Email Receiver**:  
  The `receive.php` file in the `routes/` folder handles email reception. You can customize this file to fit your needs.

- **UI Customization**:  
  If you'd like to change the user interface, simply edit the `index2.php` file. This file is designed to be flexible and can be fully customized to match your own preferences or branding.

## Ongoing Work

We are continuously working to improve GMTP and make it more secure and feature-rich. Our current efforts include:

- **Enhanced Security**: We're implementing additional security measures to further protect your email communications.
- **Better Encryption**: We're refining our encryption protocols to ensure that email transmissions remain safe and private.
- **Feature Updates**: We're adding new features and improvements based on user feedback to make GMTP even more powerful.

Be sure to check for updates and new releases regularly to take advantage of the latest features and security improvements.

## Open Source

GMTP is open-source and freely available for everyone to use, modify, and contribute to. Feel free to fork the repository, submit pull requests, and help us make GMTP better!

## License

This project is licensed under the MIT License.
