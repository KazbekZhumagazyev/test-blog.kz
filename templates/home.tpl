{extends file="layout.tpl"}

{block name=content}
    <h2>{$page_title|escape}</h2>
    <p>Здесь будет список категорий и последние статьи.</p>
    <p class="muted">Тест маршрутов:</p>
    <ul>
        <li><a href="?route=category&amp;id=1">Категория #1</a></li>
        <li><a href="?route=article&amp;id=1">Статья #1</a></li>
    </ul>
{/block}
