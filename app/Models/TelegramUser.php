<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'user_id',
        'telegram_user_id',
        'telegram_chat_id',
    ];
}
