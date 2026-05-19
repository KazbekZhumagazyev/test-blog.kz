<?php

declare(strict_types=1);

use App\View;

$config = require dirname(__DIR__) . '/bootstrap.php';

$appName = $config['name'] ?? 'Blog';

View::render('setup.tpl', [
    'title' => $appName,
    'app_name' => $appName,
]);
