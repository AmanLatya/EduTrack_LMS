<?php
require "C:/xampp/htdocs/EduTrack/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // if you're inside /API
$dotenv->load();
$client = new Google\Client;

$client->setClientId($_ENV['GOOGLE_ADMIN_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_ADMIN_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_ADMIN_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

// $url = $client->createAuthUrl();

?>