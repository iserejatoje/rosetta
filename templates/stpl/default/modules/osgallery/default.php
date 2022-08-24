<div class="template-page theme-<?=OSGalleryMgr::$THEMES[$vars['page']->theme]['class']?>">

    <? STPL::Fetch('modules/osgallery/_'.$vars['template'])?>

    <div class="fullsize-header" style="background-image: url(<?=$vars['page']->thumb['f']?>);">
        <div class="container">
            <div class="fullsize-header-desc">
                <h1><?=$vars['page']->title?></h1>
            </div>
            <div class="fullsize-header-info">
                <?=$vars['page']->text?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="feedback-form">
            <div class="feedback-form-body clearfix">
                <div class="feedback-form-info">
                    <?=$vars['page']->addtext?>
                </div>

                <div class="feedback-form-controls">
                    <div class="feedback-form-controls-label"><?=$vars['page']->formtitle?></div>

                    <form method="post" action=".">
                        <input type="hidden" name="action" value="ajax_send_request">
                        <input type="hidden" name="section" value="<?=$vars['page']->title?>" autocomplete="off">

                        <? if($vars['page']->withdate) { ?>
                            <div class="form-group-grid clearfix">
                                <div class="form-group group-part-left group-2-3">
                                    <input type="text" class="form-control form-control-rectangular control-widerect" name="customerOfferName" placeholder="Ваше имя" autocomplete="off" data-vtype="notempty" data-message="Укажите ваше имя">
                                </div>
                                <div class="form-group group-part-left group-1-3">
                                    <input type="text" class="form-control form-control-rectangular control-widerect datepicker" name="customerOfferDate" placeholder="Дата" readonly="readonly" autocomplete="off">
                                </div>
                            </div>
                        <? } else {?>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-rectangular control-widerect" name="customerOfferName" placeholder="Ваше имя" autocomplete="off">
                            </div>
                        <? } ?>

                        <div class="form-group-grid clearfix">
                            <div class="form-group group-half">
                                <input type="text" class="form-control form-control-rectangular control-widerect phone-mask" name="customerOfferPhone" placeholder="+7-(___)-___-____" autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона">
                            </div>
                            <div class="form-group group-half">
                                <input type="text" class="form-control form-control-rectangular control-widerect" name="customerOfferMail" placeholder="Ваш  e-mail" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control form-control-rectangular control-widerect" name="customerOfferComment" placeholder="Ваши пожелания" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn-white-wide pull-right" data-control="feedback-send">отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <? if($vars['uri'] === 'wedding_decor') { ?>
        <div class="catalog-filter">
            <div class="container">
                <form method="post" data-form="ajax-filter">
                    <input type="hidden" name="action" value="ajax_filter">
                    <div class="catalog-filter-col">
                        <? if(is_array($vars['filter']['style']['visible']) && count($vars['filter']['style']['visible'])) { ?>
                            <div class="catalog-filter-title">Стиль</div>
                            <div class="catalog-filter-item">
                                <div class="filter-item-control active" data-disable-ongroupcheck="true" data-default="true" data-input="checkbox" data-name="all" data-value="" data-group="style">
                                    <span class="item-roll"></span>
                                    <span class="item-square"></span>
                                    <span class="item-close"></span>
                                    все
                                </div>
                            </div>
                            <? foreach($vars['filter']['style']['visible'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="style">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>

                            <? if(is_array($vars['filter']['style']['hidden']) && count($vars['filter']['style']['hidden'])) { ?>
                                <div class="hidden-filter-items">
                                    <? foreach($vars['filter']['style']['hidden'] as $param) { ?>
                                        <div class="catalog-filter-item">
                                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="style">
                                                <span class="item-roll"></span>
                                                <span class="item-square"></span>
                                                <span class="item-close"></span>
                                                <?=$param['Name']?>
                                            </div>
                                        </div>
                                    <? } ?>

                                </div>

                                <div class="filter-control-dropdown">
                                    <div class="double-arrow">
                                        <div class="double-arrow-part arrow-right"></div>
                                        <div class="double-arrow-part arrow-left"></div>
                                    </div>
                                </div>
                            <? } ?>

                        <? } ?>
                    </div>

                    <div class="catalog-filter-col">
                        <? if(is_array($vars['filter']['season']['visible']) && count($vars['filter']['season']['visible'])) { ?>
                            <div class="catalog-filter-title">Сезон</div>
                             <? foreach($vars['filter']['season']['visible'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>

                            <? if(is_array($vars['filter']['season']['hidden']) && count($vars['filter']['season']['hidden'])) { ?>
                                <div class="hidden-filter-items">
                                    <? foreach($vars['filter']['season']['hidden'] as $param) { ?>
                                        <div class="catalog-filter-item">
                                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                                <span class="item-roll"></span>
                                                <span class="item-square"></span>
                                                <span class="item-close"></span>
                                                <?=$param['Name']?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>

                                <div class="filter-control-dropdown">
                                    <div class="double-arrow">
                                        <div class="double-arrow-part arrow-right"></div>
                                        <div class="double-arrow-part arrow-left"></div>
                                    </div>
                                </div>
                            <? } ?>

                        <? } ?>
                    </div>

                    <div class="catalog-filter-col">
                        <? if(is_array($vars['filter']['color']['visible']) && count($vars['filter']['color']['visible'])) { ?>
                            <div class="catalog-filter-title">Цветовая гамма</div>
                           <? foreach($vars['filter']['color']['visible'] as $param) { ?>
                                <div class="catalog-filter-item">
                                    <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                        <span class="item-roll"></span>
                                        <span class="item-square"></span>
                                        <span class="item-close"></span>
                                        <?=$param['Name']?>
                                    </div>
                                </div>
                            <? } ?>

                            <? if(is_array($vars['filter']['color']['hidden']) && count($vars['filter']['color']['hidden'])) { ?>
                                <div class="hidden-filter-items">
                                    <? foreach($vars['filter']['color']['hidden'] as $param) { ?>
                                        <div class="catalog-filter-item">
                                            <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="type">
                                                <span class="item-roll"></span>
                                                <span class="item-square"></span>
                                                <span class="item-close"></span>
                                                <?=$param['Name']?>
                                            </div>
                                        </div>
                                    <? } ?>
                                </div>

                                <div class="filter-control-dropdown">
                                    <div class="double-arrow">
                                        <div class="double-arrow-part arrow-right"></div>
                                        <div class="double-arrow-part arrow-left"></div>
                                    </div>
                                </div>
                            <? } ?>

                        <? } ?>
                    </div>

                    <div class="catalog-filter-col long-n2">
                        <div data-input="reset" id="reset-filters">сбросить все настройки фильтра</div>
                    </div>

                </form>

            </div>
            <div class="catalog-filter-shadow"></div>
        </div>
    <? } ?>

    <div class="shadow-sep"></div>

    <div class="container">
        <div class="photo-blocks-grid clearfix" id="templated-pages-list">
            <?=STPL::Fetch('modules/osgallery/list', $vars)?>
        </div>
    </div>

    <? if($vars['last_page'] === false) { ?>
        <div class="show-all-button">
            <button class="btn-pink">показать все</button>
        </div>
    <? } ?>

</div>