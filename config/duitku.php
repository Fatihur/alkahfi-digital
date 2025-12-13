<?php

return [
    'merchant_code' => env('DUITKU_MERCHANT_CODE', ''),
    'api_key' => env('DUITKU_API_KEY', ''),
    'is_production' => env('DUITKU_IS_PRODUCTION', false),
    'callback_url' => env('DUITKU_CALLBACK_URL', ''),
    'return_url' => env('DUITKU_RETURN_URL', ''),
    'expiry_period' => env('DUITKU_EXPIRY_PERIOD', 1440), // dalam menit (default 24 jam)
];
