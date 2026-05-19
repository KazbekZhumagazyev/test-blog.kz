<?php

declare(strict_types=1);

use App\Router;

$config = require dirname(__DIR__) . '/bootstrap.php';

$route = $_GET['route'] ?? 'home';
$params = [
    'id' => $_GET['id'] ?? null,
    'sort' => $_GET['sort'] ?? null,
    'page' => $_GET['page'] ?? null,
];

(new Router($config))->dispatch($route, $params);
