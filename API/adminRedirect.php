<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once '../ConnectDataBase.php';
include_once 'AdminAPIConfig.php';
use Google\Client;
use Google\Service\Oauth2;
if (!isset($_GET["code"])) {
    exit("Login failed: Authorization code missing.");
}

// Fetch access token
$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

// Debugging: Check token response
if (isset($token['error'])) {
    exit("Error: " . $token['error'] . " - " . $token['error_description']);
}

if (!isset($token["access_token"])) {
    exit("Error: Access token not received.");
}

$client->setAccessToken($token["access_token"]);

// Fetch user info
$oauth = new Oauth2($client);
$userinfo = $oauth->userinfo->get();

$adminEmail = $userinfo->email;
$adminName = $userinfo->name;

if (!isset($_SESSION['is_AdminLogin'])) {
    $sql = "SELECT Admin_Name FROM admin WHERE Admin_Email = '$adminEmail'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['is_AdminLogin'] = true;
        $_SESSION['AdminLoginEmail'] = $adminEmail;
        echo "<script>location.href = '../index.php'</script>";
    } else {
        echo "Login Failed";
    }
} else {
    echo "Already LoggedIn";
}
