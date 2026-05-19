<?php

declare(strict_types=1);

$env = static function (string $key, string $default = ''): string {
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return (string) $_ENV[$key];
    }

    $value = getenv($key);

    return $value !== false ? (string) $value : $default;
};

return [
    'host' => $env('DB_HOST', '127.0.0.1'),
    'port' => (int) $env('DB_PORT', '3306'),
    'database' => $env('DB_DATABASE', 'blog'),
    'username' => $env('DB_USERNAME', 'root'),
    'password' => $env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
];
