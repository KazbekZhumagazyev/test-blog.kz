{extends file="layout.tpl"}

{block name=content}
    <h2>{$page_title|escape}</h2>

    {if $sections|@count == 0}
        <p>Пока нет категорий со статьями.</p>
    {/if}

    {foreach $sections as $section}
        <section class="category-block">
            <h3>{$section.category.name|escape}</h3>
            {if $section.category.description}
                <p class="category-desc">{$section.category.description|escape}</p>
            {/if}

            {if $section.articles|@count > 0}
                <ul class="article-list">
                    {foreach $section.articles as $article}
                        <li>
                            <a href="?route=article&amp;id={$article.id}">{$article.title|escape}</a>
                            <span class="date">{$article.published_at|date_format:'%d.%m.%Y'}</span>
                        </li>
                    {/foreach}
                </ul>
            {/if}

            <p>
                <a class="btn-all" href="?route=category&amp;id={$section.category.id}">Все статьи</a>
            </p>
        </section>
    {/foreach}
{/block}
