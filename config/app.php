<?php

return [
    'name' => 'Digita Marketing',
    'env' => getenv('APP_ENV', 'production'),
    'debug' => getenv('APP_DEBUG', false),
    $envUrl = getenv('APP_URL') ?: 'http://localhost';
define('BASE_URL', rtrim($envUrl, '/'));

    'timezone' => 'UTC',
    'locale' => 'fr',
    'key' => getenv('APP_KEY'),
];
