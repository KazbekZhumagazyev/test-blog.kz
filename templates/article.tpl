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

    <p><a href="?route=home">← На главную</a></p>
{/block}
