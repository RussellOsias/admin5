<?php
session_start();

$fbappid = "738619605004027";
$redirectURL = "http://localhost/admin5/fbcallback.php"; // Corrected redirect URL
$fbPermissions = ['email'];

require_once __DIR__ . '/Facebook/autoload.php';
use Facebook\Facebook;

$facebook = new Facebook(array('app_id' => $fbappid, 'app_secret' => $fbappsecret, 'default_graph_version' => 'v2.10'));

$helper = $facebook->getRedirectLoginHelper();

try {
    // Generate a CSRF token and store it in the session
    $_SESSION['FBRLH_state'] = $helper->getPersistentDataHandler()->get('state');

    // Get the login URL with the CSRF token
    $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
} catch (FacebookResponseException $e) {
    echo 'Facebook Response error: ' . $e->getMessage();
    exit;
} catch (FacebookSDKException $e) {
    echo 'Facebook SDK error: ' . $e->getMessage();
    exit;
}
?>

<!-- Redirect the user to the Facebook login URL -->
<a href="<?php echo $loginURL; ?>">Login with Facebook</a>
