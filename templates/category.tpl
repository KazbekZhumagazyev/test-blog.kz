{extends file="layout.tpl"}

{block name=content}
    <h2>{$category.name|escape}</h2>

    {if $category.description}
        <p class="category-desc">{$category.description|escape}</p>
    {/if}

    <p class="sort-links">
        Сортировка:
        <a href="?route=category&amp;id={$category.id}&amp;sort=date"{if $sort == 'date'} class="active"{/if}>по дате</a>
        |
        <a href="?route=category&amp;id={$category.id}&amp;sort=views"{if $sort == 'views'} class="active"{/if}>по просмотрам</a>
    </p>

    {if $articles|@count == 0}
        <p>В этой категории пока нет статей.</p>
    {else}
        <ul class="article-list">
            {foreach $articles as $article}
                <li>
                    <a href="?route=article&amp;id={$article.id}">{$article.title|escape}</a>
                    <span class="meta">
                        {$article.published_at|date_format:'%d.%m.%Y'}
                        · {$article.views} просмотров
                    </span>
                    {if $article.description}
                        <p class="excerpt">{$article.description|escape}</p>
                    {/if}
                </li>
            {/foreach}
        </ul>

        {if $total_pages > 1}
            <nav class="pagination">
                {if $has_prev}
                    <a href="?route=category&amp;id={$category.id}&amp;sort={$sort}&amp;page={$prev_page}">← Назад</a>
                {/if}
                <span class="page-info">Страница {$current_page} из {$total_pages}</span>
                {if $has_next}
                    <a href="?route=category&amp;id={$category.id}&amp;sort={$sort}&amp;page={$next_page}">Вперёд →</a>
                {/if}
            </nav>
        {/if}
    {/if}

    <p><a href="?route=home">← На главную</a></p>
{/block}
