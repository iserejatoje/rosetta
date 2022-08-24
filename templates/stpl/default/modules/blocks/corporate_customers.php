<?
    $block = $vars['blocks'];

    $vars['banner']?    $banner = $vars['banner']->file['f'] :
                        $banner = '/resources/img/design/rosetta/corporate-clients/header-bg.jpg';
?>
<div class="corporate-clients-page">


    <div class="fullsize-header" style="background-image: url('<?= $banner?>');">
        <?=$block['CLIENTS_HEADER_OFFER']->text ?>
    </div>


    <div class="container">
        <div class="corporate-clients-substrate">

            <div class="template-description">
                <div class="template-description-info">
                    <?=$block['CLIENTS_SERVICE']->text ?>
                </div>
            </div>

            <?/*<div class="feedback-form">
                <div class="feedback-form-body clearfix">
                    <div class="feedback-form-info">
                    </div>

                    <div class="feedback-form-controls">

                        <form method="post" action=".">
                            <input type="hidden" name="action" value="ajax_send_offer">
                            <div class="form-group-grid clearfix">
                                <div class="form-group field-customerOfferName ajax-required">
                                    <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferName" name="customerOfferName" placeholder="Ваше имя" data-vtype="notempty" data-message="Укажите ваше имя">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>

                            <div class="form-group-grid clearfix">
                                <div class="form-group group-half field-customerOfferPhone ajax-required">
                                    <input type="text" class="form-control form-control-rectangular control-widerect phone-mask" id="customerOfferPhone" name="customerOfferPhone" placeholder="+7-(___)-___-____" data-vtype="phone" data-message="Неверный формат номера телефона">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group group-half field-customerOfferEmail ajax-required">
                                    <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferEmail" name="customerOfferEmail" placeholder="Ваш  e-mail" data-vtype="email" data-message="Неверный e-mail пользователя">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>

                            <div class="form-group form-control field-customerOfferComment ajax-required">
                                <textarea class="form-control form-control-rectangular control-widerect" id="customerOfferComment" name="customerOfferComment" placeholder="Ваши пожелания" data-vtype="notempty" data-message="Не заполнен текст пожелания"></textarea>
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group">
                                <button data-control="feedback-send" class="btn-white-wide pull-right" type="button">отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            */?>

            <div class="clients-info clearfix">
                <div class="clients-info-col clients-info-why">
                    <div class="clients-info-col-body">
                        <?=$block['CLIENTS_BUSSINESMAN_FLOWERS']->text ?>
                    </div>
                </div>
                <div class="clients-info-col clients-info-business">
                    <div class="clients-info-col-body">
                        <?=$block['CLIENTS_FLOWERS_AND_BUSSINES']->text ?>
                    </div>
                </div>
            </div>

            <div class="slider-clients">

                <div class="block-body-wrapper">
                    <div class="slider-clients-title">
                        НАШИ КЛИЕНТЫ:
                    </div>

                    <div class="slider-clients-slides owl-carousel">

                        <?
                        $i = 0;
                        foreach($vars['list'] as $item) {
                            ++$i;
                            ?>
                            <div class="slider-item<?if($i == 1){?> is-show<?}?>">
                                <div class="slider-item-wrapper">
                                    <div class="slider-item-img-container">
                                        <img src="<?=$item->photosmall['f']?>" alt="<?=UString::ChangeQuotes($item->title)?>">
                                        <img src="<?=$item->photosmallhover['f']?>" class="slider-item-img slider-item-img-active" alt="<?=UString::ChangeQuotes($item->title)?>">
                                    </div>
                                    <div class="slider-item-label-row">
                                        <div class="slider-item-label">
                                            <?=$item->title?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <? } ?>

                    </div>
                </div>

            </div>

            <div class="slider-clients-reviews">

                
                <div id="arrow-review-next" class="arrow-vertical arrow-vertical-left">
                    <div class="circle"></div>
                </div>

                <div id="arrow-review-prev" class="arrow-vertical arrow-vertical-right arrow-vertical-bottom">
                    <div class="circle"></div>
                </div>

                <div class="block-body-wrapper">

                    <?
                    $i = 0;
                    foreach($vars['list'] as $item) {
                        ++$i;
                        ?>
                        <div class="slider-clients-review clearfix<?if($i == 1){?> is-active<?}?>">
                            <div class="slider-clients-review-img">
                                <div class="slider-clients-review-img-container">
                                    <img src="<?=$item->photobig['f']?>" alt="">
                                </div>
                            </div>
                            <div class="slider-clients-review-content">
                                <h2>
                                    <?=$item->title?>
                                </h2>

                                <?=$item->text?>

                                <div class="slider-clients-review-sign"><?=$item->sign?></div>
                            </div>
                        </div>
                    <? } ?>

                </div>
            </div>
        </div>

    </div>

</div>