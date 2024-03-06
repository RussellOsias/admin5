<?php
require_once(__DIR__.'/Facebook/autoload.php');

define('APP_ID', '738619605004027');
define('APP_SECRET', 'e307494a67e754a6f099d5cb86101be4');
define('API_VERSION', 'v11.0');
define('FB_BASE_URL', 'http://localhost/admin5/'); // Make sure to include the trailing slash
define('BASE_URL', 'http://localhost/admin5/index.php'); // Make sure to include the full path

if(!session_id()){
    session_start();
}


// Call Facebook API
$fb = new Facebook\Facebook([
 'app_id' => APP_ID,
 'app_secret' => APP_SECRET,
 'default_graph_version' => API_VERSION,
]);


// Get redirect login helper
$fb_helper = $fb->getRedirectLoginHelper();


// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token']))
		{$accessToken = $_SESSION['facebook_access_token'];}
	else
		{$accessToken = $fb_helper->getAccessToken();}
} catch(FacebookResponseException $e) {
     echo 'Facebook API Error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK Error: ' . $e->getMessage();
      exit;
}

?>