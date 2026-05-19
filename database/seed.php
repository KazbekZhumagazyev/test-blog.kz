<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Database;

$pdo = Database::getConnection();

echo "Seeding database...\n";

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE article_category');
$pdo->exec('TRUNCATE TABLE articles');
$pdo->exec('TRUNCATE TABLE categories');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$categories = [
    ['name' => 'PHP', 'description' => 'Статьи о PHP и веб-разработке на нём.'],
    ['name' => 'JavaScript', 'description' => 'Frontend, Node.js и экосистема JS.'],
    ['name' => 'MySQL', 'description' => 'Базы данных, запросы и проектирование схем.'],
];

$insertCategory = $pdo->prepare(
    'INSERT INTO categories (name, description) VALUES (:name, :description)',
);
$categoryIds = [];
foreach ($categories as $row) {
    $insertCategory->execute($row);
    $categoryIds[$row['name']] = (int) $pdo->lastInsertId();
}

$insertArticle = $pdo->prepare(
    'INSERT INTO articles (title, description, body, image, views, published_at)
     VALUES (:title, :description, :body, :image, :views, :published_at)',
);
$linkCategory = $pdo->prepare(
    'INSERT INTO article_category (article_id, category_id) VALUES (:article_id, :category_id)',
);

$articles = [
    ['title' => 'С чего начать изучение PHP', 'cat' => ['PHP'], 'days_ago' => 1, 'views' => 120],
    ['title' => 'PDO и безопасная работа с MySQL', 'cat' => ['PHP', 'MySQL'], 'days_ago' => 2, 'views' => 95],
    ['title' => 'Массивы в PHP 8', 'cat' => ['PHP'], 'days_ago' => 3, 'views' => 80],
    ['title' => 'ООП в PHP без фреймворков', 'cat' => ['PHP'], 'days_ago' => 4, 'views' => 210],
    ['title' => 'Сессии и cookies', 'cat' => ['PHP'], 'days_ago' => 5, 'views' => 45],
    ['title' => 'Валидация форм на чистом PHP', 'cat' => ['PHP'], 'days_ago' => 6, 'views' => 67],
    ['title' => 'Подключение Smarty к проекту', 'cat' => ['PHP'], 'days_ago' => 7, 'views' => 150],
    ['title' => 'Структура простого MVC', 'cat' => ['PHP'], 'days_ago' => 8, 'views' => 88],
    ['title' => 'Обработка ошибок в PHP', 'cat' => ['PHP'], 'days_ago' => 9, 'views' => 33],
    ['title' => 'Composer autoload PSR-4', 'cat' => ['PHP'], 'days_ago' => 10, 'views' => 102],
    ['title' => 'Роутинг без фреймворка', 'cat' => ['PHP'], 'days_ago' => 11, 'views' => 175],
    ['title' => 'Пагинация на чистом SQL', 'cat' => ['PHP', 'MySQL'], 'days_ago' => 12, 'views' => 60],
    ['title' => 'Основы ES6', 'cat' => ['JavaScript'], 'days_ago' => 2, 'views' => 140],
    ['title' => 'Fetch API и работа с бэкендом', 'cat' => ['JavaScript'], 'days_ago' => 4, 'views' => 77],
    ['title' => 'Модули в JavaScript', 'cat' => ['JavaScript'], 'days_ago' => 6, 'views' => 55],
    ['title' => 'DOM и события', 'cat' => ['JavaScript'], 'days_ago' => 8, 'views' => 99],
    ['title' => 'Нормализация таблиц', 'cat' => ['MySQL'], 'days_ago' => 3, 'views' => 110],
    ['title' => 'Индексы и производительность', 'cat' => ['MySQL'], 'days_ago' => 5, 'views' => 200],
    ['title' => 'JOIN и связи many-to-many', 'cat' => ['MySQL'], 'days_ago' => 7, 'views' => 130],
    ['title' => 'Транзакции в MySQL', 'cat' => ['MySQL'], 'days_ago' => 9, 'views' => 48],
];

$articleCount = 0;
foreach ($articles as $index => $item) {
    $num = $index + 1;
    $publishedAt = (new DateTimeImmutable())->modify('-' . $item['days_ago'] . ' days')->format('Y-m-d H:i:s');

    $insertArticle->execute([
        'title' => $item['title'],
        'description' => 'Краткое описание статьи «' . $item['title'] . '».',
        'body' => "Полный текст статьи «{$item['title']}».\n\n"
            . "Это демонстрационный контент из сидера для тестового задания блога.\n"
            . "Здесь может быть несколько абзацев с подробностями.",
        'image' => 'https://picsum.photos/seed/blog' . $num . '/800/400',
        'views' => $item['views'],
        'published_at' => $publishedAt,
    ]);

    $articleId = (int) $pdo->lastInsertId();
    ++$articleCount;

    foreach ($item['cat'] as $categoryName) {
        $linkCategory->execute([
            'article_id' => $articleId,
            'category_id' => $categoryIds[$categoryName],
        ]);
    }
}

echo "Done: " . count($categoryIds) . " categories, {$articleCount} articles.\n";
