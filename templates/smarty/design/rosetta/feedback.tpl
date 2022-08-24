
<div class="feedback" data-form>
    <div class="cross-close" data-control="feedback-close"></div>
    <div class="feedback-inner-buttons buttons-muted clearfix">
        <div class="feedback-button feedback-button-callback" data-control="feedback" data-form="callback">
            <div class="feedback-button-icon"></div>
            Заказать звонок
        </div>
        <div class="feedback-button feedback-button-letter" data-control="feedback" data-form="letter">
            <div class="feedback-button-icon"></div>
            Написать письмо
        </div>
        <a href="tel:8-800-500-62-92" class="feedback-button feedback-button-letter md-hidden lg-hidden xs-visible" >

            <div class="feedback-button-icon tttt">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="414.937px" height="414.937px" viewBox="0 0 414.937 414.937" style="enable-background:new 0 0 414.937 414.937;"
                     xml:space="preserve">
<g>

    <path d="M159.138,256.452c37.217,36.944,80.295,72.236,97.207,55.195c24.215-24.392,39.12-45.614,92.854-2.761
		c53.734,42.874,12.696,71.727-10.757,95.363c-27.064,27.269-128.432,1.911-228.909-97.804C9.062,206.71-17.07,105.54,10.014,78.258
		c23.46-23.637,52.006-64.879,95.254-11.458c43.269,53.394,22.161,68.462-2.054,92.861
		C86.31,176.695,121.915,219.501,159.138,256.452z M213.104,80.203c0,0-11.227-1.754-19.088,6.113
		c-8.092,8.092-8.445,22.032,0.082,30.552c5.039,5.039,12.145,6.113,12.145,6.113c13.852,2.598,34.728,6.997,56.944,29.206
		c22.209,22.208,26.608,43.084,29.206,56.943c0,0,1.074,7.106,6.113,12.145c8.521,8.521,22.46,8.174,30.552,0.082
		c7.861-7.86,6.113-19.087,6.113-19.087c-4.399-28.057-17.999-57.365-41.351-80.716C270.462,98.203,241.153,84.609,213.104,80.203z
		 M318.415,96.958c40.719,40.719,58.079,86.932,52.428,124.379c0,0-1.972,11.859,5.773,19.604
		c8.718,8.718,22.535,8.215,30.695,0.062c5.243-5.243,6.385-13.777,6.385-13.777c4.672-32.361-1.203-97.464-64.647-160.901
		C285.605,2.887,220.509-2.988,188.147,1.677c0,0-8.527,1.136-13.777,6.385c-8.16,8.16-8.656,21.978,0.061,30.695
		c7.746,7.746,19.604,5.773,19.604,5.773C231.484,38.879,277.696,56.24,318.415,96.958z"/>
</g>

</svg>
            </div>

            Позвонить
        </a>
    </div>
    {literal}
    <style>
        .tttt svg {
            width: 34px;
            height: 35px;
            fill: #fff;
            transform: translate3d(4px, 16px, 10px);
        }
        .tttt::after {
            content: none !important;
        }
        @media (max-width: 1200px) {
            .feedback-inner-buttons .feedback-button {
                margin: 0 !important;
            }
            .feedback .feedback-inner-buttons .feedback-button {
                max-width: 33.3% !important;
                width: 100% !important;
            }
        }

    </style>
    {/literal}

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