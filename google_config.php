<?php
require_once 'vendor/autoload.php';
include('config/db_conn.php');
session_start();


// init configuration
$clientID = '861430640524-s63mi06h8103ehknt8votev3nfo9096m.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/admin5/index.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
