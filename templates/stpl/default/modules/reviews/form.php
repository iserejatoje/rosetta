<form method="post" action="/reviews/">
    <input type="hidden" name="action" value="ajax_add_review">
    <div class="form-group">
        <div class="form-group field-customerReviewName ajax-required">
            <input type="text" class="form-control form-control-rect-simple" placeholder="Ваше имя" id="customerReviewName" name="customerReviewName" autcomplete="off" data-vtype="notempty" data-message="Укажите ваше имя"/>
            <p class="help-block help-block-error"></p>
        </div>
    </div>
    <div class="form-group-grid clearfix">
        <div class="form-group group-half field-customerReviewPhone ajax-required">
            <input type="text" class="form-control form-control-rect-simple phone-mask" placeholder="+7-(___)-___-____" id="customerReviewPhone" name="customerReviewPhone" autocomplete="off" data-vtype="phone" data-message="Неверный формат номера телефона"/>
            <p class="help-block help-block-error"></p>
        </div>
        <div class="form-group group-half field-customerReviewMail ajax-required">
            <input type="text" class="form-control form-control-rect-simple" placeholder="Ваш e-mail" id="customerReviewMail" name="customerReviewMail" autocomplete="off" data-vtype="email" data-message="Неверный e-mail пользователя">
            <p class="help-block help-block-error"></p>
        </div>
    </div>
    <!-- <div class="form-group-grid clearfix">
        <div class="form-group group-half">
            <div class="group-half-label">Добавить фотографии к отзыву:</div>
        </div>
        <div class="form-group group-half">
            <div class="btn-file">
                <span class="btn-file-label">Загрузить фотографию</span>
                <input class="form-control" name="photo" type="file" id="recruitFloristPhoto">
            </div>
        </div>
    </div> -->
    <div class="form-group field-customerReviewComment ajax-required">
        <textarea class="form-control form-control-rect-simple" placeholder="Ваш отзыв" id="customerReviewComment" name="customerReviewComment" autocomplete="off" data-vtype="notempty" data-message="Не заполнен текст отзыва"></textarea>
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