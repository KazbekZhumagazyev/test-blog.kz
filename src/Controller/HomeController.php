<?php

declare(strict_types=1);

namespace App\Controller;

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

        View::render('home.tpl', [
            'title' => 'Главная — ' . $appName,
            'app_name' => $appName,
            'page_title' => 'Главная',
        ]);
    }
}
