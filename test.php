<?php

// Include PHPush
require_once 'PHPush.php';

// Adding Android key
\PHPush\PHPush::Provider(\PHPush\Provider::PROVIDER_ANDROID)->setAccessKey('test');

// Adding iOS certificate
\PHPush\PHPush::Provider(\PHPush\Provider::PROVIDER_IOS)->setCertificate('ck.pem');

// Creating new queue
$queue = \PHPush\PHPush::Queue();

// Adding some devices
$queue->add(new \PHPush\providers\android\Device('adsfadsafads'));
$queue->add(new \PHPush\providers\ios\Device('adsfadsf'));

// Setting message
$queue->message('Hello World!');

$queue->send();