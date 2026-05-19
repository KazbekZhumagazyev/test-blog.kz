<?php

declare(strict_types=1);

namespace App\Controller;

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

        View::render('category.tpl', [
            'title' => 'Категория #' . $id . ' — ' . $appName,
            'app_name' => $appName,
            'page_title' => 'Категория #' . $id,
            'category_id' => $id,
        ]);
    }
}
