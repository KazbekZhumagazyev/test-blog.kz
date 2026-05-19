<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{$title|escape}</title>
</head>
<body>
    <header>
        <h1><a href="?route=home">{$app_name|escape}</a></h1>
        <nav>
            <a href="?route=home">Главная</a>
        </nav>
    </header>
    <main>
        {block name=content}{/block}
    </main>
</body>
</html>
