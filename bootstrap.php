<?php

declare(strict_types=1);

$root = __DIR__;

require $root . '/vendor/autoload.php';

$envFile = $root . '/.env';
if (is_readable($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines !== false) {
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (!str_contains($line, '=')) {
                continue;
            }
            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\"'");
            $_ENV[$name] = $value;
            putenv($name . '=' . $value);
        }
    }
}

return require $root . '/config/app.php';
