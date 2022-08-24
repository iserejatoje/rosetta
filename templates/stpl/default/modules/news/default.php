<div class="container">
    <h1 class="page-title">НОВОСТИ</h1>

    <div class="page-news">
        <div class="news-by-years">
            <? if(is_array($vars['years']) && count($vars['years']) > 0) { ?>
                <form action="/news/" method="post" data-type="ajax-form" data-form="ajax-filter" class="news-grid-form">
                    <input type="hidden" name="action" value="ajax_news_filter">
                    <select name="news_year" class="form-control" data-type="bare" name="year" autocomplete="off">
                        <option value="<?=date('Y', time())?>" data-trigger="submitForm" selected>Текущие новости</option>
                        <?
                        $i = 0;
                        foreach($vars['years'] as $year) {
                            ++$i;
                            ?>
                            <option value="<?=$year?>" data-trigger="submitForm">архив новостей: <?=$year?> </option>
                        <? } ?>
                    </select>
                </form>
            <? } ?>
        </div>

        <? if($vars['count'] > 0) { ?>
            <div class="news-grid" id="news-block-list">
                <?=STPL::Fetch('modules/news/list', $vars) ?>
            </div>

            <? if($vars['last_page'] === false) { ?>
                <div class="show-all-button">
                    <button class="btn-pink load-more-handl">показать все новости</button>
                </div>
            <? } ?>
        <? } else {?>
        <div style="margin: 110px 0; font-size: 24px; text-align: center">Нет новостей за указанный период</div>
        <? } ?>
    </div>
</div>