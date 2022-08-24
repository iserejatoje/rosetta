<div class="main-slider">
    <div class="main-slider-slides owl-carousel">

    <!--
        <div class="slider-item slider-item-14feb slide-parallax">
            <div class="parallax-layers parallax-layer" data-zindex="150" data-velocity="0" data-rotate="5">
                <div class="parallax-layer parallax-layer-fullsize slider-item-14feb-heart-bottom" data-zindex="-500" data-velocity=".3" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/hearts-3.png)"></div>
                <div class="parallax-layer parallax-layer-fullsize slider-item-14feb-heart-middle" data-zindex="100" data-velocity=".8" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/hearts-2.png)"></div>
                <div class="parallax-layer parallax-layer-fullsize slider-item-14feb-heart-top" data-zindex="350" data-velocity="1.1" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/hearts-1.png)"></div>
                <div class="parallax-layer parallax-layer-fullsize slider-item-14feb-heart-big" data-zindex="250" data-velocity=".3" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/big-heart.png)"></div>
                <div class="parallax-layer parallax-layer-oversize slider-item-14feb-girl" data-zindex="150" data-velocity=".5" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/girl.png)"></div>
                <div class="parallax-layer parallax-layer-fullsize slider-item-14feb-container" data-zindex="150" data-velocity=".5">
                    <div class="parallax-layer-fullsize slider-item-14feb-heartbeat" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/heartbeat.png)"></div>
                    <div class="parallax-layer-fullsize slider-item-14feb-logo" style="background-image: url(/resources/img/design/rosetta/main-slider/14feb/logo.png)"></div>
                    <div class="slider-item-14feb-trigger-area">
                        <div class="slider-item-14feb-particles">
        
                        </div>
                    </div>
                </div>
            </div>
        </div>

        -->

        <!-- <div class="slider-item slider-item-mother-day">
            <div class="container">
                <div class="slider-item-mother-day-content">
                    <div class="slider-item-mother-day-video">
                        <div class="slider-item-mother-day-video-cover"></div>
                        <video id="mother-day-video" src="/resources/img/design/rosetta/main-slider/mother-day/mother-day_condensed.mp4" preload loop></video>
                    </div>
                    <div class="slider-item-mother-day-page">
                        <div class="slider-item-mother-day-decor slider-item-mother-day-rose" data-zindex="5"></div>
                        <div class="slider-item-mother-day-decor slider-item-mother-day-heart-right-top" data-zindex="10"></div>
                        <div class="slider-item-mother-day-decor slider-item-mother-day-heart-right-middle" data-zindex="15"></div>
                        <div class="slider-item-mother-day-decor slider-item-mother-day-heart-right-bottom" data-zindex="10"></div>
                        <div class="slider-item-mother-day-decor slider-item-mother-day-heart-left-bottom" data-zindex="15"></div>
                        <div class="slider-item-mother-day-title"><span class="slider-item-mother-day-letter">с</span> <span class="slider-item-mother-day-letter">д</span><span class="slider-item-mother-day-letter">н</span><span class="slider-item-mother-day-letter">Ё</span><span class="slider-item-mother-day-letter">м</span><br> <span class="slider-item-mother-day-letter">м</span><span class="slider-item-mother-day-letter">а</span><span class="slider-item-mother-day-letter">т</span><span class="slider-item-mother-day-letter">е</span><span class="slider-item-mother-day-letter">р</span><span class="slider-item-mother-day-letter">и</span><span class="slider-item-mother-day-letter">!</span></div>
                        <div class="slider-item-mother-day-text"><span class="slider-item-mother-day-letter">порадуй самую важную</span><br> <span class="slider-item-mother-day-letter">женщину в мире</span></div>
                    </div>
                </div>
            </div>
        </div> -->

        <? foreach($vars['banners'] as $banner) { ?>

            <? if($banner->Type == BannerMgr::T_TEXT) { ?>
                <div class="slider-item" data-delay="<?= $vars['slider']['banner'] ?>">
                    <?=$banner->BannerText?>
                </div>
            <? } elseif($banner->Type == BannerMgr::T_IMAGE) { ?>
                <? if($banner->Url != '') { ?>
                    <a href="<?=$banner->Url?>">
                        <div class="slider-item slider-item-photo" style="background-image: url(<?=$banner->File['f']?>);" data-delay="<?= $vars['slider']['banner'] ?>"></div>
                    </a>
                <? } else { ?>
                    <div class="slider-item slider-item-photo" style="background-image: url(<?=$banner->File['f']?>);" data-delay="<?= $vars['slider']['banner'] ?>"></div>
                <? } ?>
            <? } elseif($banner->Type == BannerMgr::T_IMAGE_WITH_BTN) { ?>
                <div class="slider-item slider-item-photo" style="background-image: url(<?=$banner->File['f']?>);" data-delay="<?= $vars['slider']['play'] ?>">
                    <div class="slider-item-arrow" data-iframe='<?= $banner->BannerText ?>'>
                        <span class="slider-item-arrow-triangle"></span>
                    </div>
                </div>
            <? } ?>
        <? } ?>

    </div>
</div>

<div id="slider-repository">
    <? foreach($vars['products'] as $product) { ?>
        <div class="slider-repository-item">
            <div class="slider-item slider-item_product" style="background-image: url(<?=$product->photoslider['f']?>);" data-delay="<?= $vars['slider']['product'] ?>">
                <div class="slider-item-poduct">
                    <div class="slider-item-product-content">
                        <div class="slider-item-product-title"><?=$product->name?></div>
                        <?php if($vars['prices'][$product->id]): ?>
                            <div class="slider-item-product-price"><?=$vars['prices'][$product->id]?> <span class="slider-item-product-price-unit">р.</span></div>
                        <?php endif; ?>
                        <a class="btn-white" href="/catalog/<?=$product->category->nameid?>/<?=$product->id?>/">
                            <span class="icon-cart"></span>
                            <span class="btn-buy-text">купить</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <? } ?>
</div>