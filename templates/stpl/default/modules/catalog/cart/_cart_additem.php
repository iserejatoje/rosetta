<?php

$addition = $vars['addition']['object'];
$count = $vars['addition']['count'];
$add_key = $vars['key'];

?>

<div class="cart-product-img">
    <img src="<?=$addition->PhotoCart['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($addition->name)?>">
</div>
<div class="cart-product-info">
    <div class="cart-product-info-cols clearfix">
        <div class="cart-product-props-col">
            <div class="cart-product-name">
                <?=$addition->name?>
                <div class="cart-info-article">
                    арт. <?= $addition->article?>
                </div>
            </div>
        </div>
        <div class="cart-product-count-col">
            <div class="count-switcher count-switcher-small">
                <input type="text" name="adds_count[<?=$add_key?>]" value="<?=$count?>" readonly="" autocomplete="off">
                <div class="count-switcher-btn count-switcher-down" data-trigger="setHiddenKey" data-action="ajax_adds_product_count">
                    <div class="count-switcher-btn-sign"></div>
                </div>
                <div class="count-switcher-btn count-switcher-up" data-trigger="setHiddenKey" data-action="ajax_adds_product_count">
                    <div class="count-switcher-btn-sign"></div>
                </div>
            </div>
        </div>
        <div class="cart-product-price-col">
            <div class="cart-product-price">
                <?=$addition->price * $count?> <span class="unit">р.</span>
                <span class="cart-product-remove" data-control="checkbox" data-ajax="true" data-trigger="setHiddenKey" data-action="ajax_adds_remove_cart_item">
                    <input type="hidden" name="add_product_delete[<?=$add_key?>]" value="0">
                </span>
            </div>
        </div>
    </div>
</div>