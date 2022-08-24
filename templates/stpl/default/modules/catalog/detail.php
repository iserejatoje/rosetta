<?php
$product = $vars['product'];
$category = $product->category;
$discountPercent = (int) $product->getDiscountPercent(App::$City->CatalogId);
?>
<div class="product-card theme-<?=CatalogMgr::$THEMES[$product->theme]['class']?>">
    <div class="product-card-slider">

        <div class="container">
            <form method="post" action="/catalog/" data-type="ajax-form" class="product-card-form">
                <input type="hidden" name="action" value="ajax_get_product_price">
                <input type="hidden" name="productid" value="<?=$product->id?>">

                <div class="card-slider-slides">
                    <? if(CatalogMgr::GetInstance()->hasDiscount($product->areaRefs) && $discountPercent > 0) { ?>
                        <div class="product-card-sale">
                            -<?= $discountPercent ?>%
                        </div>
                    <? } elseif($product->areaRefs['IsShare']) { ?>
                        <div class="card-item-discount">
                            АКЦИЯ
                        </div>
                    <? } elseif($product->areaRefs['IsHit']) { ?>
                        <div class="card-item-discount hit">
                            ХИТ
                        </div>
                    <? } elseif($product->areaRefs['IsNew']) { ?>
                        <div class="card-item-discount new">
                            НОВИНКА
                        </div>
                    <? } ?>

                    <div id="card-slider-dots" class="card-slider-dots"></div>
                    <div class="owl-carousel">
                        <? foreach($product->photos as $photo) { ?>
                            <div class="card-slider-item">
                                <img src="<?=$photo->Photo['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($photo->AltText)?>" title="<?=UString::ChangeQuotes($photo->Title)?>">
                            </div>
                        <? } ?>
                    </div>

                    <div class="card-slider-nav">
                        <div class="arrow-vertical arrow-vertical-left"><div class="circle"></div></div>
                        <div class="arrow-vertical arrow-vertical-right"><div class="circle"></div></div>
                    </div>
                </div>

                <div class="card-info">
                    <div class="card-info-name with-wave">
                        <div class="card-info-bubble" data-control="card-info">
                            <span class="bubble-letter">i</span>
                        </div>
                        <?=$product->name?>
                        <div class="card-info-article">
                            арт. <?=$product->article?>
                        </div>
                    </div>

                    <?=STPL::Fetch('modules/catalog/detail/_'.$vars['template'], $vars)?>

                    <? if($vars['category']->kind == CatalogMgr::CK_WEDDING) { ?>
                         <div class="card-info-buy clearfix">
                            <div class="card-info-price <?if($product->areaRefs['IsShare']) {?>card-info-price-share<?}?>"><?=$vars['price']?>
                                <span class="unit <?if($product->areaRefs['IsShare']) {?>unit-share<?}?>">р.</span>
                            </div>
                            <a class="btn-buy btn-order btn-make-order" data-control="make-bouquet-order" data-id="<?=$product->id?>" href="#">
                                <span class="icon-cart"></span>
                                <span class="btn-buy-text">заказать</span>
                            </a>
                        </div>
                    <? } else { ?>
                        <div class="card-info-buy clearfix">
                            <?php
                                $isAvailable = $product->areaRefs['IsVisible'] && $product->areaRefs['IsAvailable'];
                                if($isAvailable && $product->ParentId) {
                                    $parent = CatalogMgr::GetInstance()->GetProduct($product->ParentId);
                                    $areaRefs = $parent->GetAreaRefs(App::$City->CatalogId);
                                    if(!$areaRefs['IsAvailable'])
                                        $isAvailable = false;
                                }
                            ?>
                            <?php if($isAvailable): ?>

                                <div class="card-info-price <?if($product->areaRefs['IsShare']) {?>card-info-price-share<?}?>">
                                    <span id="product-price-val"><?=$vars['price']?></span>
                                    <span class="unit <?if($product->areaRefs['IsShare']) {?>unit-share<?}?>">р.</span>
                                </div>
                                <a class="btn-buy" data-action="ajax_add_to_cart" data-control="add-to-cart" href="#">
                                    <span class="icon-cart"></span>
                                    <span class="btn-buy-text">в корзину</span>
                                </a>
                            <?php else: ?>
                                <div class="card-info-price <?if($product->areaRefs['IsShare']) {?>card-info-price-share<?}?>">
                                    <span id="product-not-available">Нет в наличии</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <? } ?>
                </div>

            </form>
        </div>

        <div class="product-info-more">
            <div class="product-info-more-body">
                <div class="product-info-close" data-control="card-info"></div>

                <h2>О букете</h2>

               <?=$product->text?>
            </div>
        </div>
        <div class="product-card-substrate"></div>
    </div>

    <!-- new add -->
    <? if($category->kind != CatalogMgr::CK_WEDDING) { ?>
        <div class="product-card-additions is-hidden">
            <form method="post" action="/catalog/" data-form="ajax-filter">
                <input type="hidden" name="action" value="ajax_load_all_adds">
            </form>

            <div class="additional-alert">
                <div class="container">
                    <span class="additional-alert-label">Поздравляем! Ваш товар успешно добавлен в корзину.</span>
                    <div class="additional-alert-buttons">
                        <a href="/" class="btn-white">в каталог</a>
                        <a href="/catalog/order/cart/" class="btn-white">в корзину</a>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="additions-label">Вы можете добавить к заказу:</div>

                <div class="additions-grid clearfix" id="load-adds-list-block">
                    <?=STPL::Fetch('modules/catalog/detail/_additions', $vars)?>
                </div>

                 <? if(!empty($vars['add_pages']['next'])) { ?>
                    <div class="center-wrapper">
                        <button class="btn-load-more" data-trigger="restoreSelectedAdds">показать все</button>
                    </div>
                <? } ?>

                <div class="additional-buttons">
                    <a href="/" class="btn-white">в каталог</a>
                    <a href="/catalog/order/cart/" class="btn-white">в корзину</a>
                </div>
            </div>

            <div class="additions-popup-bg">
                <div class="addition-popup">
                    <div class="container">
                        <div class="popup-card">
                            <div class="popup-card-close"></div>
                            <div class="popup-card-body clearfix" id="addition-content">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <? } ?>
