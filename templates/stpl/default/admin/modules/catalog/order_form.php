<?php
foreach($vars as $var => $value) $$var = $value;
?>

<?php if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
    <h3>Ошибка!!<?=$err?></h3><br/>
<?php } else { ?>

<style>
.obtaining {
    pointer-events: none;
    opacity: .7;
    transition: opacity: .5s ease;
}

.obtaining.checked {
    pointer-events: all;
    opacity: 1;
}

.summary-order {
    display: none;
}

.with-discount-text {
    display: none;
}

.not-flower-notify-label {
    display: none;
}

</style>

<div class="container" id="app">

    <div class="row">
        <div class="col-lg-12">
            <form id="create-order" action="" method="POST" data-custom-order-form>
                <input type="hidden" name="order[CatalogID]" value="<?= $catalogId ?>">
                <?php /*
                <input type="hidden" name="action" value="<?= $action ?>">
                */?>
                <input type="hidden" name="action" data-hidden-action value="ajax_calc_order_price">
                <div class="form-group">
                    <label class="control-label" for="order-comment">Описание заказа</label>
                    <textarea id="order-comment" class="form-control" name="order[Comment]" rows="5" required><?= $order->Comment ?></textarea>
                    <div class="help-block"></div>
                </div>

                <fieldset>
                    <h3>Состав заказа</h3>
                    <button type="button" class="btn btn-primary" data-btn-add-product>Добавить</button>
                    <div class="order-content"></div>

                    <div class="help-block">
                        <?php if (($err = UserError::GetErrorByIndex('composition')) != '' ) { ?>
                            <span class="error"><?=$err?></span><br/>
                        <?php } ?>
                    </div>
                </fieldset>

                <?php /*
                <div class="form-group">
                    <label class="control-label" for="order-totalpice">Cумма заказа</label>
                    <input type="number" id="order-totalpice" class="form-control" name="order[TotalPrice]" value="<?= $order->TotalPrice ?>" required>
                    <div class="help-block"></div>
                </div>
                */?>
                <?php /*
                <div class="form-group">
                    <label class="control-label" for="discount">Cкидка (руб)</label>
                    <input type="number" id="discount" class="form-control" name="discount" value="<?= $discount ?>">
                    <div class="help-block"></div>
                </div>
                */?>

                <fieldset>
                    <legend>Клиент</legend>
                    <div class="form-group">
                        <label class="control-label" for="order-customername">Имя клиента</label>
                        <input type="text" id="order-customername" class="form-control" name="order[CustomerName]" value="<?= $order->CustomerName ?>" required>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="order-customeremail">Адрес эл.почты клиента</label>
                        <input type="email" id="order-customeremail" class="form-control" name="order[CustomerEmail]" value="<?= $order->CustomerEmail ?>" required>
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="order-CustomerPhone">Телефон клиента</label>
                        <input type="tel" id="order-CustomerPhone" class="form-control" name="order[CustomerPhone]" value="<?= $order->CustomerPhone ?>" required>
                        <div class="help-block"></div>
                    </div>

                </fieldset>

                <fieldset>
                    <legend>Получатель</legend>
                    <div class="form-group">
                        <button type="button" data-action="copy-customer" class="btn btn-info">Заполнить поля с клиента</button>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="order-RecipientName">Имя получателя заказа</label>
                        <input type="text" id="order-RecipientName" class="form-control" name="order[RecipientName]" value="<?= $order->RecipientName ?>">
                        <div class="help-block"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="order-RecipientPhone">Телефон получателя заказа</label>
                        <input type="tel" id="order-RecipientPhone" class="form-control" name="order[RecipientPhone]" value="<?= $order->RecipientPhone ?>">
                        <div class="help-block"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Способ получения</legend>
                    <div class="row">
                        <?php $checked = $order->DeliveryType == $delivery? ' checked': ''; ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order-DeliveryType-delivery">
                                    <input type="radio" id="order-DeliveryType-delivery" name="order[DeliveryType]" value="<?= $delivery ?>"<?= $checked ?>>
                                    <?= $deliveryTypes[$delivery] ?>
                                </label>
                            </div>

                            <div class="obtaining obtaining_<?= $delivery ?><?= $checked ?>">
                                <div class="form-group">
                                    <label for="order-DistrictID">Район доставки</label>

                                    <select name="order[DistrictID]" id="order-DistrictID" class="form-control">
                                        <?php foreach($districts as $district): ?>
                                            <?php $selected = $district->ID == $order->DistrictID? ' selected' : ''; ?>
                                            <option value="<?= $district->ID ?>"<?= $selected ?>><?= $district->Name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="help-block"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="order-DeliveryAddress">Адрес доставки</label>
                                    <input type="text" id="order-DeliveryAddress" class="form-control" name="order[DeliveryAddress]" value="<?= $order->DeliveryAddress ?>">
                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>

                        <?php $checked = $order->DeliveryType == $pickup? ' checked': ''; ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order-DeliveryType-pickup">
                                    <input type="radio" id="order-DeliveryType-pickup" name="order[DeliveryType]" value="<?= $pickup ?>"<?= $checked ?>>
                                    <?= $deliveryTypes[$pickup] ?>
                                </label>
                            </div>

                            <div class="obtaining obtaining_<?= $pickup ?><?= $checked ?>">
                                <div class="form-group">
                                    <label for="order-StoreID">Адрес магазина</label>
                                    <select name="order[StoreID]" id="order-StoreID" class="form-control">
                                        <?php foreach($stores as $store): ?>
                                            <?php $selected = $store->ID == $order->StoreID? ' selected' : ''; ?>
                                            <option value="<?= $store->ID ?>"<?= $selected ?>><?= $store->Name ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <div class="help-block"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <label for="order-DeliveryDate">Дата доставки/самовывоза</label>
                    <?php $value = $order->DeliveryDate ?: ''; ?>
                    <input id="order-DeliveryDate" type="text" class="form-control" name="order[DeliveryDate]" value="<?= $value ?>" required/>
                    <?php if (($err = UserError::GetErrorByIndex('DeliveryDate')) != '' ) { ?>
                        <span class="error">Ошибка: <?=$err?></span><br/>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="correction-call">
                        <input type="checkbox" name="order[CorrectionCall]" id="correction-call" value='1'> Cпросить клиента о времени доставки
                    </label>
                </div>

                <div class="form-group">
                    <label for="not-flower-notify" class="not-flower-notify-label">
                        <input type="checkbox" name="order[NotFlowerNotify]" id="not-flower-notify" value='1'> Не говорить, что цветы
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Время с:</label>
                            <select id="time-from" name="time[from]" class="form-control">
                                <?php foreach($times as $t): ?>
                                    <?php $selected = $t == $time['from']? ' selected' : ''; ?>
                                    <option value="<?= $t ?>"<?= $selected ?>><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Время до:</label>
                            <select name="time[to]" id="time-to" class="form-control">
                                <?php foreach($times as $t): ?>
                                    <?php $selected = $t == $time['to']? ' selected' : ''; ?>
                                    <option value="<?= $t ?>"<?= $selected ?>><?= $t ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <fieldset>
                    <legend>Открытка</legend>
                    <div class="form-group">
                        <label for="order-CardID">Тип открытки:</label>
                        <select id="order-CardID" class="form-control" name="order[CardID]">
                            <option value="0">Без открытки</option>
                            <?php foreach($cards as $card): ?>
                                <?php $selected = $card->CardID == $order->CardID? ' selected' : ''; ?>
                                <option value="<?= $card->CardID ?>"<?= $selected ?>><?= $card->Name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="order-CardText">Текст открытки:</label>
                        <textarea name="order[CardText]" id="order-CardText" rows="10" class="form-control"><?= $order->CardText ?></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Дисконтная карта</legend>
                    <div class="form-group">
                        <label for="">Номер карты:</label>
                        <input type="number" id="order-DiscountCard" name="order[DiscountCard]" class="form-control" value="<?= $order->DiscountCard ?>">
                    </div>
                </fieldset>

                <hr>
                    <button type="button" class="btn btn-success" data-calc-order-price-btn>Рассчитать</button>
                    <span class="summary-order">
                        <b>Сумма заказа <span class="with-discount-text">(с учетом скидки)</span></b>: <span class="summary-price"></span></span><br/>
                    <span class="order-message text-danger"></span>
                <hr>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">

var productItem = `
<div class="row product-item">
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Товар</label>
            <input type="text"  class="form-control product-name" name="products[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label class="control-label" for="count-">Кол-во</label>
            <input type="number" id="product-" class="form-control product-count" value="1" min="1" name="counts[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="count-">Цена</label>
            <input type="number" id="product-" class="form-control product-price" name="prices[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label class="control-label" for="count-">&nbsp;</label><br>
            <button class="btn btn-danger" type="button" data-remove-product-btn>
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </div>
    </div>
</div>
`

var clearMessages = function () {
    $('.with-discount-text').hide();
    $('.order-message').text('').hide();
    $('.summary-price').text('');
    $('.summary-order').hide();
}

;(function() {
    $("[name='order[DeliveryType]']").on("change", function() {
        var value = $("[name='order[DeliveryType]']:checked", "#create-order").val();
        $(".obtaining").removeClass("checked");
        $(".obtaining_" + value).addClass("checked");
    });

    $('body').on('click', '[data-calc-order-price-btn]', function() {
        var form = $('[data-custom-order-form]');
        $('[data-hidden-action]').val('ajax_calc_order_price')

        $.ajax({
            url: '',
            method: 'post',
            dataType: 'json',
            data: form.serialize(),
            success: function(data) {
                clearMessages();

                if(data.status !== 'ok') {
                    $('.order-message').text(data.message).show();

                    return false;
                }

                if(data.withDiscount) {
                    $('.with-discount-text').show();

                    if(data.discountCardIsValid === false) {
                        $('.order-message').text('Скидочная карта невалидна либо не активна').show();
                    }
                }

                $('.summary-price').text(data.totalPrice + 'р');
                $('.summary-order').show();
            }
        });

    });

    $('[data-custom-order-form]').submit(function(e) {
        var products = [];
        $('[data-hidden-action]').val('order_save')

        $(".product-item").each(function(index, el) {
            var $el = $(el);
            var productName = $el.find('.product-name').val();
            var productCount = $el.find('.product-count').val();
            var productPrice = $el.find('.product-price').val();

            if(productName.length > 0 && productCount > 0 && productPrice > 0) {
                products.push({
                    name: productName,
                    price: productPrice,
                    count: productCount
                })
            }

        });

        if(products.length === 0) {
            e.preventDefault();
            alert('Нужно сформировать состав заказа (Добавить товары)');
            return false;
        }

        return true;
    });

    $('[data-btn-add-product]').click(function() {
        $('.order-content').append(productItem)
    })

    $('body').on('click', '[data-validate-form]', function() {
        validateForm()
    });

    $('body').on('click', '[data-remove-product-btn]', function() {
        $(this).closest('.row').remove();
    })

    $('[data-remove-product-btn]').on('click', function() {
        $(this).closest('.row').remove();
    })

    $('#order-DeliveryDate').datetimepicker(
        {
            pickTime: false,
            language: 'ru',
            minDate: new Date(),
        }
    );

    $('#correction-call').on('click', function() {
        var notFlowerNotifyCheckbox = $('#not-flower-notify');
        var notFlowerNotifyLabel = notFlowerNotifyCheckbox.closest('label');
        if($(this).is(':checked')) {
            notFlowerNotifyLabel.show();
        } else {
            notFlowerNotifyCheckbox.prop('checked', false);
            notFlowerNotifyLabel.hide();
        }
    });

    $("[data-action='copy-customer']").on("click", function() {
        $("#order-RecipientName").val($("#order-customername").val());
        $("#order-RecipientPhone").val($("#order-CustomerPhone").val());
    });
})();

</script>

<?php } ?>