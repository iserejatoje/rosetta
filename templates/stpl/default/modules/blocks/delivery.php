<?
    $block = $vars['blocks'];
?>

<script type="text/javascript" language="javascript" src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru_RU" charset="utf-8"></script>
<div class="container">
    <h1 class="page-title">ДОСТАВКА</h1>

    <div class="page-delivery">
        <div class="delivery-grid">
            <div class="delivery-districts clearfix">
                <div class="delivery-districts-item delivery-districts-local">
                    <div class="delivery-districts-item-body">
                        <?=$block['DELIVERY_DISTRICTS_CITY']->text?>
                    </div>
                </div>
                <div class="delivery-districts-item delivery-districts-faraway">
                    <div class="delivery-districts-item-body">
                        <?=$block['DELIVERY_FAR_DISTRICTS_CITY']->text?>
                    </div>
                </div>
            </div>

            <div class="delivery-orders">
                <div class="block-body-wrapper clearfix">
                    <?=$block['DELIVERY_ROUND_THE_CLOCK_ORDER']->text?>
                </div>
            </div>

            <div class="delivery-pickup-header">
                <div class="block-body-wrapper clearfix">
                    <?=$block['DELIVERY_PICKUP']->text?>
                </div>
            </div>

            <div class="delivery-pickup-places">
                <div class="delivery-pickup-places-body">

                        <? foreach($vars['list'] as $store) { ?>
                        <div class="delivery-pickup-places-place" data-control="toggle-container">
                            <div class="delivery-pickup-places-place-button" data-control="toggle">
                                <div class="block-body-wrapper">
                                    <div class="delivery-pickup-places-place-button-label">
                                        <?=$store->Address?>
                                    </div>
                                    <div class="rounded-arrow">
                                        <div class="single-arrow"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="delivery-pickup-places-place-content">
                                <div class="delivery-pickup-places-place-desc">
                                    <div class="block-body-wrapper">
                                        <div class="delivery-pickup-places-place-desc-title">
                                            <?=$store->Address?>
                                        </div>
                                        <div class="delivery-pickup-places-place-desc-list clearfix">
                                            <div class="delivery-pickup-places-place-desc-list-item item-worktime">
                                                <?=$store->Workmode?>
                                                <?/*
                                                <table>
                                                    <tr>
                                                        <td>пн.-сб:</td>
                                                        <td><span class="highlight-white">с 8:00 до 21:00</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>вс:</td>
                                                        <td><span class="highlight-white">с 9:00 до 20:00</span></td>
                                                    </tr>
                                                </table>
                                                <div class="delivery-pickup-places-place-desc-list-item-additional">без обеда и выходных</div>
                                                */?>
                                            </div>

                                            <div class="delivery-pickup-places-place-desc-list-item item-phones">
                                                <?=$store->PhoneCode?> <?=$store->Phone?>
                                                <?/*
                                                <div class="delivery-pickup-places-place-desc-list-item-line">+7 912 <span class="highlight-white">802 10 12</span></div>
                                                <div class="delivery-pickup-places-place-desc-list-item-line">+7 912 <span class="highlight-white">802 10 12</span></div>
                                                */?>
                                            </div>
                                        </div>
                                        <div class="close-btn" data-control="toggle"></div>
                                    </div>
                                </div>

                                <div class="map-container" data-lon="<?=$store->Longitude?>" data-lat="<?=$store->Latitude?>" data-color="purple">

                                </div>
                            </div>
                        </div>
                    <? } ?>

                    <? /*
                    <div class="delivery-pickup-places-place" data-control="toggle-container">
                        <div class="delivery-pickup-places-place-button" data-control="toggle">
                            <div class="block-body-wrapper">
                                <div class="delivery-pickup-places-place-button-label">
                                    Бульвар Строителей, 28
                                </div>
                                <div class="rounded-arrow">
                                    <div class="single-arrow"></div>
                                </div>
                            </div>
                        </div>

                        <div class="delivery-pickup-places-place-content">
                            <div class="delivery-pickup-places-place-desc">
                                <div class="block-body-wrapper">
                                    <div class="delivery-pickup-places-place-desc-title">
                                        Проспект Ленина, 114
                                    </div>
                                    <div class="delivery-pickup-places-place-desc-list clearfix">
                                        <div class="delivery-pickup-places-place-desc-list-item item-worktime">
                                            <table>
                                                <tr>
                                                    <td>пн.-сб:</td>
                                                    <td><span class="highlight-white">с 8:00 до 21:00</span></td>
                                                </tr>
                                                <tr>
                                                    <td>вс:</td>
                                                    <td><span class="highlight-white">с 9:00 до 20:00</span></td>
                                                </tr>
                                            </table>
                                            <div class="delivery-pickup-places-place-desc-list-item-additional">без обеда и выходных</div>
                                        </div>

                                        <div class="delivery-pickup-places-place-desc-list-item item-phones">
                                            <div class="delivery-pickup-places-place-desc-list-item-line">+7 912 <span class="highlight-white">802 10 12</span></div>
                                            <div class="delivery-pickup-places-place-desc-list-item-line">+7 912 <span class="highlight-white">802 10 12</span></div>
                                        </div>
                                    </div>
                                    <div class="close-btn" data-control="toggle"></div>
                                </div>
                            </div>

                            <div class="map-container" data-lon="55.345355278754944" data-lat="86.14670199999988" data-color="purple">

                            </div>
                        </div>
                    </div>
                    */?>

                </div>
            </div>

            <div class="delivery-info">
                <div class="block-body-wrapper">
                    <div class="delivery-info-cols clearfix">
                        <div class="delivery-info-col delivery-info-confidentiality">
                            <?=$block['DELIVERY_CONFIDENTIALITY']->text?>
                        </div>

                        <div class="delivery-info-col delivery-info-attention">
                            <?=$block['DELIVERY_ATTENTION']->text?>
                        </div>
                    </div>

                    <div class="delivery-info-footnote">
                        <?=$block['DELIVERY_IMPORTANT_GOAL']->text?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>