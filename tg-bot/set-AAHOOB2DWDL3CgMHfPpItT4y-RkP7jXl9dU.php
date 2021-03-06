<?php
/**
 * README
 * This file is intended to set the webhook.
 * Uncommented parameters must be filled
 */

// Load composer
require_once __DIR__ . '/../vendor/autoload.php';

// Add you bot's API key and name
$bot_api_key  = '588857334:AAHOOB2DWDL3CgMHfPpItT4y-RkP7jXl9dU';
$bot_username = 'btsuzbot';

// Define the URL to your hook.php file
$hook_url     = 'https://maktab.zipwolf.uz/tg-bot/bot-AAHOOB2DWDL3CgMHfPpItT4y-RkP7jXl9dU.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Set webhook
    $result = $telegram->setWebhook($hook_url);
    //$result = $telegram->deleteWebhook();

    // To use a self-signed certificate, use this line instead
    //$result = $telegram->setWebhook($hook_url, ['certificate' => $certificate_path]);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}
