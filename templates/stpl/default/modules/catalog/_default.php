<div class="catalog-filter">
    <div class="container">
        <form method="post" action="catalog" data-form="ajax-filter">
            <input type="hidden" name="action" value="ajax_filter" />
            <div class="catalog-filter-col">
                <? if(is_array($vars['filter']['type']['visible']) && count($vars['filter']['type']['visible'])) { ?>
                    <div class="catalog-filter-title">Тип</div>
                    <div class="catalog-filter-item">
                        <div class="filter-item-control active" data-disable-ongroupcheck="true" data-default="true" data-input="checkbox" data-name="escape_params" data-value="" data-group="type">
                            <span class="item-roll"></span>
                            <span class="item-square"></span>
                            <span class="item-close"></span>
                            все
                        </div>
                    </div>
                    <? foreach($vars['filter']['type']['visible'] as $param) { ?>
                        <div class="catalog-filter-item">
                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                <span class="item-roll"></span>
                                <span class="item-square"></span>
                                <span class="item-close"></span>
                                <?=$param['Name']?>
                            </div>
                        </div>
                    <? } ?>

                    <? if(is_array($vars['filter']['type']['hidden']) && count($vars['filter']['type']['hidden'])) { ?>
                        <div class="hidden-filter-items">
                            <? foreach($vars['filter']['type']['hidden'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>

                    <div class="filter-control-dropdown<? if(count($vars['filter']['type']['hidden']) + count($vars['filter']['type']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>
                <? } ?>
            </div>

            <? if(is_array($vars['filter']['flower']['visible']) && count($vars['filter']['flower']['visible'])) { ?>
                <div class="catalog-filter-col">
                    <div class="catalog-filter-title">Цветы в букете</div>
                    <? foreach($vars['filter']['flower']['visible'] as $param) { ?>
                        <div class="catalog-filter-item">
                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                <span class="item-roll"></span>
                                <span class="item-square"></span>
                                <span class="item-close"></span>
                                <?=$param['Name']?>
                            </div>
                        </div>
                    <? } ?>

                    <? if(is_array($vars['filter']['flower']['hidden']) && count($vars['filter']['flower']['hidden'])) { ?>
                        <div class="hidden-filter-items">
                            <? foreach($vars['filter']['flower']['hidden'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>

                    <div class="filter-control-dropdown<? if(count($vars['filter']['flower']['hidden']) + count($vars['filter']['flower']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>
                </div>
            <? } ?>


                    <div class="filter-control-dropdown<? if(count($vars['filter']['whom']['hidden']) + count($vars['filter']['whom']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>
                </div>
            <? // } ?>

            <? if(is_array($vars['filter']['cause']['visible']) && count($vars['filter']['cause']['visible'])) { ?>
                <div class="catalog-filter-col">
                    <div class="catalog-filter-title">Повод</div>
                    <? foreach($vars['filter']['cause']['visible'] as $param) { ?>
                        <div class="catalog-filter-item">
                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="who">
                                <span class="item-roll"></span>
                                <span class="item-square"></span>
                                <span class="item-close"></span>
                                <?=$param['Name']?>
                            </div>
                        </div>
                    <? } ?>

                    <? if(is_array($vars['filter']['cause']['hidden']) && count($vars['filter']['cause']['hidden'])) { ?>
                        <div class="hidden-filter-items">
                            <? foreach($vars['filter']['cause']['hidden'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="who">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>
                        </div>
                    <? } ?>


                    <div class="filter-control-dropdown<? if(count($vars['filter']['cause']['hidden']) + count($vars['filter']['cause']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>
                </div>
            <? } ?>

            <div class="catalog-filter-col long">
                <div class="catalog-filter-title">Цена</div>
                <div class="price-slider-wrp">
                    <div id="price-slider" class="price-slider">
                        <input id="minprice" type="hidden" name="minprice" value="500">
                        <input id="maxprice" type="hidden" name="maxprice" value="25000">
                        <div class="price-label-extremum extr-min"><span class="extr-label-price"></span> р.</div>
                        <div class="price-label-extremum extr-max"><span class="extr-label-price"></span> р.</div>
                    </div>
                </div>
                <div data-input="reset" id="reset-filters">сбросить все настройки фильтра</div>
            </div>

        </form>

    </div>
    <div class="catalog-filter-shadow"></div>
</div>

<? if($vars['workmode']['inmode'] == false) { ?>
    <div class="catalog-message">
        <div class="container">
            <div class="alert">
                <div class="alert-body">
                    <div class="alert-icon">
                        <spam class="alert-icon-text">!</spam>
                    </div>
                    <div class="alert-title"><?=$vars['workmode']['notice']['title']?></div>
                    <div class="alert-message">
                        <?=$vars['workmode']['notice']['message']?>
                        <?/*
                        Мы обращаем Ваше внимание - 16 и 18 октября заказ невозможен по техническим причинам.<br>
                        Вы можете забрать букет самостоятельно в любом из пунктов самовывоза
                        */?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<? } ?>

<div class="products-grid">
    <div class="container">
        <div class="products-grid-container clearfix" id="product-list-block">
            <?//=STPL::Fetch('modules/catalog/products/_product_list', $vars)?>
        </div>


        <? if($vars['last_page'] === false) { ?>
            <div class="center-wrapper">
                <button class="btn-load-more">показать все</button>
            </div>
        <? } ?>


        <div class="block-for-seo">
            <h1>Доставка цветов в Кемерово — купить цветы, розы или букет можно в два клика. </h1>

            <p><strong>Доставка цветов</strong> в Кемерово стала одной из наиболее востребованных услуг за последнее время. Это заметно по тому обилию специализированных компаний, что представлены на рынке и доставляют <strong>цветы в Кемерово</strong> в любой район. <strong>Купить цветы</strong> или <strong>букет цветов</strong>, оформить букет роз, не заходя в цветочный магазин, стало так же просто, как и выбрать питьевую воду. Мастерская «Розетта» предлагает вашему вниманию нетривиальный подход к выбору цветов: <strong>букет роз</strong> в Кемерово можно выбрать на круглосуточном сайте, сформировать заказ, не отходя от любимого компьютера или стула. <strong>Доставка цветов</strong> и букетов производится в течение рабочего дня. Возможно также воспользоваться услугой самовывоза. </p>
            <p><strong>Цветы в Кемерово</strong> – приятный подарок среди суровых будней, и, скорей всего, у вас уже есть представления о том, как должна производиться доставка цветов из цветочного магазина — быстро! Мастерская «Розетта» гарантирует: доставка букетов будет выполнена в назначенный час. Мы не заставим вас ждать, <strong>букет роз</strong> будет привезен к вам свежим, наполненным естественным ароматом. </p>
            <p><strong>Купить цветы</strong> на сайте можно в любое удобное вам время. Дизайнеры-флористы готовы также выполнить индивидуальный заказ: вы можете оформить оригинальный, неповторимый, отражающий ваши личные предпочтения букет роз (Кемерово – услуга предоставляется в любом районе города).
            Интернет-магазин цветов «Розетта» приглашает вас ознакомиться с самыми горячими предложениями. Обратите внимание на отметку «Хит», она означает, что купить цветы этого сорта пожелали десятки посетителей сайта! Значит, этот <strong>букет цветов</strong> (букет роз, тюльпанов, или, например, редких хризантем) способен стать хорошим подарком и выполнить свою задачу – сделать приятное важному для вас человеку.
            </p>

            <h2>Купить цветы, розы или букет онлайн — доставка цветов в Кемерово от «Розетта».</h2>

            <p>Наш интернет-магазин цветов (Кемерово, все районы города) сотрудничает с прямыми поставщиками экзотических, свежих, а также широко известных цветов. Не каждый <strong>цветочный магазин</strong> может похвастаться удобным и актуальным каталогом, в котором вы сможете без труда найти необходимый букет цветов. В мастерской «Розетта» вы сможете <strong>купить розы</strong> или другие цветы, и оплатить их несколькими удобными способами. Интернет-магазин цветов «Розетта» принимает к оплате также банковские карты. Мы сделали так, чтобы процессы заказа и доставка букетов оставили у вас только положительные впечатления. <strong>Купить розы</strong> или другие цветы в мастерской «Розетта» — это обрадовать близких и получить истинное удовольствие от эмоций!</p>

            <p>Мы предоставляем гарантию на все виды букетов. Если вы хотите получить уверенность в свежести и качестве продукции, вам нужно просто выбрать и купить розы. В Кемерово мы единственный магазин, который готов гарантировать соответствие букетов вашим ожиданиям.</p>

            <p>Мастерская «Розетта» - воплощенная эстетика и искусство флористики от талантливых дизайнеров. Мы предоставляем вашему вниманию изысканные и уникальные цветы. Кемерово – город, где проживает огромное количество ценителей прекрасного. Именно поэтому доставка букетов (Кемерово, все районы) от нашей мастерской пользуется популярностью среди жителей города. Это не просто красивые композиции из различных растений, это настоящее чудо в красивой упаковке, которое поднимает настроение и привносит с собой атмосферу праздника.</p>
        </div>


    </div>
</div>
