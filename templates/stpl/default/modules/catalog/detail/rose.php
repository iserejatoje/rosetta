<?
    $product = $vars['product'];
    $lens = $vars['lens'];
?>

<div class="product-card theme-purple">
    <div class="product-card-slider">

        <div class="container">
            <form method="post" action="/catalog/" data-type="ajax-form" class="product-card-form">

                <div class="card-slider-slides">
                     <? if($product->isnew) { ?>
                        <div class="card-info-special">
                            n e w
                        </div>
                    <? } ?>

                     <? if($product->ishit) { ?>
                        <div class="card-info-special">
                            х и т
                        </div>
                    <? } ?>
                    <div id="card-slider-dots" class="card-slider-dots"></div>
                    <div class="owl-carousel">

                        <? foreach($product->photos as $photo) { ?>
                            <div class="card-slider-item">
                                <img decoding="async" src="<?=$photo->Photo['f']?>" class="img-responsive" alt="<?=UString::ChangeQuotes($photo->AltText)?>" title="<?=UString::ChangeQuotes($photo->Title)?>">
                            </div>
                        <? } ?>

                    </div>
                </div>

                <div class="card-info">
                    <div class="card-info-name">
                        <div class="card-info-bubble" data-control="card-info">
                            <span class="bubble-letter">i</span>
                        </div>
                        <?=$product->name?>
                    </div>

                    <div class="card-info-count">
                        <div class="card-info-count-label">Укажите количество цветов:</div>
                        <div class="count-switcher">
                            <input type="text" name="count" value="<?=$product->count?>" readonly data-min="5" data-inc="2" data-max="101" autocomplete="off">
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
                            <? foreach($vars['lens'] as $len) { ?>
                                <div class="card-info-length-col">
                                    <div class="card-info-length-item<?if($len->isdefault){?> is-active<?}?>" data-control="radiobutton" data-id="<?=$len->len?>">
                                        <?=$len->len?> см
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>

                    <div class="card-info-buy clearfix">
                        <div class="card-info-price"><?=$vars['price']?> <span class="unit">р.</span></div>
                        <a href="#" class="btn-buy">
                            <span class="icon-cart"></span>
                            <span class="btn-buy-text">в корзину</span>
                        </a>
                    </div>
                </div>

            </form>
        </div>

        <div class="product-info-more">
            <div class="product-info-more-body">
                <div class="product-info-close" data-control="card-info"></div>

                <h2>О букете</h2>

                <?=$product->Text?>
            </div>
        </div>
        <div class="product-card-substrate"></div>
    </div>

    <div class="product-card-additions">
        <form method="post" action="/catalog/" data-form="ajax-filter">
            <input type="hidden" name="action" value="ajax_test_load_all">
        </form>

        <div class="container">
            <div class="additions-label">Не забудьте купить:</div>

            <div class="additions-grid clearfix">
                <?=STPL::Fetch('modules/catalog/detail/_additions', $vars)?>
            </div>

            <div class="center-wrapper">
                <button class="btn-load-more">показать все</button>
            </div>
        </div>

        <div class="additions-popup-bg">
            <div class="addition-popup">
                <div class="container">
                    <div class="popup-card">
                        <div class="popup-card-close"></div>
                        <div class="popup-card-body clearfix">
                            <div class="popup-card-img">
                                <img src="/resources/img/design/rosetta/card/adds/add-popup-1.jpg" class="img-responsive" alt="rosetta">
                            </div>

                            <div class="popup-card-info">
                                <div class="popup-card-info-title">
                                    Очень красивая <br>
                                    ваза
                                </div>
                                <div class="popup-card-info-text">
                                    какое-то описание товара и его особенностей,
                                    какое-то описание товара, какое-то описание
                                    товара и его особенностей, какое-то
                                    описание товара, какое-то описание товара
                                    и его особенностей, какое-то описание товара
                                </div>
                                <div class="popup-card-info-buy clearfix">
                                    <div class="popup-card-info-price">7480 <span class="unit">р.</span></div>
                                    <button class="btn-single-cart"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>