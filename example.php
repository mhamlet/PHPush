<?php

// Include PHPush
require_once 'vendor/autoload.php';

use PHPush\PHPush;

// Setting environment
PHPush::Environment(PHPush::ENVIRONMENT_PRODUCTION);

// Adding Android key
PHPush::Provider(\PHPush\Provider::PROVIDER_ANDROID)->setAccessKey('test');

// Adding iOS certificate
PHPush::Provider(\PHPush\Provider::PROVIDER_IOS)->setCertificate('ck.pem');

// Creating new queue
$queue = PHPush::Queue();

// Adding some devices
$queue->add(new \PHPush\providers\android\Device('android_registration_id'));
$queue->add(new \PHPush\providers\ios\Device('ios_device_token'));

// Setting message
$queue->message('Hello World!');

// Send message. You can provide custom fields to this method.
// Also you can pass sound and passphrase with this custom fields
$queue->send(array(
    'custom' => 'field',
    'sound' => 'popup.aif',
    'passphase' => 'phpush',
));

// Creating another queue
$another_queue = PHPush::Queue();

// Adding only one device
$another_queue->add(new \PHPush\providers\ios\Device('another_or_the_same_ios_device_token'));

// Setting message
$another_queue->message('Hello World! I\'m second queue!');

// This will not open a connection to APNS server again.
// It will use the old connection
$another_queue->send();
