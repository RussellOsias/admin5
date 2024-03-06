<?php
session_start();

$fbappid = "738619605004027";
$fbappsecret = "e307494a67e754a6f099d5cb86101be4";
$redirectURL = "http://localhost/admin5/home.php"; // Updated redirect URL
$fbPermissions = ['email'];

require_once __DIR__ . '/Facebook/autoload.php';
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$facebook = new Facebook(array('app_id' => $fbappid, 'app_secret' => $fbappsecret, 'default_graph_version' => 'v2.10'));

$helper = $facebook->getRedirectLoginHelper();

try {
    // Get the access token
    $accessToken = $helper->getAccessToken();
    
    // Check if the access token is not null
    if (!isset($accessToken)) {
        // If no access token, redirect to the login page
        header('Location: fblogin.php');
        exit;
    }
    
    // Get user details from Facebook API
    $response = $facebook->get('/me?fields=id,name,email', $accessToken);
    $userData = $response->getGraphNode()->asArray();
    
    // Extract user data
    $fbUserId = $userData['id'];
    $fbUserName = $userData['name'];
    $fbUserEmail = $userData['email'];
    
    // Here, you can process the user data as needed, like saving to database, etc.
    
    // Redirect the user to home page after successful login
    header('Location: ' . $redirectURL);
    exit;
} catch (FacebookResponseException $e) {
    echo 'Facebook Response error: ' . $e->getMessage();
    exit;
} catch (FacebookSDKException $e) {
    echo 'Facebook SDK error: ' . $e->getMessage();
    exit;
}
?>
