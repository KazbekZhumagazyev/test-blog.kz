<?php

declare(strict_types=1);

namespace App;

use App\Controller\ArticleController;
use App\Controller\CategoryController;
use App\Controller\HomeController;

final class Router
{
    public function __construct(
        private readonly array $config,
    ) {
    }

    public function dispatch(string $route, array $params = []): void
    {
        match ($route) {
            'home' => (new HomeController($this->config))->handle(),
            'category' => (new CategoryController($this->config))->handle($params),
            'article' => (new ArticleController($this->config))->handle($params),
            default => $this->notFound(),
        };
    }

    private function notFound(): void
    {
        http_response_code(404);

        View::render('error.tpl', [
            'title' => 'Страница не найдена',
            'app_name' => $this->config['name'] ?? 'Blog',
            'message' => 'Страница не найдена',
        ]);
    }
}
