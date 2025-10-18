<?php

use HomeCalculator\Delivery\LevelEnum;
use HomeCalculator\Delivery\Telegram\Notification;
use HomeCalculator\Logger\Log;
use Monolog\Level;

require_once "../../vendor/autoload.php";

$site = htmlspecialchars(trim($_POST['field-site'] ?? ''));

if ('' === $site || false === filter_var($site, FILTER_VALIDATE_URL)) {
    $message = 'Field "field-site" must be valid URL';
    Log::create($message, Level::Error);
    throw new InvalidArgumentException($message);
}

$message = "Просьба добавить услуги поставщика: $site";
$additionalMessage = htmlspecialchars(trim($_POST['additional-message'] ?? ''));

if ('' !== $additionalMessage) {
    $message .= "\n";

    if (strlen($additionalMessage) > 255) {
        Log::create(__FILE__ . ": reached limit of input data - 255 chars, tale was cut", Level::Debug);
        $additionalMessage = substr($additionalMessage, 0, 255);
    }

    $message .= $additionalMessage;
}



$notification = new Notification($message, LevelEnum::TASK->value);
$notification->send();