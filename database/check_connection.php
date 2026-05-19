<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Database;

try {
    Database::getConnection()->query('SELECT 1');
    echo "Database connection OK\n";
    exit(0);
} catch (Throwable $e) {
    fwrite(STDERR, 'Database connection failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
