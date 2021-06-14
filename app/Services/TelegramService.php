<?php 
namespace App\Services;

use Illuminate\Support\Facades\Log;

class TelegramService
{
    public $token;
    public $api_url = 'https://api.telegram.org/bot';

    public function send($chat_id, $message)
    {
        $response = file_get_contents(
            $this->api_url . config('app.token_bot') . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message)
        );

        Log::info($response);
    }
}