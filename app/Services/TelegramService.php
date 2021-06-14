<?php 
namespace App\Services;

use Illuminate\Support\Facades\Log;

class TelegramService
{
    public $token;
    public $api_url = 'https://api.telegram.org/bot';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function send($chat_id, $message)
    {
        $response = file_get_contents(
            $this->api_url . $token . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message)
        );

        Log::info($response);
    }
}