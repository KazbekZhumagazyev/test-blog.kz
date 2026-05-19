<?php

declare(strict_types=1);

$config = require dirname(__DIR__) . '/bootstrap.php';

header('Content-Type: text/html; charset=utf-8');

$title = $config['name'] ?? 'Blog';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <p><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> — setup OK</p>
</body>
</html>
