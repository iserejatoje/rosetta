<?php
foreach($vars as $var => $value) $$var = $value;
?>

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

</style>

<div class="container" id="app">

    <div class="row">
        <div class="col-lg-12">
            <form id="create-order" action="" method="POST">
                <input type="hidden" name="order[CatalogID]" value="<?= $catalogId ?>">
                <input type="hidden" name="action" value="<?= $action ?>">
                <div class="form-group">
                    <label class="control-label" for="order-comment">Произвольное название (описание) букета(ов)</label>
                    <textarea id="order-comment" class="form-control" name="order[Comment]" rows="5" required><?= $order->Comment ?></textarea>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="order-totalpice">Cумма заказа</label>
                    <input type="number" id="order-totalpice" class="form-control" name="order[TotalPrice]" value="<?= $order->TotalPrice ?>" required>
                    <div class="help-block"></div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="discount">Cкидка (руб)</label>
                    <input type="number" id="discount" class="form-control" name="discount" value="<?= $discount ?>">
                    <div class="help-block"></div>
                </div>

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
                    <input id="order-DeliveryDate" type="text" class="form-control" name="order[DeliveryDate]" value="<?= $value ?>"/>
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
                            <option>Без открытки</option>
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

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">

;(function() {
    $("[name='order[DeliveryType]']").on("change", function() {
        var value = $("[name='order[DeliveryType]']:checked", "#create-order").val();
        $(".obtaining").removeClass("checked");
        $(".obtaining_" + value).addClass("checked");
    });

    $('#order-DeliveryDate').datetimepicker(
        {
            pickTime: false,
            language: 'ru',
            minDate: new Date(),
        }
    );

    $("[data-action='copy-customer']").on("click", function() {
        $("#order-RecipientName").val($("#order-customername").val());
        $("#order-RecipientPhone").val($("#order-CustomerPhone").val());
    });
})();

</script>