<?php

return [
    'name' => 'Digita Marketing',
    'env' => getenv('APP_ENV', 'production'),
    'debug' => getenv('APP_DEBUG', false),
    'url' => getenv('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => 'fr',
    'key' => getenv('APP_KEY'),
];
