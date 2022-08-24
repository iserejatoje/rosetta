<div class="container">
    <h1 class="page-title">НОВОСТИ</h1>

    <div class="page-news">
        <div class="news-by-years">
            <? if(is_array($vars['years']) && count($vars['years']) > 0) { ?>
                <form action="/news/" method="post" data-type="ajax-form" data-form="ajax-filter" class="news-grid-form">
                    <input type="hidden" name="action" value="ajax_news_filter">
                    <select name="news_year" class="form-control" data-type="bare" name="year" autocomplete="off">
                        <? foreach($vars['years'] as $year) { ?>
                            <option value="<?=$year?>" data-trigger="submitForm" selected>архив новостей: <?=$year?> </option>
                        <? } ?>
                    </select>
                </form>
            <? } ?>
        </div>

        <div class="news-grid">
            <?=STPL::Fetch('modules/news/list', $vars) ?>
        </div>

        <div class="show-all-button">
            <button class="btn-pink load-more-handl">показать все новости</button>
        </div>
    </div>
</div>