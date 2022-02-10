<?php

require 'vendor/autoload.php';

ini_set('display_errors', true);
header('Content-Type: application/json, charset=UTF-8');

$requestPayload = file_get_contents('php://input');
$fields = json_decode($requestPayload);

if (!filter_var($fields->email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email format']);
    exit;
}

$newsLetter = new \Dovile\Newsletter\NewsletterSubscription();
if ($newsLetter->saveEmail($fields->email)) {
    $message = null;
} else {
    $message = $newsLetter->getError();
}
echo json_encode(['error' => $message]);














