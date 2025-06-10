<?php
require_once 'vendor/autoload.php'; // Ini dari Google Client Library, pastiin sudah install via Composer

$google_client = new Google_Client();
$google_client->setClientId('529553398583-m7utstjilfhg4c1ii33kfcj0iisba888.apps.googleusercontent.com');
$google_client->setClientSecret('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');
$google_client->setRedirectUri('http://localhost/okmweb/login-google.php');
$google_client->addScope('email');
$google_client->addScope('profile');
