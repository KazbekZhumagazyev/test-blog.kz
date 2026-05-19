<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Repository\ArticleRepository;
use App\View;

final class ArticleController
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
                'message' => 'Не указана статья',
            ]);

            return;
        }

        $articleRepo = new ArticleRepository(Database::getConnection());
        $article = $articleRepo->findById($id);

        if ($article === null) {
            http_response_code(404);
            View::render('error.tpl', [
                'title' => 'Не найдено — ' . $appName,
                'app_name' => $appName,
                'message' => 'Статья не найдена',
            ]);

            return;
        }

        $articleRepo->incrementViews($id);
        $article = $articleRepo->findById($id);

        $categories = $articleRepo->findCategoriesForArticle($id);

        View::render('article.tpl', [
            'title' => $article['title'] . ' — ' . $appName,
            'app_name' => $appName,
            'article' => $article,
            'categories' => $categories,
        ]);
    }
}
