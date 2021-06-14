<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TelegramUser;

class TelegramController extends Controller
{
    public function handler(Request $request)
    {
        Log::info(implode(';', $request->all()));

        return response()
            ->json([], 200);
    }
}
