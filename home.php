<?php
session_start();

// Include file for database connection
include('config/db_conn.php');
// Include file for authentication check
include('Authentication.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['logout_btn'])) {
    // Unset authentication session variables
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    // Set logout status message
    $_SESSION['status'] = "Logged out successfully";
    // Redirect to login page
    header('Location: login.php');
    exit(0);
}

// Check if the request method is POST
if (isset($_POST['AddUser'])) {
    // Your existing code for adding a user

    // Redirect to the appropriate page after processing the request
    header("Location: registered.php");
    exit();
}

// Check if the request method is POST
if (isset($_POST['UpdateUser'])) {
    // Your existing code for updating a user

    // Redirect to the appropriate page after processing the request
    header("Location: registered.php");
    exit();
}

// Check if the request method is POST
if (isset($_POST['DeleteUserbtn'])) {
    // Your existing code for deleting a user

    // Redirect to the appropriate page after processing the request
    header("Location: registered.php");
    exit();
}

// If none of the POST requests are triggered, redirect to home.php
header("Location: home.php");
exit();
?>
