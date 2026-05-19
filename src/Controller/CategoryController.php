<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\View;

final class CategoryController
{
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

        $sort = $this->resolveSort($params['sort'] ?? null);
        $perPage = max(1, (int) ($this->config['per_page'] ?? 10));
        $total = $articleRepo->countByCategory($id);
        $totalPages = max(1, (int) ceil($total / $perPage));

        $page = isset($params['page']) ? (int) $params['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $perPage;
        $articles = $articleRepo->findByCategory($id, $perPage, $offset, $sort);

        View::render('category.tpl', [
            'title' => $category['name'] . ' — ' . $appName,
            'app_name' => $appName,
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_articles' => $total,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
            'prev_page' => $page - 1,
            'next_page' => $page + 1,
        ]);
    }

    private function resolveSort(mixed $sort): string
    {
        return $sort === 'views' ? 'views' : 'date';
    }
}
