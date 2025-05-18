<?php

require 'C:/xampp/htdocs/EduTrack/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('C:/xampp/htdocs/EduTrack');
$dotenv->load();

$client = new Google\Client;
$client->setClientId($_ENV['GOOGLE_STU_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_STU_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_STU_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

// $url = $client->createAuthUrl();

?>
