<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Database;
use App\Repository\CategoryRepository;

$repo = new CategoryRepository(Database::getConnection());

echo "Categories with articles:\n";
print_r($repo->findAllWithArticles());

echo "\nCategory #1:\n";
print_r($repo->findById(1));