<? /*
    <div class="product-card-additions">
        <form method="post" action="/catalog/" data-form="ajax-filter">
            <input type="hidden" name="action" value="ajax_load_all_adds">
        </form>

        <? if($category->kind != CatalogMgr::CK_WEDDING) { ?>
            <div class="container">
                <div class="additions-label">Добавить к заказу:</div>

                <div class="additions-grid clearfix" id="load-adds-list-block">
                     <?=STPL::Fetch('modules/catalog/detail/_additions', $vars)?>
                </div>

                <? if(!empty($vars['add_pages']['next'])) { ?>
                    <div class="center-wrapper">
                        <button class="btn-load-more" data-trigger="restoreSelectedAdds">показать все</button>
                    </div>
                <? } ?>
            </div>
        <? } ?>
*/?>

<?/*
        <div class="additions-popup-bg">
            <div class="addition-popup">
                <div class="container">
                    <div class="popup-card">
                        <div class="popup-card-close"></div>
                        <div class="popup-card-body clearfix" id="addition-content">

                        </div>
                    </div>
                </div>
            </div>
        </div>
*/?>
        <!--  -->
        <? /*
        <div class="additions-popup-bg">
            <div class="addition-popup">
                <div class="container">
                    <div class="popup-card">
                        <div class="popup-card-close"></div>
                        <div class="popup-card-body clearfix" id="addition-content"></div>
                    </div>
                </div>
            </div>
        </div>
        */?>
        <!--  -->
    </div>
</div>