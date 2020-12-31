<?php

return [
    'login_block_minutes'          => (int)env('LOGIN_BLOCK_MINUTES', 20),
    'login_max_attempts'           => (int)env('LOGIN_MAX_ATTEMPTES', 5),
    'email_verify_time'            => (int)env('EMAIL_VERIFY_TIME', 1440),
    'email_send_throttle_count'    => (int)env('EMAIL_SEND_THROTTLE_COUNT', 5),
    'email_send_throttle_ban_time' => (int)env('EMAIL_SEND_THROTTLE_BAN_TIME', 240),
    'tz'                           => env('DATE_TIMEZONE', 'UTC'),
];