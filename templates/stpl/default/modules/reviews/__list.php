<?
$i = 0;
foreach($vars['list'] as $item) { ?>
<?
    ++$i;
	$timestamp = strtotime($item->Created);
    if($i == 1) { ?> <div class="review-row"> <? } ?>
        <div class="review-item">
            <div class="review-item-body">
                <div class="review-item-content">
                    <div class="review-item-text">
                        <span class="start-quote">“</span><?=$i?> <?=$item->Text?> <span class="end-quote">“</span>
                    </div>
                    <div class="review-item-sign"><?=$item->Username?></div>
                </div>
            </div>
        </div>

    <? if($i == 2) {
        $i = 0;l
    ?>
        </div>
    <? } ?>

<? } ?>

<? if($i == 1) { ?>
        </div>
<? } ?>
