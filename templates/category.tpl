{extends file="layout.tpl"}

{block name=content}
    <h2>{$category.name|escape}</h2>

    {if $category.description}
        <p class="category-desc">{$category.description|escape}</p>
    {/if}

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
    {/if}

    <p><a href="?route=home">← На главную</a></p>
{/block}
