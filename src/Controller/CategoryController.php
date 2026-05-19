<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\View;

final class CategoryController
{
    private const LIST_LIMIT = 1000;

    public function __construct(
        private readonly array $config,
    ) {
    }

    public function handle(array $params): void
    {
        $appName = $this->config['name'] ?? 'Blog';
        $id = isset($params['id']) ? (int) $params['id'] : 0;

        if ($id < 1) {
            http_response_code(400);
            View::render('error.tpl', [
                'title' => 'Ошибка — ' . $appName,
                'app_name' => $appName,
                'message' => 'Не указана категория',
            ]);

            return;
        }

        $db = Database::getConnection();
        $categoryRepo = new CategoryRepository($db);
        $articleRepo = new ArticleRepository($db);

        $category = $categoryRepo->findById($id);
        if ($category === null) {
            http_response_code(404);
            View::render('error.tpl', [
                'title' => 'Не найдено — ' . $appName,
                'app_name' => $appName,
                'message' => 'Категория не найдена',
            ]);

            return;
        }

        $articles = $articleRepo->findByCategory($id, self::LIST_LIMIT, 0);

        View::render('category.tpl', [
            'title' => $category['name'] . ' — ' . $appName,
            'app_name' => $appName,
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
