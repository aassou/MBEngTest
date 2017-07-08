<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/MessagingService/Service.php';
require __DIR__ . '/src/Objects/Message.php';


$service = new \MessagingService\Service('YOU_ACCESS_KEY_HERE');
$service->send($_SERVER);
