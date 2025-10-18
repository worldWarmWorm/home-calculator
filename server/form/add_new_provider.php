<?php

use HomeCalculator\Delivery\LevelEnum;
use HomeCalculator\Delivery\Telegram\Notification;
use HomeCalculator\Logger\Log;
use Monolog\Level;

require_once "../../vendor/autoload.php";

$response = [
    'success' => false,
    'message' => '',
];

try {
    $site = htmlspecialchars(trim($_POST['field-site'] ?? ''));
    $additionalMessage = htmlspecialchars(trim($_POST['additional-message'] ?? ''));

    if ('' === $site || false === filter_var($site, FILTER_VALIDATE_URL)) {
        throw new InvalidArgumentException('Поле "Ссылка на официальные сайт поставщика услуг" принимает url формат https://www.site.com');
    }

    if (strlen($additionalMessage) > 255) {
        $message = 'Достигнут лимит текста поля "Сообщение" 255 символов';
        Log::create($message, Level::Error);
        throw new InvalidArgumentException($message);
    }

    (new Notification("Добавить услуги поставщика: $site" . ('' === $additionalMessage ? '' : "\n$additionalMessage"), LevelEnum::TASK->value))->send();
    print_r(json_encode(['success' => true, 'message' => "Заявка на добавление поставщика $site успешно отправлена"], JSON_PRETTY_PRINT));
} catch (Throwable $exception) {
    Log::create($exception->getMessage(), Level::Error);
    $response['message'] = $exception->getMessage();
    print_r(json_encode($response, JSON_PRETTY_PRINT));
}
