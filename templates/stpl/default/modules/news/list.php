<? foreach($vars['news'] as $news) { ?>
    <div class="news-item" data-control="toggle-container">

        <div class="news-item-body clearfix">
            <div class="news-item-img">
                <? if (!empty($news->Photo['f'])) { ?><img src="<?=$news->Photo['f']?>" alt="<?=UString::ChangeQuotes($news->title)?>" class="img-responsive"><? } ?>
            </div>

            <div class="news-item-content">
                <h2 class="news-item-title"><?=$news->title?></h2>
                <div class="news-item-date"><?=date('d.m.Y', $news->published)?></div>
                <div class="news-item-text news-item-text-announce">
                    <?=$news->Announce?>
                </div>
                <div class="news-item-text news-item-text-full">
                    <?=$news->Text?>
                </div>

                <div class="rounded-arrow" data-control="toggle">
                    <div class="single-arrow"></div>
                </div>
            </div>
        </div>
    </div>
<? } ?>