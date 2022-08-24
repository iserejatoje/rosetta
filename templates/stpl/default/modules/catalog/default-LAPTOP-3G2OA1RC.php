<div class="catalog-filter">
    <div class="container">
        <form id = "filtersRoman" method="post" action="catalog" data-form="ajax-filter">
            <input type="hidden" name="action" value="ajax_filter" />

            <div class="catalog-filter-col" style="order: 5;margin-right: 7%;">
              <?php
              if(is_array($vars['filter']['type']['visible']) && count($vars['filter']['type']['visible'])) { ?>
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

                    <div class="filter-control-dropdown filter-control-dropdown-mobile">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>

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

                        <div class="filter-control-dropdown<? if(count($vars['filter']['type']['hidden']) + count($vars['filter']['type']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    <? } ?>

                <? } ?>
            </div>

            <? if(is_array($vars['filter']['flower']['visible']) && count($vars['filter']['flower']['visible'])) { ?>
                <div class="catalog-filter-section">
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

                    <div class="filter-control-dropdown filter-control-dropdown-mobile">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>

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

                        <div class="filter-control-dropdown<? if(count($vars['filter']['flower']['hidden']) + count($vars['filter']['flower']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    <? } ?>

                </div>
            <? } ?>

            <?php
            if(is_array($vars['filter']['whom']['visible']) && count($vars['filter']['whom']['visible'])) { ?>
                <div class="catalog-filter-col" style="order: 4; width: 30%;">
                    <div class="catalog-filter-title">Кому</div>
                    <? foreach($vars['filter']['whom']['visible'] as $param) { ?>
                        <div class="catalog-filter-item">
                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="who">
                                <span class="item-roll"></span>
                                <span class="item-square"></span>
                                <span class="item-close"></span>
                                <?=$param['Name']?>
                            </div>
                        </div>
                    <? } ?>

                    <div class="filter-control-dropdown filter-control-dropdown-mobile">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>

                    <? if(is_array($vars['filter']['whom']['hidden']) && count($vars['filter']['whom']['hidden'])) { ?>
                        <div class="hidden-filter-items">
                            <? foreach($vars['filter']['whom']['hidden'] as $param) { ?>
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

                        <div class="filter-control-dropdown<? if(count($vars['filter']['whom']['hidden']) + count($vars['filter']['whom']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    <? } ?>

                </div>
            <? } ?>


                    <div class="filter-control-dropdown filter-control-dropdown-mobile">
                        <div class="double-arrow">
                            <div class="double-arrow-part arrow-right"></div>
                            <div class="double-arrow-part arrow-left"></div>
                        </div>
                    </div>

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

                        <div class="filter-control-dropdown<? if(count($vars['filter']['cause']['hidden']) + count($vars['filter']['cause']['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                            <div class="double-arrow">
                                <div class="double-arrow-part arrow-right"></div>
                                <div class="double-arrow-part arrow-left"></div>
                            </div>
                        </div>
                    <? } ?>

                </div>
            <? // } ?>


            <div class="catalog-filter-section long">
                <div class="catalog-filter-title">Цена</div>
                <div class="price-slider-wrp">
                    <div id="price-slider" class="price-slider">
                        <input id="minprice" type="hidden" name="minprice" value="<?= $vars['range']['min'] ?>" data-value="<?= $vars['range']['min'] ?>">
                        <input id="maxprice" type="hidden" name="maxprice" value="<?= $vars['range']['max'] ?>" data-value="<?= $vars['range']['max'] ?>">
                        <div class="price-label-extremum extr-min"><span class="extr-label-price"></span> р.</div>
                        <div class="price-label-extremum extr-max"><span class="extr-label-price"></span> р.</div>
                    </div>
                </div>
                <script type="text/javascript">
                  function showFiltersRoman(evt) {
                    console.log("show filters");
                    evt.preventDefault();
                    document.querySelector("#filtersRoman").classList.toggle("active_filters");
                  }
                </script>
                <div data-input="reset" id="reset-filters">сбросить все настройки фильтра</div> <span class = "linkfilters">Показать все фильтры</span>
                <script type="text/javascript">
                  const linkFiltersRoman = document.querySelector(".linkfilters");
                  linkFiltersRoman.addEventListener("click",(evt) => showFiltersRoman(evt));
                </script>
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
            <h1>Доставка цветов в Кемерово от цветочного интернет-магазина «Розетта»</h1>
            <p>
            <strong>Доставка цветов в Кемерово</strong> от интернет магазина цветов «Розетта» — это приятная возможность <strong>купить цветы</strong> относительно недорого и в отличном исполнении,
            ведь уровень подготовки флористов в цветочных магазинах «Розетта» высокий, профессиональный. Любой <strong>букет цветов</strong> создается здесь с исключительной теплотой
            и неподражаемым творческим потенциалом, а все цветочные композиции, цветы, включая <strong>розы, купить</strong> можно в режиме онлайн, с помощью компьютера или даже
            смартфона. <strong>Доставка цветов в Кемерово</strong> от «Розетта» удобна простотой заказа, скоростью исполнения и, конечно, недорогими ценами на цветы. «Розетта» — это
            региональный <strong>интернет магазин цветов</strong> в Кемерово, имеющий в каталоге более 500 наименований композиций с доступными ценами, здесь можно дешево <strong>купить цветы</strong>
            с оформлением и отправить адресату в любую точку нашего города.
            </p>
            <p>
            Среди самых продаваемых цветов первую строчку занимают розы, также популярны тюльпаны, ирисы, орхидеи, альстромерии, хризантемы и большие <strong>букеты роз</strong>.
            Регулярное товарное пополнение цветочного магазина «Розетта» даёт возможность купить цветы и букеты в Кемерово исключительной свежести и красоты! Доставка
            цветов в определенное время, это всегда ответственность и обязательства, которые являются основой и принципом работы цветочных магазинов «Розетта». Каждая
            покупка или доставка цветов — это, прежде всего, приятные эмоции, который должен получить ваш адресат, именно поэтому в компании «Розетта» взяты за основу
            высокие стандарты сервиса.
            </p>
        </div>
        <div class="block-for-seo">
            <h2>Купить цветы в Кемерово с доставкой на дом недорого</h2>
            <p>
            Свежие <strong>цветы в Кемерово</strong> — это уже событие, а прекрасный букет цветов, доставленный вовремя, радует вдвойне. Стоит отметить, что купить цветы с доставкой на
            дом — это удобная форма заказа, позволяющая в короткие сроки поздравить своих близких или напомнить о своих чувствах возлюбленным. Покупая цветы в интернет
            магазине «Rosetta», дополните букет цветов открыткой или аксессуарам, которые станут приятным дополнением к подарку. Широкий ассортимент сопутствующих к
            заказу товаров приятно удивит любителей делать подарки, а доставка цветов станет более эффектной и незабываемой.
            </p>
            <p>
            Приятно дарить и получать подарки без повода, правда? Поэтому интернет магазин цветов «Rosetta» развивает культуру дарения "доставка цветов на дом недорого — основа
            хорошего настроения и залог успешного дня"! Купить цветы просто так, подарить их без повода, порадовать близких и создать позитивные моменты с помощью «Розетта»,
            это просто! Купить розы, тюльпаны, ирисы или даже лютики, всё равно, что встретить весну с благоуханием ароматов, создать ауру незабываемой романтики и оживить цветом
            суровый, но любимый нами Кемерово. Дарите цветы чаще!
            </p>
        </div>
    </div>
</div>
