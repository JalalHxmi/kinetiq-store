<?php

return [
    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
        'publishable' => env('STRIPE_PUBLISHABLE'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],
];
