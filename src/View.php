<?php

declare(strict_types=1);

namespace App;

use Smarty;

final class View
{
    private static ?Smarty $smarty = null;

    public static function render(string $template, array $data = []): void
    {
        $smarty = self::smarty();

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($template);
    }

    private static function smarty(): Smarty
    {
        if (self::$smarty !== null) {
            return self::$smarty;
        }

        $config = require dirname(__DIR__) . '/config/smarty.php';

        foreach (['compile_dir', 'cache_dir'] as $dirKey) {
            $dir = $config[$dirKey];
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['template_dir']);
        $smarty->setCompileDir($config['compile_dir']);
        $smarty->setCacheDir($config['cache_dir']);
        $smarty->caching = Smarty::CACHING_OFF;

        self::$smarty = $smarty;

        return self::$smarty;
    }
}
