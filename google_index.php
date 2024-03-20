<?php
include_once 'google_config.php';

if (isset($_SESSION['user_token'])) {
  header("Location: index.php");
} else {
  header("Location: " . $client->createAuthUrl());
  exit; // Ensure that no further code is executed after redirection
}
?>
