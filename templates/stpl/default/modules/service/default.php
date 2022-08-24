<div class="template-page theme-<?=ServiceMgr::$THEMES[$vars['service']->theme]['class']?>">

    <div class="fullsize-header" style="background-image: url(<?=$vars['service']->thumb['f']?>);">
        <div class="container">
            <div class="fullsize-header-desc">
                <h1><?=$vars['service']->title?></h1>
            </div>
            <div class="fullsize-header-info feedback-form">
                <div class="feedback-form-controls">
                    <form method="post" action=".">
                        <input type="hidden" name="action" value="ajax_send_request">
                        <input type="hidden" name="section" value="<?=$vars['service']->title?>" autocomplete="off">

                        <? if($vars['service']->withdate) { ?>
                            <div class="form-group-grid clearfix">
                                <div class="form-group group-part-left group-2-3 field-customerOfferName ajax-required">
                                    <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferName" name="customerOfferName" placeholder="Ваше имя" autocomplete="off" data-vtype="notempty" data-message="Укажите ваше имя">
                                    <p class="help-block help-block-error"></p>
                                </div>
                                <div class="form-group group-part-right group-1-3 field-customerOfferDate"><?php /*ajax-required*/ ?>
                                    <input type="text" class="form-control form-control-rectangular control-widerect datepicker" id="customerOfferDate" name="customerOfferDate" placeholder="Дата" readonly="readonly" autocomplete="off">
                                    <p class="help-block help-block-error"></p>
                                </div>
                            </div>
                        <? } else {?>
                            <div class="form-group field-customerOfferName ajax-required">
                                <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferName" name="customerOfferName" placeholder="Ваше имя" autocomplete="off" data-vtype="notempty" data-message="Укажите ваше имя">
                                <p class="help-block help-block-error"></p>
                            </div>
                        <? } ?>

                        <?php /*
                        <div class="form-group-grid clearfix">
                            <div class="form-group group-half field-customerOfferPhone ajax-required">
                                <input type="text" class="form-control form-control-rectangular control-widerect phone-mask" id="customerOfferPhone" name="customerOfferPhone" placeholder="+7-(___)-___-____" autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group group-half field-customerOfferMail ajax-required">
                                <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferMail" name="customerOfferMail" placeholder="Ваш  e-mail" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        */ ?>
                        <div class="form-group-grid clearfix">
                            <div class="form-group field-customerOfferContact ajax-required">
                                <input type="text" class="form-control form-control-rectangular control-widerect" id="customerOfferContact" name="customerOfferContact" placeholder="Почта либо телефон" autocomplete="off" data-vtype="notempty" data-message="Необходимо заполнить поле">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>

                        <div class="form-group field-customerOfferComment ajax-required">
                            <textarea class="form-control form-control-rectangular control-widerect" id="customerOfferComment" name="customerOfferComment" placeholder="Ваши пожелания" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст"></textarea>
                            <p class="help-block help-block-error"></p>
                        </div>

                        <div class="form-group field-isAccept ajax-required">
                            <div class="checkbox-privacy">
                                <div class="checkbox is-active" data-control="checkbox" data-trigger="disableSubmitBtn">
                                    <input type="hidden" id="isAccept" name="isAccept" value="1" data-vtype="notzero" data-message="Поле обязательно">
                                    <div class="checkbox-body">
                                        <div class="checkbox-icon"></div>
                                        <div class="checkbox-label">Согласен на обработку моих <a href="/oferta/#privacy" target="_blank">персональных данных</a></div>
                                        <p class="help-block help-block-error"></p>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-white-wide pull-right" data-control="feedback-send">отправить</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="template-description">
            <div class="template-description-info">
                <?=$vars['service']->addtext?>
            </div>
        </div>
    </div>

    <? if($vars['service']->hasfilter) { ?>

        <div class="catalog-filter">
            <div class="container">
                <form method="post" data-form="ajax-filter">
                    <input type="hidden" name="action" value="ajax_filter">
                    <input type="hidden" name="ServiceID" value="<?= $vars['service']->ServiceID ?>">


                    <? foreach ($vars['filter'] as $filter_key => $filter) { ?>

                        <div class="catalog-filter-col">
                        <? if(is_array($filter['visible']) && count($filter['visible'])) { ?>
                                <div class="catalog-filter-title"><?= $filter['name'] ?></div>


                                <? foreach($filter['visible'] as $param) { ?>
                                    <div class="catalog-filter-item">
                                        <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="<?= $filter_key ?>">
                                            <span class="item-roll"></span>
                                            <span class="item-square"></span>
                                            <span class="item-close"></span>
                                            <?=$param['Name']?>
                                        </div>
                                    </div>
                                <? } ?>

                                <? if(!empty($filter['hidden'])) { ?>
                                    <div class="hidden-filter-items">
                                        <? foreach($filter['hidden'] as $param) { ?>
                                            <div class="catalog-filter-item">
                                                <div class="filter-item-control" data-input="checkbox" data-name="params[<?=$param['FilterID']?>][<?=$param['ParamID']?>]" data-value="<?=$param['ParamID']?>" data-group="<?= $filter_key ?>">
                                                    <span class="item-roll"></span>
                                                    <span class="item-square"></span>
                                                    <span class="item-close"></span>
                                                    <?=$param['Name']?>
                                                </div>
                                            </div>
                                        <? } ?>
                                    </div>
                                <? } ?>

                                <div class="filter-control-dropdown<? if(count($filter['hidden']) + count($filter['visible']) < 3) { ?> filter-control-dropdown-mobile<? } ?>">
                                    <div class="double-arrow">
                                        <div class="double-arrow-part arrow-right"></div>
                                        <div class="double-arrow-part arrow-left"></div>
                                    </div>
                                </div>

                            <? } ?>
                        </div>

                    <? } ?>

                   

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
            <?=STPL::Fetch('modules/service/list', $vars)?>
        </div>
    </div>

    <? if($vars['last_page'] === false) { ?>
        <div class="show-all-button">
            <button class="btn-pink">показать все</button>
        </div>
    <? } ?>

</div>