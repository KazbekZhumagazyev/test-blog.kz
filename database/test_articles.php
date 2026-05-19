<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Database;
use App\Repository\ArticleRepository;

$repo = new ArticleRepository(Database::getConnection());

echo "Article #1:\n";
print_r($repo->findById(1));

echo "\nArticles in category #1 (limit 5):\n";
print_r($repo->findByCategory(1, 5, 0));

echo "\nCount in category #1: " . $repo->countByCategory(1) . "\n";
