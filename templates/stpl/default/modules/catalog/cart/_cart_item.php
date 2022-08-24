<?
    $item       = $vars['item'];
    $cart_items = $vars['cart_items'];
    $key        = $vars['key'];
    $category   = $vars['category'];
?>

<div class="cart-product-img">
    <img src="<?=$item['product']->PhotoCart['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($item['product']->Name)?>">
</div>
<div class="cart-product-info">
    <div class="cart-product-info-cols clearfix">
        <div class="cart-product-props-col">
            <div class="cart-product-name">
                <?=$item['product']->name?>
                <div class="cart-info-article">
                    арт. <?= $item['product']->article?>
                </div>
            </div>
            <? if($category->kind == CatalogMgr::CK_BOUQUET) { ?>
                <div class="cart-product-size <?=CatalogMgr::$b_size[$cart_items[$key]['type']['name']]?>">размер <?=$cart_items[$key]['type']['name']?></div>
            <? } elseif($category->kind == CatalogMgr::CK_ROSE) { ?>
                <div><?=$cart_items[$key]['params']['roses_count']?> шт., <?=$cart_items[$key]['params']['length']?> см.</div>
            <? } elseif($category->kind == CatalogMgr::CK_MONO) {
                    $type = $item['product']->default_type;
                    $elements = $type->GetElements(App::$City->CatalogID, -1);

                    foreach($elements as $element) {
                        if($element['IsEditable']) {
                            $member = $element;
                            break;
                        }
                    }

                ?>
                <? if(!is_null($member)) { ?>
                    <div><?$member['Name']?> <?=$cart_items[$key]['params']['flower_count']?> шт.</div>
                <? } ?>
            <? } ?>
        </div>
        <div class="cart-product-count-col">
            <div class="count-switcher count-switcher-small">
                <input type="text" name="count[<?=$key?>]" value="<?=$cart_items[$key]['count']?>" readonly="" autocomplete="off">
                <div class="count-switcher-btn count-switcher-down" data-trigger="setHiddenKey" data-action="ajax_set_product_count">
                    <div class="count-switcher-btn-sign"></div>
                </div>
                <div class="count-switcher-btn count-switcher-up" data-trigger="setHiddenKey" data-action="ajax_set_product_count">
                    <div class="count-switcher-btn-sign"></div>
                </div>
            </div>
        </div>
        <div class="cart-product-price-col">
            <div class="cart-product-price">
                <?=$cart_items[$key]['item_price']?> <span class="unit">р.</span>
                <span class="cart-product-remove" data-control="checkbox" data-ajax="true" data-trigger="setHiddenKey" data-action="ajax_remove_cart_item">
                    <input type="hidden" name="product_delete[<?=$key?>]" value="0">
                </span>
            </div>
        </div>
    </div>
    <div class="letters" style="margin-left: 11%; padding-top: 60px; position: relative;
    z-index: 3;">
        <a href="#" class="show_postcards addder"><span class="postcard-counter">0</span> Открытки к букету</a>
    </div>

</div>

<div class="overlay overlay-postcard" style="display: none;">
    <div class="overlay-inner">
        <div class="postcards-wrapper">
            <?= STPL::Fetch('modules/catalog/cart/_postcard_item', ['cards' => $vars['cards'], 'key' => $key, 'productid' => $item['product']->productid]) ?>
        </div>

        <div class="actions-buttons">
            <a href="#" class="add_postcard_button add-postcard-btn" data-key="<?=$key;?>" data-trigger="setHiddenKey" data-action="ajax_set_product_count">Добавить еще открытку</a>
            <a href="#" class="add_postcard_button close-button-black" data-key="<?=$key;?>" data-trigger="setHiddenKey" data-action="ajax_set_product_count">Готово</a>
        </div>
        <div class="status-block" style="display: none;">
            <div class="inner">
                <span class="cart-product-remove" title="Удалить открытку" style="top: 20px; right: 20px !important; z-index: 10;"></span>
                Пожалуйста, выберите размер открытки
            </div>
        </div>
    </div>
</div>