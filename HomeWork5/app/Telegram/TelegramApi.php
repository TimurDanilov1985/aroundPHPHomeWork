<?php

namespace App\Telegram;

interface TelegramApi {
    public function __construct(string $token);

    // /**
    //  * @return TelegramMessageDto[]
    //  */

    public function getMessage(int $offset): array;

    public function sendMessage(string $chatId, string $text);
}
