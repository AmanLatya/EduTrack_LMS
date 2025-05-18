<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once '../ConnectDataBase.php';

use Google\Client;
use Google\Service\Oauth2;

include_once 'APIConfig.php';

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

$stuEmail = $userinfo->email;
$stuName = $userinfo->name;

if (!isset($_SESSION['is_stuLogin'])) {
    $sql = "SELECT Stu_Name FROM student WHERE Stu_Email = '$stuEmail'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['is_stuLogin'] = true;
        $_SESSION['stuLoginEmail'] = $stuEmail;
        echo "<script>location.href = '../index.php'</script>";
    } else {
        echo "Login Failed";
    }
} else {
    echo "<script>location.href = '../index.php'</script>";
}



