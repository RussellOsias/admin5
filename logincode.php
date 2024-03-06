<?php
// Start the session to manage user authentication
session_start();

// Include file for database connection
include('config/db_conn.php');

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Function to sanitize input data
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the login button is clicked or if the user is logged in via Facebook
if (isset($_POST['login_btn'])) {
    // Sanitize username and password from the form submission
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);

    // Query the database for user credentials
    $sql = "SELECT * FROM user_profile WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if a row is found with matching credentials
        if (mysqli_num_rows($result) == 1) {
            // Fetch user details from the database
            $row = mysqli_fetch_assoc($result);
            // Set session variables for authenticated user
            $_SESSION['auth'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $row['user_id'],
                'full_name' => $row['full_name'],
                'email' => $row['email'],
                'phone_number' => $row['phone_number'],
                'address' => $row['address']
            ];
            // Send email notification
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'uchihareikata@gmail.com'; // Your Gmail email address
                $mail->Password = 'qyki jszw moov wvhz'; // Your Gmail password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('uchihareikata@gmail.com', 'Russell Osias'); // Your email address and name
                $mail->addAddress($_POST['email']); // Recipient's email address
                $mail->isHTML(true);
                $mail->Subject = 'Login Notification';
                $mail->Body = 'Hello ' . $row['full_name'] . ',<br><br>You have successfully logged in to your account.';
                // Send email
                $mail->send();
            } catch (Exception $e) {
                // Handle errors if email sending fails
                $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: login.php");
                exit();
            }
            // Set status message and redirect to index page
            $_SESSION['status'] = "Logged in Successfully";
            header("Location: index.php");
            exit();
        } else {
            // If no matching credentials found, set error message and redirect to login page
            $_SESSION['status'] = "Invalid email or password";
            header("Location: login.php");
            exit();
        }
    } else {
        // If database query fails, set error message with error details and redirect to login page
        $_SESSION['status'] = "Error: " . mysqli_error($conn);
        header("Location: login.php");
        exit();
    }
} elseif (isset($_SESSION['facebook_user'])) {
    // If the user is logged in via Facebook
    $_SESSION['auth'] = true;
    $_SESSION['auth_user'] = $_SESSION['facebook_user'];
    header("Location: index.php");
    exit();
} else {
    // If login button is not clicked and user is not logged in via Facebook, deny access and redirect to login page
    $_SESSION['status'] = "Access Denied";
    header("Location: login.php");
    exit();
}
?>
