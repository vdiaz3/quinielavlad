<?php
require_once 'vendor/autoload.php';
session_start();

// init configuration
$clientID = '372013296072-q9ht1oldith810uepu10dme687f7bfb6.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://quiniela.website/auth.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $foto =  $google_account_info->picture;
  $id =  $google_account_info->id;

$conn = new mysqli("localhost", "root", "14526931", "worldcup_db");
 
$sql_insert="insert into usuario (nombre,email,auth_id,foto) values ('".$name."','".$email."','".$google_oauth."','".$foto."')";
mysqli_query($conn , $sql_insert);

  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>