<div class="row">

    <div class="row">
        <div class="col n4 md-n12">
            <div class="page-title">
                <div class="page-title-label">
                    доставка
                    <div class="stroke-line"></div>
                    <div class="stroke-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="delivery-grid row">
        <? foreach($vars['blocks'] as $block) { ?>
            <div class="col n4">
                <div class="delivery-block <?=$block->ClassID?>">
                    <div class="delivery-content offset-mid">
                        <div class="delivery-text">
                            <?=$block->Text?>
                        </div>
                        <? if($block->MoreText) { ?>
                            <div class="delivery-more-text">
                                <?=$block->MoreText?>
                            </div>
                            <br>
                            <div class="text-alert iconed">
                                ПОДРОБНЕЕ
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>

        <? } ?>

        <? /*

        <div class="col n4">
            <div class="delivery-block work-time">
                <div class="delivery-content offset-small">
                    <div class="diliver-title">
                        ВРЕМЫ РАБОТЫ
                    </div><br>
                    <div class="delivery-range offset-top text-bold">
                        <span class="delivery-range-prefix">с</span> 10:00
                    </div><br>
                    <div class="delivery-range">
                        <span class="delivery-range-prefix">до</span> 24:00
                    </div><br>
                    <div class="delivery-notice">
                        КАЖДЫЙ ДЕНЬ
                    </div>
                </div>
            </div>
        </div>

        <div class="col n4">
            <div class="delivery-block delivery-time">
                <div class="delivery-content offset-small">
                    <div class="diliver-title">
                        ВРЕМЯ ДОСТАВКИ
                    </div><br>
                    <div class="delivery-big">
                        60
                    </div><br>
                    <div class="delivery-normal">
                        МИНУТ
                    </div><br>
                    <div class="text-alert iconed">
                        ФОРСМАЖОР
                    </div>
                </div>
            </div>
        </div>

        <div class="col n4">
            <div class="delivery-block delivery-free">
                <div class="delivery-content offset-big">
                    <div class="delivery-text">
                        При заказе от 500 рублей доставка бесплатна в пределах г. Костромы.
                    </div>
                </div>
            </div>
        </div>

        <div class="col n4">
            <div class="delivery-block delivery-drink">
                <div class="delivery-content offset-mid">
                    <div class="delivery-text">
                        В стоимость суммы для бесплатной доставки не входят напитки.
                    </div>
                </div>
            </div>
        </div>

        <div class="col n4">
            <div class="delivery-block delivery-payment">
                <div class="delivery-content offset-mid">
                    <div class="delivery-text">
                        Оплату можно произвести наличными или банковской картой при получении товара.
                    </div>
                </div>
            </div>
        </div>

        <div class="col n4">
            <div class="delivery-block delivery-order">
                <div class="delivery-content offset-mid">
                    <div class="delivery-text">
                        Оформить заказ или получить подробную консультацию Вы всегда можете у наших операторов по телефону
                    </div>
                </div>
            </div>
        </div>
        */?>

    </div>

</div>