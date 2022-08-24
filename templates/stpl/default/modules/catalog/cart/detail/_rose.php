<?php
    $product = $vars['product'];
?>
<div class="card-info-count">
    <div class="card-info-count-label">Укажите количество цветов:</div>
    <div class="count-switcher">
        <input type="text" name="roses_count" value="<?=$product->count?>" readonly data-min="<?=$vars['min']?>" data-inc="<?=$vars['step']?>" data-max="101" autocomplete="off">
        <div class="count-switcher-btn count-switcher-down">
            <div class="count-switcher-btn-sign"></div>
        </div>
        <div class="count-switcher-btn count-switcher-up">
            <div class="count-switcher-btn-sign"></div>
        </div>
    </div>
</div>


<div class="card-info-length">
    <div class="card-info-length-label">Выберите длину:</div>
    <div class="card-info-lengths-list clearfix" data-control="radiolist">
        <input type="hidden" value="<?=$product->GetDefaultLen()?>" name="length" autocomplete="off">
        <? foreach($vars['lens'] as $len) { ?>
            <div class="card-info-length-col">
                <div class="card-info-length-item<?if($len->len == $vars['default_len']){?> is-active<?}?>" data-control="radiobutton" data-id="<?=$len->len?>">
                    <?=$len->len?> см
                </div>
            </div>
        <? } ?>
    </div>
</div>