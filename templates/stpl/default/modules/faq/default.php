<div class="shadow-sep"></div>

<div class="container">
    <h1 class="page-title">ВОПРОС-ОТВЕТ</h1>

    <div class="page-qa theme-blue">
        <div class="feedback-img-form">
            <div class="feedback-img-form-body clearfix">
                <div class="feedback-controls">
                    <div class="feedback-img-form-label">Задайте вопрос</div>
                    <form method="post" action="/faq/">
                        <input type="hidden" name="action" value="ajax_send_question">
                        <div class="form-group">
                            <div class="form-group field-customerQuestionName ajax-required">
                                <input type="text" class="form-control form-control-rect-simple" placeholder="Ваше имя" id="customerQuestionName" name="customerQuestionName" autocomplete="off" data-vtype="notempty" data-message="Укажите ваше имя">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="form-group-grid clearfix">
                            <div class="form-group group-half field-customerQuestionPhone ajax-required">
                                <input type="text" class="form-control form-control-rect-simple phone-mask" placeholder="+7-(___)-___-____" id="customerQuestionPhone" name="customerQuestionPhone" autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона">
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group group-half field-customerQuestionMail ajax-required">
                                <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш  e-mail" id="customerQuestionMail" name="customerQuestionMail" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
                                <p class="help-block help-block-error"></p>
                            </div>
                        </div>
                        <div class="form-group field-customerQuestionComment ajax-required">
                            <textarea class="form-control form-control-rect-simple" placeholder="Ваш вопрос" id="customerQuestionComment" name="customerQuestionComment" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст вопроса"></textarea>
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
                <div class="feedback-img" style="background-image: url(/resources/img/design/rosetta/qa/form-img.jpg);">

                </div>
            </div>
        </div>

        <div class="qa-items-block">
            <form method="post" action="." data-form="ajax-filter">
                <input type="hidden" name="action" value="ajax_load_all_questions">
            </form>

            <div class="qa-items" id="faq-questions-list">
                <?=STPL::Fetch('modules/faq/list', $vars); ?>
            </div>

            <? if($vars['last_page'] == false) { ?>
                <div class="show-all-button">
                    <button class="btn-pink load-more-handl">показать все вопросы</button>
                </div>
            <? } ?>
        </div>
    </div>
</div>