<?php

return [
    'client_key' => env('VITE_MIDTRANS_CLIENT_KEY'),
    'server_key' => env('VITE_MIDTRANS_SERVER_KEY'),
    'is_production' => env('VITE_MIDTRANS_IS_PRODUCTION'),
    'is_sanitized' => true,
    'is_3ds' => true,
];
