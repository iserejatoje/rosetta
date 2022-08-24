<?php

$cart = $vars['cart'];
$cart_items = $vars['cart']['items'];

$theme = '';
if(count($cart_items) > 0) {
    $first_item = (current($cart_items));
    $themeid = $first_item['product']->theme;
    $theme = " theme-" . CatalogMgr::$THEMES[$themeid]['class'];
}

?>

<div class="container">
    <h1 class="page-title">КОРЗИНА</h1>

    <div class="cart<?=$theme?>">

        <form method="post" action="/catalog/" data-type="ajax-form" class="cart-form">
            <input type="hidden" name="action" value="">
            <input type="hidden" name="key" value="">
            <input type="hidden" name="want_discount_card" value="0" id="want-discount-card">
            <div class="cart-products">

                <?php

                 foreach($cart_items as $key => $item) {
                     $bouquet_count = intval($item['count']);
                     $category = $item['product']->category;
                    ?>

                    <div class="cart-products-item" data-key="<?=$key?>">
                        <?= STPL::Fetch('modules/catalog/cart/_cart_item', ['cart_items' => $cart_items, 'productid' => $item['product']->productid, 'cards' => $vars['cards'], 'item' => $item, 'key' => $key, 'category' => $category]) ?>

                    </div>

                    <?php // cart product adds ?>
                    <?php foreach($cart_items[$key]['additions'] as $addid => $addition) {
                        $add_key = $key."_".$addition['object']->id;
                        ?>

                        <div class="cart-products-item item-add" data-key="<?=$add_key?>" data-parent="<?=$key?>">
                            <?= STPL::Fetch('modules/catalog/cart/_cart_additem', ['addition' => $addition, 'key' => $add_key]) ?>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

            <style>
                .status-block .inner {
                    z-index: 10;
                    padding: 46px;
                    background: #cb3e61;
                    max-width: 422px;
                    min-height: 172px;
                    width: 100%;
                    margin: auto;
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .status-block {
                    position: fixed;
                    left: 0;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 15px;
                    z-index: 10000000;
                    background: #0000007a;
                }
                .actions-buttons {
                    display: flex;
                    flex-wrap: wrap;
                }
                .addder:hover {
                    background: #b5314f;
                }
                .addder:active {
                    background: #8a1e37;
                }
                .addder {
                    background: #ab2c4a;
                    text-decoration: none;
                    padding: 10px 18px;
                    display: inline-flex;
                    transition: background 150ms linear;
                }
                .close-button-black {
                    color: #c03051;
                    background: #fff !important;
                    margin-left: 15px;
                }
                .postcards-wrapper .cart-cards:first-child .cart-product-remove {
                    display: none !important;
                }
                .postcards-wrapper .cart-cards:not(:last-child) {
                    margin-bottom: 25px;
                }
                .postcard-counter {
                    min-width: 21px;
                    height: 21px;
                    display: inline-flex;
                    border-radius: 12px;
                    background: #7e1d33;
                    color: #ffffff;
                    align-items: center;
                    font-size: 14px;
                    justify-content: center;
                    margin-right: 10px;
                    text-decoration: none;
                    padding: 6px;
                }
                .add_postcard_button {
                    background: #c03051;
                    height: 50px;
                    max-width: 224px;
                    width: 100%;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 17px;
                    margin-top: 20px;
                }
                body.overflowed {
                    overflow: hidden;
                }
                .overlay-postcard .overlay-inner .cart-cards {
                    overflow: hidden;
                }
                .overlay-postcard .cart-product-remove:after,
                .overlay-postcard .cart-product-remove:before {
                    background: #000 !important;
                }
                .overlay-postcard .cart-product-remove {
                    background: #fff !important;
                }
                .overlay-postcard .overlay-inner {
                    max-width: 1310px;
                    width: 100%;
                    position: relative;
                    margin: auto;
                }
                .overlay-postcard {
                    position: fixed;
                    left: 0;
                    right: 0;
                    padding: 20px 10px;
                    overflow: auto;
                    top: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, .7);
                    z-index: 20555500;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
            </style>

            <div class="alert alert-dark alert-theme-influence">
                <div class="alert-body">
                    <div class="alert-title">Уважаемые клиенты!</div>
                    <div class="alert-message">
                        Если доставка букета идентичного изображенному букету на сайте невозможна, то наши флористы обязательно свяжутся с Вами для согласования замены цветов в составе букета.  При отсутствии Вашего ответа, по каким-либо причинам, мы оставляем за собой право изменить некоторые компоненты букета во время сборки, сохраняя форму и цветовую гамму композиции. При этом настроение, которое передает букет, останется тем же.
                    </div>
                    <div class="alert-checkbox field-confirmation ajax-required">
                        <div class="checkbox-check" data-control="checkbox">
                            <input type="hidden" value="0" name="confirmation" class="form-control" id="confirmation" name="confirmation" data-vtype="important" data-message="Необходимо ознакомиться с информацией">
                            <div class="checkbox-check-button"></div>
                            с информацией ознакомлен
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                    <div class="alert-checkbox field-isAccept ajax-required">
                        <div class="checkbox-check is-active" data-control="checkbox">
                            <input type="hidden" value="1" name="isAccept" class="form-control" id="isAccept" data-vtype="important" data-message="Поле обязательно">
                            <div class="checkbox-check-button"></div>
                            cогласен на обработку моих <a href="/oferta/#privacy" target="_blank">персональных данных</a>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="delivery-options">
                <div class="delivery-options-title">Выберите предпочтительный способ доставки:</div>
                <div class="delivery-options-tabs clearfix" data-control="radiolist">
                    <input type="hidden" value="1" name="delivery_type">
                    <div class="delivery-options-tab is-active" data-content="courier-delivery" data-control="radiobutton" data-id="1" data-ajax="true" data-action="ajax_delivery_type">
                        <div class="delivery-options-tab-body">
                            Курьерская доставка
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    </div>
                    <div class="delivery-options-tab" data-content="local-pickup" data-control="radiobutton" data-id="2" data-ajax="true" data-action="ajax_delivery_type">
                        <div class="delivery-options-tab-body">
                            Самовывоз
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="delivery-options-tab-content tab-courier-delivery is-visible">
                    <div class="delivery-options-dark-wrapper">
                        <div class="form-group group-general">
                            <div class="form-group-label-with-arrow">
                                Введите дату доставки:
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>
                                <div class="alert alert-float<?if($vars['in_mode'] && $vars['time_out_range'] == false){?> is-hidden<?}?>" id="no-order-message-block">
                                    <?=STPL::Fetch('modules/catalog/cart/_noorder_message', ['text' => $vars['noorder_text']])?>
                                </div>
                            </div>
                            <div class="form-control-input field-delivery_date ajax-required">
                                <input class="form-control-general fixed-short datepicker" value="<?=$vars['today']?>" <?if($vars['time_out_range']){?>
                                    data-date-offset="1"<?}?> data-ajax="true" data-action="ajax_change_date_delivery" data-year="<?=date('Y', strtotime($vars['today']))?>" data-month="<?=(date('n', strtotime($vars['today'])) - 1)?>" data-date="<?=date('d', strtotime($vars['today']))?>" data-days="<?= $vars['daysPeriod'] ?>" id="delivery_date" name="delivery_date" readonly="readonly" autocomplete="off">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="form-group group-general">
                            <div class="form-group-label-with-arrow">
                               <h4 style = "color: red; max-width: 1px; position: absolute; margin-left: -8%;">*</h4><h4> Время доставки: </h4>
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>
                            </div>
                            <div class="checkbox-list field-correction_call ajax-required" data-control="radiolist">

                                <?php $corrCall = $vars['isCallbackShowed'] ? 0 : 2; ?>
                                <input type="hidden" value="<?= $corrCall ?>" name="correction_call" id="correction_call" data-vtype="notzero" data-message="Не выбрано время доставки">

                                <?php if($vars['isCallbackShowed']): ?>
                                    <div class="checkbox" data-control="radiobutton" data-trigger-onactivate="showAdditional" data-trigger-oninactivate="hideAdditional" data-id="1" data-ajax="false">
                                        <div class="checkbox-body">
                                            <div class="checkbox-icon"></div>
                                            <div class="checkbox-label">Позвонить получателю для уточнения времени</div>
                                        </div>
                                    </div>
                                    <div class="checkbox-subitem is-hidden">
                                        <div class="checkbox checkbox-round" data-control="checkbox" data-id="1">
                                            <input type="hidden" value="0" name="not_flower_notify">
                                            <div class="checkbox-body">
                                                <div class="checkbox-icon"></div>
                                                <div class="checkbox-label">не сообщать, что это цветы</div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php $corrCall = $vars['isCallbackShowed'] ? '' : ' is-active'; ?>
                                <div class="checkbox<?= $corrCall ?>" data-control="radiobutton" data-trigger-onactivate="showAdditional" data-trigger-oninactivate="hideAdditional" data-id="2" data-ajax="false">
                                    <div class="checkbox-body">
                                        <div class="checkbox-icon"></div>
                                        <div class="checkbox-label">Доставить без звонка в указанный промежуток времени</div>
                                    </div>
                                    <div class = "info-block-courier">
                                      <h4 style = "color: red;">* </h4><h4>Время ожидания курьером получателя заказа не более 10 мин.</h4>
                                    </div>
                                </div>

                                <?php $corrCall = !$vars['isCallbackShowed'] ? '' : ' is-hidden'; ?>
                                <div class="checkbox-subitem<?= $corrCall ?>">
                                    <div class="time-slider-delivery-wrapper" id="time-slider-delivery">
                                        <?=STPL::Fetch('modules/catalog/cart/_time_slider', [
                                            'from' => $vars['time_delivery']['from']['sec'],
                                            'to' => $vars['time_delivery']['to']['sec'],
                                            'payment_time' => $vars['payment_time'],
                                            'minStep' => $vars['minStep'],
                                        ])?>
                                    </div>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="order-info clearfix">
                        <div class="order-info-dest">

                            <div class="form-group form-group-underline form-group-underline-with-label">
                                <div class="underline-form-label">Куда</div>
                                <select class="form-control" data-type="underline" name="city_id">
                                    <option value="72" selected="selected"><?= App::$City->Name?></option>
                                </select>
                            </div>

                            <div class="form-group form-group-underline">
                                <select class="form-control" data-type="underline" name="district_id">
                                    <?/*<option value="0" data-trigger="submitForm" data-action="ajax_change_district_delivery">(выберите район)</option>*/?>
                                    <? foreach($vars['districts'] as $district) { ?>
                                        <option value="<?=$district->ID?>" data-trigger="submitForm" data-action="ajax_change_district_delivery" <?if($vars['default_district']->ID == $district->ID){?> selected="selected"<?}?>><?=$district->Name?></option>
                                    <? } ?>
                                </select>
                            </div>
                            <div class="form-group form-group-underline field-delivery_address ajax-required">
                                <input  type="text" class="form-control form-control-underline" placeholder="(адрес: улица, дом, квартира)" name="delivery_address" id="delivery_address" data-vtype="notempty" data-message="Не указан адрес получателя">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group form-group-underline form-group-underline-with-label field-recipient_name ajax-required">
                                <div class="underline-form-label">Кому</div>
                                <input  type="text" class="form-control form-control-underline" placeholder="(имя получателя)" name="recipient_name" id="recipient_name" data-vtype="notempty" data-message="Не указано имя получателя">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group form-group-underline field-recipient_phone ajax-required">
                                <input type="text" class="form-control form-control-underline phone-mask" placeholder="(номер телефона)" id="recipient_phone" name="recipient_phone" data-vtype="phone" data-message="Неверный формат номера телефона">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="order-info-src">
                            <div class="form-group form-group-underline form-group-underline-with-label label-long field-customer_name ajax-required">
                                <div class="underline-form-label">От кого</div>
                                <input  type="text" class="form-control form-control-underline" placeholder="(ваше имя)" name="customer_name" id="customer_name" data-vtype="notempty" data-message="Укажите ваше имя">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group form-group-underline field-customer_email ajax-required">
                                <input  type="text" class="form-control form-control-underline" placeholder="(ваш e-mail)" name="customer_email" id="customer_email" data-vtype="email" data-message="Неверный e-mail пользователя">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group form-group-underline field-customer_phone ajax-required">
                                <input  type="text" class="form-control form-control-underline phone-mask" placeholder="(ваш номер телефона)" name="customer_phone" id="customer_phone" data-vtype="phone" data-message="Неверный формат номера телефона">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="delivery-cost clearfix">
                                <div class="delivery-cost-label">Стоимость доставки:</div>
                                <div class="delivery-cost-envelop">
                                    <div class="delivery-cost-envelop-rects clearfix">
                                        <div class="delivery-cost-envelop-rect empty"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                        <div class="delivery-cost-envelop-rect"></div>
                                    </div>
                                    <div class="delivery-cost-sum"><span id="delivery-price"><?=$vars['default_district']->Price?></span><span class="unit">РУБ</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="delivery-options-tab-content tab-local-pickup">
                    <div class="delivery-options-dark-wrapper">
                        <div class="form-group group-general">
                            <div class="form-group-label-with-arrow">
                                Введите дату самовывоза:
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>

                                <div class="alert alert-float<?if($vars['time_out_range_pickup'] == false){?> is-hidden<?}?>" id="no-order-message-block-pickup">
                                    <?=STPL::Fetch('modules/catalog/cart/_noorder_message', ['text' => $vars['noorder_text_pickup']])?>
                                </div>
                            </div>
                            <div class="form-control-input field-pickup_date ajax-required">
                                <?php /*<input class="form-control-general fixed-short datepicker" value="<?=$vars['today']?>">*/?>
                                <input class="form-control-general fixed-short datepicker" value="<?=$vars['pickup_today']?>" <?if($vars['time_out_range_pickup']){?>
                                    data-date-offset="1"<?}?> data-ajax="true" data-action="ajax_change_date_pickup" data-year="<?=date('Y', strtotime($vars['pickup_today']))?>" data-month="<?=(date('n', strtotime($vars['pickup_today'])) - 1)?>" data-date="<?=date('j', strtotime($vars['pickup_today']))?>" data-days="<?= $vars['daysPeriod'] ?>" id="pickup_date" name="pickup_date" readonly="readonly" autocomplete="off">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="form-group group-general">
                            <div class="form-group-label-with-arrow">
                                Укажите время, в которое Вы приедете:
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>
                            </div>

                            <div class="time-slider-delivery-wrapper" id="time-slider-pickup">
                                <?=STPL::Fetch('modules/catalog/cart/_time_slider_pickup', [
                                    'from' => $vars['time_pickup']['from']['sec'],
                                    'to' => $vars['time_pickup']['to']['sec'],
                                    'payment_time' => $vars['payment_time'],
                                ])?>
                            </div>
                        </div>
                        <div class="form-group group-general field-pickup_store ajax-required">
                            <div class="form-group-label-with-arrow">
                                Выберите салон, из которого Вы заберете заказ:
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>
                            </div>
                            <div class="rect-forms-wrapper">
                                <select class="form-control" data-type="rectangular" name="pickup_store" id="pickup_store">
                                    <?php /*<option value="0" selected>(выберите район самовывоза)</option>*/?>
                                    <?php foreach($vars['stores'] as $store) { ?>
                                        <option value="<?=$store->ID?>"><?=$store->Address?></option>
                                    <?php } ?>
                                </select>
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="form-group group-general">
                            <div class="form-group-label-with-arrow">
                                Ваши контакты:
                                <div class="double-arrow">
                                    <div class="double-arrow-part arrow-right"></div>
                                    <div class="double-arrow-part arrow-left"></div>
                                </div>
                            </div>

                            <div class="rect-forms-wrapper">
                                <div class="form-group with-rect-input field-contact_name ajax-required">
                                    <input type="text" class="form-control form-control-rectangular" placeholder="Имя" name="contact_name" id="contact_name" data-vtype="notempty" data-message="Укажите ваше имя">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group with-rect-input field-contact_phone ajax-required">
                                    <input type="text" class="form-control form-control-rectangular phone-mask" placeholder="+7-(___)-___-____" name="contact_phone" id="contact_phone" data-vtype="phone" data-message="Неверный формат номера телефона">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group with-rect-input field-contact_email ajax-required">
                                    <input type="text" class="form-control form-control-rectangular" placeholder="E-mail" name="contact_email" id="contact_email" data-vtype="email" data-message="Неверный e-mail пользователя">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-checkout">
                <div class="section-label">Проверьте Ваш заказ:</div>
                <div id="order-checkout-grid">
                    <?= STPL::Fetch('modules/catalog/cart/_cart_content', $vars)?>
                </div>
            </div>

            <?php
                $total_price = $vars['cart']['sum']['total_price'];
                if($vars['card'])
                    $total_price += $card->price;

                if($vars['default_district'])
                    $total_price += $vars['default_district']->Price;
            ?>
            <div class="order-discount<?if($total_price < $vars['discount_price']){?> is-hidden<?}?>">
                <div class="triangle-top triangle-top-right"></div>
                <div class="order-discount-body clearfix">
                    <div class="order-discount-text">
                        <div class="order-discount-title">Получите дисконтную карту со скидкой 5%</div>
                        <div class="order-discount-info">
                            Сумма Вашего заказа выше 5000 руб. Вы можете получить карту с 5% скидкой. <br>
                            Этой картой вы сможете пользоваться только при совершении заказа через сайт.
                        </div>
                    </div>
                    <div class="order-discount-controls clearfix">
                        <div class="order-discount-btns-wrapper" data-control="radiolist">
                            <input type="hidden" value="0">
                            <div class="order-discount-btn-wrapper">
                                <button type="button" class="btn-white" data-control="radiobutton" data-trigger-onactivate="getCardChecked" data-ajax="false">Получить карту</button>
                            </div>
                            <div class="order-discount-btn-wrapper">
                                <button type="button" class="btn-white" data-control="radiobutton" data-trigger-onactivate="gotCardChecked" data-ajax="false">У меня есть карта</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="send-discount-card-message" class="order-discount-message is-hidden">
                <div class="order-discount-message-body">
                    <ul class="list-dotted">
                        <li>После выполнения заказа на указанный вами адрес электронной почты будет отправлено письмо-уведомление с информацией о Вашей дисконтной карте</li>
                        <li>После выполнения заказа на указанный вами номер мобильного телефона будет отправлено SMS уведомление с информацией о Вашей дисконтной карте.</li>
                        <li>Воспользоваться скидкой по дисконтной карте Вы сможете при всех последующих покупках в нашем интернет-магазине.</li>
                    </ul>

                    <div class="order-discount-message-conditions-wrapper">
                        <div class="link-control" data-control="discount-conditions">
                            Условия получения использования <br>
                            дисконтной карты
                        </div>
                    </div>
                </div>
            </div>

            <div id="discount-card-number" class="order-discount-card<?if($total_price >= $vars['discount_price']){?> is-hidden<?}?>">
                <div class="order-discount-card-body clearfix">
                    <div class="order-discount-card-info">
                        <div class="order-discount-card-info-label">Введите номер дисконтной карты</div>
                        <div class="small-text">
                            (cкидка не действует на стоимость доставки)
                        </div>

                        <?php $isCan = (int)$vars['trying']->can(); ?>
                        <?php $msg = $isCan? '' : $vars['trying']->getMessage(); ?>
                        <div class="form-group form-control field-discountcard ajax-required<?php if(!$isCan) { echo ' has-error'; } ?>">
                            <input type="hidden" data-blocking-status value="<?= $isCan ?>">
                            <input type="hidden" data-blocking-time value="<?= $vars['trying']->getRemainingTime() ?>">
                            <input class="form-control form-control-simple form-control-order-discount" value="" name="discountcard" id="discountcard">
                            <button type="button" class="btn-white" id="recount-discount" data-action="ajax_calc_discount" type="button">Пересчитать</button>
                            <p class="help-block help-block-error"><?= $msg ?></p>
                        </div>

                        <div class="order-discount-card-conditions-wrapper">
                            <div class="link-control" data-control="discount-conditions">
                                Условия получения и использования <br>
                                дисконтной карты
                            </div>
                        </div>

                    </div>
                    <div class="order-discount-card-total">
                        Итого с учетом скидки: <span id="discount-cart-price"><?=number_format($total_price, 0, "", " ")?></span> р.
                    </div>
                </div>
            </div>

            <div id="discount-conditions" class="order-discount-conditions is-hidden">
                <div class="close-btn"></div>
                <div class="triangle-top triangle-top-left"></div>
                <div class="order-discount-body">
                    <div class="order-discount-cond-title">
                        Условия дисконтной программы <br>
                        интернет-магазина «РОЗЕТТА»
                    </div>

                    <div class="order-discount-cond-subtitle">
                        I.   Получение дисконтной карты
                    </div>
                    <ul class="list-dotted list-dotted-muted list-dotted-separated list-dotted-small">
                        <li>При единовременной покупке в интернет-магазине «РОЗЕТТА» на сумму от 5000 рублей и выше, после получения оплаты и выполнения заказа, покупателю направляется НОМЕР ДИСКОНТНОЙ КАРТЫ.</li>
                        <li>Используя номер дисконтной карты, покупатель интернет-магазина «РОЗЕТТА» может получить скидку 5% на товары, приобретаемые покупателем в интернет-магазине.</li>
                        <li>Номер дисконтной карты направляется покупателю посредством электронной почты и/или смс уведомлением.</li>
                        <li>Номер дисконтной карты начинает действовать со следующей покупки в интернет-магазине «РОЗЕТТА».</li>
                        <li>Скидка предоставляется при заполнении номера дисконтной карты в специально определенное для этого поле страницы интернет-магазина «РОЗЕТТА».</li>
                    </ul>

                    <div class="order-discount-cond-subtitle">
                        II.  Использование дисконтной карты
                    </div>
                    <ul class="list-dotted list-dotted-muted list-dotted-separated list-dotted-small">
                        <li>Покупатели букетной мастерской «РОЗЕТТА» (г.Кемерово), имеющие дисконтные карты, имеют право использовать номера дисконтных карт при покупке товаров в интернет магазине «РОЗЕТТА».</li>
                        <li>Скидка предоставляется при заполнении номера дисконтной карты в специально определенное для этого поле страницы интернет-магазина «РОЗЕТТА».</li>
                    </ul>
                </div>

            </div>

            <div class="payment-button">
                <button type="button" id="send-card-form" data-action="ajax_make_order" type="button" class="btn-pink" data-ya-target="go_payment">перейти на сервис оплаты</button>
            </div>


    </div>

    </form>
</div>
