<?php

declare(strict_types=1);

namespace HomeCalculator\Delivery\Telegram;

use HomeCalculator\Delivery\Delivery;

final class Alert extends Delivery
{
    private string $url;

    private string $token;

    private string $query;

    public function __construct(string $message)
    {
        parent::__construct();

        $this->url = $_ENV['TG_API_URL'];
        $this->token = $_ENV['TG_BOT_TOKEN'];
        $this->query = http_build_query([
            'chat_id' => $_ENV['TG_CHAT_ID'],
            'text' => $message
        ]);
    }

    public function send(): string
    {
        try {
            $ch = curl_init("$this->url/bot$this->token/sendMessage?$this->query");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $return = curl_exec($ch);
            curl_close($ch);

            return $return;
        } catch (\Exception $e) {
            throw new AlertException("Couldn't send message: " . $e->getMessage());
        }
    }
}