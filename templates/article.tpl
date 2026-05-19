{extends file="layout.tpl"}

{block name=content}
    <article class="article-detail">
        <h2>{$article.title|escape}</h2>

        <p class="meta">
            {$article.published_at|date_format:'%d.%m.%Y %H:%M'}
            · {$article.views} просмотров
        </p>

        {if $categories|@count > 0}
            <p class="categories">
                Категории:
                {foreach $categories as $cat name=catloop}
                    <a href="?route=category&amp;id={$cat.id}">{$cat.name|escape}</a>{if not $smarty.foreach.catloop.last}, {/if}
                {/foreach}
            </p>
        {/if}

        {if $article.image}
            <p class="article-image">
                <img src="{$article.image|escape}" alt="{$article.title|escape}">
            </p>
        {/if}

        {if $article.description}
            <p class="lead">{$article.description|escape}</p>
        {/if}

        <div class="article-body">
            {$article.body|escape|nl2br nofilter}
        </div>
    </article>

    {if $related|@count > 0}
        <aside class="related-articles">
            <h3>Похожие статьи</h3>
            <ul>
                {foreach $related as $item}
                    <li>
                        <a href="?route=article&amp;id={$item.id}">{$item.title|escape}</a>
                        <span class="meta">{$item.published_at|date_format:'%d.%m.%Y'}</span>
                    </li>
                {/foreach}
            </ul>
        </aside>
    {/if}

    <p><a href="?route=home">← На главную</a></p>
{/block}
