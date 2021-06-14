<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TelegramUser;
use App\Models\CustomerPhone;
use App\Services\TelegramService;

class TelegramController extends Controller
{
    public function handler(Request $request, TelegramService $telegram)
    {
        Log::info($request->all());

        $data = $request->all();

        if ($data['message']['text'] === '/start') {
            // предлагаем ввести номер телефона

            $message = 'Введите свой номер телефона в формате 380XXXXXXXXX!';
            $telegram->send($data['message']['from']['id'], $message);

            return response()
                ->json([], 200);
        }

        if (preg_match('/380\d{3}\d{2}\d{2}\d{2}$/', $data['message']['text'])) {
            // Находим клиента по номеру телефона и записываем его chat_id в бд

            $phone = CustomerPhone::where('phone', trim($data['message']['text']))->first();

            if ($phone === NULL) {
                $message = 'Неверно введен номер телефона!';
                $telegram->send($data['message']['from']['id'], $message);

                return response()
                    ->json([], 200);
            }

            $telegramUser = TelegramUser::create([
                'user_id' => $phone->customer->id,
                'telegram_user_id' => $data['message']['from']['id'],
                'telegram_chat_id' => $date['message']['chat']['id'],
            ]);

            if ($telegramUser === NULL) {
                $message = 'Непредвиденная ошибка!';
                $telegram->send($data['message']['from']['id'], $message);

                return response()
                    ->json([], 200);
            }

            $message = 'Номер привязан. Теперь вы будете получать уведомления о смене статуса вашего заказа!';
            $telegram->send($data['message']['from']['id'], $message);

            return response()
                ->json([], 200);
        }

        $message = 'Неизвестная команда';
        $telegram->send($data['message']['from']['id'], $message);

        return response()
            ->json([], 200);
    }
}
