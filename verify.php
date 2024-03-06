<?php
// Start the session to manage user authentication
session_start();

// Include file for database connection
include('config/db_conn.php');

// Check if the verification form is submitted and the verification code is set
if (isset($_POST['verify']) && isset($_SESSION['verification_code'])) {
    $verification_code = $_POST['verification_code'];
    $expected_code = $_SESSION['verification_code'];

    // Check if entered code matches the expected code
    if ($verification_code == $expected_code) {
        // Verification successful, unset the verification code session variable
        unset($_SESSION['verification_code']);
        // Set session indicating successful login
        $_SESSION['user_logged_in'] = true;
        header("Location: index.php");
        exit();
    } else {
        // Verification failed, show error message
        $_SESSION['message'] = "Incorrect verification code.";
        $_SESSION['alert_type'] = "error";
        header("Location: verify_login.php");
        exit();
    }
} else {
    // If verification code is not set, deny access and redirect to login page
    $_SESSION['message'] = "Please log in to access this page";
    $_SESSION['alert_type'] = "error";
    header("Location: login.php");
    exit();
}
?>
