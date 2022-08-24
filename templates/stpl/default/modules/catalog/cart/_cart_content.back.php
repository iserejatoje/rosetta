
<?php

$cart = $vars['cart'];
$cart_items = $vars['cart']['items'];

?>

<div class="order-checkout-grid">
    <?php
        $i = 0;
        foreach($cart_items as $key => $item) {
            ++$i;
            $category = $item['product']->category;
            ?>
            <div class="order-checkout-item">
                <div class="item-num"><?= $i?>.</div>
                <div class="item-col size-1 item-img">
                    <div class="item-img-boundbox">
                    <?php if($item['product']->PhotoCart) { ?>
                        <img src="<?=$item['product']->PhotoCart['f']?>" class="img-responsive" >
                    <?php } ?>
                    </div>
                </div>
                <div class="item-col size-5 item-desc">
                    <div class="item-name"><?=$item['product']->name?></div>
                    <?php if($category->kind == CatalogMgr::CK_BOUQUET) { ?>
                        <div class="item-property">размер <?=$cart_items[$key]['type']['name']?></div>
                    <?php } elseif($category->kind == CatalogMgr::CK_ROSE) { ?>
                        <div class="item-property"><?=$cart_items[$key]['params']['roses_count']?> шт., <?=$cart_items[$key]['params']['length']?> см.</div>
                    <?php } elseif($category->kind == CatalogMgr::CK_MONO) { ?>
                        <div class="item-property"><?=$cart_items[$key]['params']['flower_count']?> шт.</div>
                    <?php } ?>
                </div>
                <div class="item-col size-2 item-count">
                    <?= $cart_items[$key]['count']?> шт.
                </div>
                <div class="item-col size-2 item-cost">
                    <?= number_format($cart_items[$key]['item_price'], 0, "", " ")?> р.
                </div>
            </div>

            <?php foreach($cart_items[$key]['additions'] as $addid => $addition) {
                $add_key = $key."_".$addition->id;
                ++$i;
                ?>
                <div class="order-checkout-item">
                    <div class="item-num"><?=$i?>.</div>
                    <div class="item-col size-1 item-img">
                        <div class="item-img-boundbox">
                            <?php if($addition['object']->PhotoCart) { ?>
                                <img src="<?=$addition['object']->PhotoCart['f']?>" class="img-responsive">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item-col size-5 item-desc">
                        <div class="item-name"><?=$addition['object']->name?></div>
                    </div>
                    <div class="item-col size-2 item-count">
                        <?=$addition['count']?> шт.
                    </div>
                    <div class="item-col size-2 item-cost">
                        <?= number_format($addition['object']->price * $addition['count'], 0, "", " ")?> р.
                    </div>
                </div>
            <?php } ?>
    <?php } ?>

    <?php if($vars['default_district'] !== null) { ?>
        <div class="order-checkout-item">
            <div class="item-num"><?=++$i?>.</div>
            <div class="item-col size-1 item-img">

            </div>
            <div class="item-col size-5 item-desc">
                <div class="item-name">Доставка  (<?=$vars['default_district']->Name?>)</div>
            </div>
            <div class="item-col size-2 item-count">

            </div>
            <div class="item-col size-2 item-cost">
                <?=$vars['default_district']->Price?> р.
            </div>
        </div>
    <?php } ?>

    <?php if($vars['delivery_type'] == CatalogMgr::DT_PICKUP) { ?>
        <div class="order-checkout-item">
            <div class="item-num"><?=++$i?>.</div>
            <div class="item-col size-1 item-img">

            </div>
            <div class="item-col size-5 item-desc">
                <div class="item-name">Доставка  (самовывоз)</div>
            </div>
            <div class="item-col size-2 item-count">

            </div>
            <div class="item-col size-2 item-cost"></div>
        </div>
    <?php } ?>

    <?php if($vars['card']) { ?>
        <div class="order-checkout-item">
            <div class="item-num"><?=++$i?>.</div>
            <div class="item-col size-1 item-img">

            </div>
            <div class="item-col size-5 item-desc">
                <div class="item-name"><?=$vars['card']->Name?></div>
            </div>
            <div class="item-col size-2 item-count">

            </div>
            <div class="item-col size-2 item-cost">
                <?=$vars['card']->Price?> р.
            </div>
        </div>
    <?php } ?>

</div>

<?php
$total_price = $vars['cart']['sum']['total_price'];
if($vars['card']) {
    // echo $vars['card']->price."<br>";
    $total_price += $vars['card']->price;
}

if($vars['default_district']) {
    $total_price += $vars['default_district']->Price;
    // echo $vars['default_district']->Price."<br>";
}

    // echo $vars['cart']['sum']['total_price'];//," ",$vars['card']->price," ",$vars['default_district'];
?>

<div class="order-checkout-total clearfix">
    <div class="order-checkout-total-label">Итого:</div>
    <div class="order-checkout-total-sum"><span class="text-pink"><?=number_format($total_price, 0, "", " ")?></span> р.</div>
</div>

