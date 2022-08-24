<? foreach($vars['list'] as $item) { ?>
<?
	$timestamp = strtotime($item->Created);
?>
    <div class="review-item">
        <div class="review-item-post review-item-body">
            <div class="review-item-content">
                <div class="review-item-text">
                    <span class="start-quote">“</span> <?= $item->Text ?> <span class="end-quote">“</span><?/*<?=htmlspecialchars($item->Text)?>*/?>
                </div>
                <div class="review-item-sign"><?= $item->Username ?></div>
            </div>
        </div>

        <? if($item->AnswerText) { ?>
            <div class="review-item-answer review-item-body">
                <div class="review-item-content">
                    <div class="review-item-text">
                        <?=$item->AnswerText?>
                    </div>
                    <div class="review-item-sign">С уважением, букетная мастерская Розетта</div>
                </div>
            </div>
        <? } ?>
    </div>
<? } ?>
