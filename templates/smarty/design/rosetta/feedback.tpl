<div class="feedback" data-form>
    <div class="cross-close" data-control="feedback-close"></div>
    <div class="feedback-inner-buttons buttons-muted clearfix">
        <div class="feedback-button feedback-button-callback" data-control="feedback" data-form="callback">
            <div class="feedback-button-icon"></div>
            Звонок
        </div>
        <div class="feedback-button feedback-button-letter" data-control="feedback" data-form="letter">
            <div class="feedback-button-icon"></div>
            Письмо
        </div>
    </div>

    <div class="feedback-forms">
        <div class="feedback-form-item form-letter">
            <form method="post" action="/catalog/">
                <input type="hidden" name="action" value="ajax_send_letter">
                <div class="form-group form-control field-letter_name ajax-required">
                    <input id="letter_name" name="letter_name" type="text" class="form-control form-control-rectangular control-widerect" placeholder="Имя"
                        data-message="Введите имя" data-vtype="notempty">
                    <p class="help-block help-block-error"></p>
                </div>

                {*
                    <div class="form-group form-control field-letter_phone ajax-required">
                        <input id="letter_phone" name="letter_phone" type="text" class="form-control form-control-rectangular control-widerect phone-mask" 
                            placeholder="Ваш телефон" data-message="Введите номер телефона" data-vtype="phone">
                        <p class="help-block help-block-error"></p>
                    </div>
                *}

                <div class="form-group form-control field-letter_email ajax-required">
                    <input id="letter_email" name="letter_email" type="text" class="form-control form-control-rectangular control-widerect" 
                        placeholder="Ваш e-mail" data-message="Введите e-mail корректно" data-vtype="email">
                    <p class="help-block help-block-error"></p>
                </div>
               
                <div class="form-group">
                    <textarea type="text" name="letter_text" class="form-control form-control-rectangular control-widerect" placeholder="Текст письма"></textarea>
                </div>

                <div class="form-group field-isAcceptLetter ajax-required">
                    <div class="checkbox is-active" data-control="checkbox" data-trigger="disableSubmitBtn">
                        <input type="hidden" id="isAcceptLetter" name="isAcceptLetter" value="1" data-vtype="notzero" data-message="Поле обязательно">
                        <div class="checkbox-body">
                            <div class="checkbox-icon"></div>
                            <div class="checkbox-label">Согласен на обработку моих <a href="/oferta/#privacy" target="_blank">персональных данных</a></div>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-pink" data-ya-target="send_form">отправить</button>
            </form>
        </div>

        <div class="feedback-form-item form-callback">
            <form method="post" action="/catalog/">
                <input type="hidden" name="action" value="ajax_send_callback">
                <div class="form-group form-control field-callback_name ajax-required">
                    <input type="text" id="callback_name" name="callback_name" class="form-control form-control-rectangular control-widerect" placeholder="Имя"
                        data-message="Введите имя" data-vtype="notempty">
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="form-group form-control field-callback-phone ajax-required">
                    <input type="text" class="form-control form-control-rectangular control-widerect phone-mask" placeholder="Ваш телефон"
                        id="callback-phone" name="callback-phone" data-message="Введите номер телефона" data-vtype="phone">
                    <p class="help-block help-block-error"></p>
                </div>

                <div class="form-group field-isAcceptCall ajax-required">
                    <div class="checkbox is-active" data-control="checkbox" data-trigger="disableSubmitBtn">
                        <input type="hidden" id="isAcceptCall" name="isAcceptCall" value="1" data-vtype="notzero" data-message="Поле обязательно">
                        <div class="checkbox-body">
                            <div class="checkbox-icon"></div>
                            <div class="checkbox-label">Согласен на обработку моих <a href="/oferta/#privacy" target="_blank">персональных данных</a></div>
                            <p class="help-block help-block-error"></p>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn-pink" data-ya-target="call_me">жду звонок</button>
            </form>
        </div>
    </div>
</div>

<div class="ui-feedback">
    <div class="ui-feedback-dots ui-feedback-dots-horizontal"></div>
    <div class="ui-feedback-dots ui-feedback-dots-vertical"></div>
    <div class="ui-feedback-label" data-control="feedback" data-form="callback"><div class="ui-feedback-label-spaced">СВЯЗЬ</div> С НАМИ </div>

    <div class="ui-feedback-buttons-wrapper">
        <div class="ui-feedback-buttons">
            <div class="ui-feedback-button ui-feedback-button-callback" data-control="feedback" data-form="callback"></div>
            <div class="ui-feedback-button ui-feedback-button-letter" data-control="feedback" data-form="letter"></div>
        </div>
    </div>
</div>