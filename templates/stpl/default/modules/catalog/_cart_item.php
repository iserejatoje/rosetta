<?
    $product = $vars['product'];
    $item    = $vars['item'];
    $priceid = intval($vars['priceid']);
    $price   = intval($vars['price']);
    $count   = $vars['count'];
    if($product->PhotoSmall)
        $img = $product->PhotoSmall['f'];
    elseif($product->PhotoBig)
        $img = $product->PhotoBig['f'];
    else
        $img = "";

?>
<div class="cart-item" id="product-item-<?=$product->ID?>-<?=$priceid?>" data-id="<?=$product->ID?>" data-priceid="<?=$priceid?>">
    <div class="item-remove"></div>
    <div class="item-name">
        <div class="item-img">
            <? if($img) { ?>
                <img src="<?=$img?>" class="img-responsive" style="width: 29px; height: 29px;">
            <? } ?>
        </div>
        <?=$product->Name?>
    </div>
    <div class="item-controls clearfix">
        <div class="price"><?=number_format($price, 0 , "", "")?> Р</div>
        <div class="count">
            <div class="count-dec">-</div>
            <div class="count-inc">+</div>
            <span class="current-count"><?=$count?></span>
        </div>
    </div>
</div>