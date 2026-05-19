<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\View;

final class HomeController
{
    public function __construct(
        private readonly array $config,
    ) {
    }

    public function handle(): void
    {
        $appName = $this->config['name'] ?? 'Blog';
        $db = Database::getConnection();

        $categoryRepo = new CategoryRepository($db);
        $articleRepo = new ArticleRepository($db);

        $sections = [];
        foreach ($categoryRepo->findAllWithArticles() as $category) {
            $categoryId = (int) $category['id'];
            $sections[] = [
                'category' => $category,
                'articles' => $articleRepo->findLatestByCategory($categoryId, 3),
            ];
        }

        View::render('home.tpl', [
            'title' => 'Главная — ' . $appName,
            'app_name' => $appName,
            'page_title' => 'Главная',
            'sections' => $sections,
        ]);
    }
}
