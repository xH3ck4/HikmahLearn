<?php

return [
    'secret' => env('VITE_NOCAPTCHA_SECRET'),
    'sitekey' => env('VITE_NOCAPTCHA_SITEKEY'),
    'options' => [
        'timeout' => 30,
    ],
];
