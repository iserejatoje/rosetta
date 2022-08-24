<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }

    #surcharge {
        margin: 20px 0;
        width: 350px;
    }

    .print-button {
        margin: 20px 0;
    }

    .print-hidden {
        display: none;
    }
</style>

<?php if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
    <h3><?=$err?></h3><br/>
<?php } else { ?>

<?php
    $order = $vars['order'];
    $store = $vars['order_params']['store'];
?>


<div class="pull-left print-button">
    <a target="_blank" href="#" data-print-order class="btn btn-primary">Печать</a>
</div>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapse-surcharge" aria-expanded="false" aria-controls="collapse-surcharge">
            Доплата
        </a>

        <div class="collapse" id="collapse-surcharge" style="margin-top: 20px">
            <div class="well">
                <form class="surcharge-form" data-surcharge-form>
                    <input type="hidden" name="action" value="ajax_surcharge_order">
                    <input type="hidden" name="order_id" value="<?= $order->OrderID?>">
                    <?php /*
                    <div id="surcharge">
                        <select id="surcharge-select" name="msg" class="form-control">
                            <?php foreach($vars['causes'] as $key => $value): ?>
                                <option value="<?= $key ?>" <?php if(!$key) { echo 'selected="selected"'; } ?>><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>

                        <div class="input-group">
                            <input type="number" class="form-control" id="surcharge-input" placeholder="сумма...">
                            <div class="input-group-btn">
                                <button type="button" data-surcharge-submit class="btn btn-success" href="?section_id=<?=$vars['section_id']?>&action=ajax_surcharge&id=<?= $order->OrderID ?>">
                                    Запросить доплату
                                </button>
                            </div>
                        </div>
                    </div>
                    */?>

                    <fieldset>
                        <h3>Состав заказа</h3>
                        <button type="button" class="btn btn-primary" data-btn-add-product>Добавить</button>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Товар</label>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label" for="count-">Кол-во</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label" for="count-">Цена</label>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label" for="count-">&nbsp;</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="order-content"></div>
                    </fieldset>

                    <button type="button" class="btn btn-success" data-surcharg-order-btn>Запросить доплату</button>
                </form>

            </div>
        </div>
    </div>
</div>

<form name="new_object_form" method="post" enctype="multipart/form-data">

    <input type="hidden" name="action" value="<?=$vars['action']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <input type="hidden" name="id" value="<?=$vars['order']->id?>" />

    <table class="form table table-sriped">
        <tr>
            <td class="header-column">В архив</td>
            <td class="data-column">
                <input type="checkbox" value="1" name="IsArchive" <?if($order->isarchive == 1){?>checked="checked"<?}?>>
            </td>
        </tr>

        <tr>
            <td class="header-column">Номер заказа</td>
            <td class="data-column"><?=$order->id?></td>
        </tr>

        <tr>
            <td class="header-column">Сумма заказа</td>
            <td class="data-column"><?=$order->totalprice?> руб.</td>
        </tr>

        <tr>
            <td class="header-column">Статус заказа</td>
            <td class="data-column">
                <select name="Status" class="form-control">
                    <? foreach(CatalogMgr::$ORDER_STATUSES as $k => $status) { ?>
                        <option value="<?=$k?>" <?if($k == $order->status){?> selected="selected"<?}?>><?=$status?></option>
                    <? } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td class="header-column">Статус оплаты</td>
            <td class="data-column">
                <select name="PaymentStatus" class="form-control">
                    <? foreach(CatalogMgr::$PAYMENT_STATUSES as $k => $status) { ?>
                        <option value="<?=$k?>" <?if($k == $order->paymentstatus){?> selected="selected"<?}?>><?=$status?></option>
                    <? } ?>
                </select>
            </td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Скидочная карта</td>
            <td class="data-column"><?=$order->discountcard?></td>
        </tr>

        <tr>
            <td class="header-column">Имя заказчика</td>
            <td class="data-column"><?=$order->customername?></td>
        </tr>

        <tr>
            <td class="header-column">Телефон заказчика</td>
            <td class="data-column"><?=$order->customerphone?></td>
        </tr>

        <tr>
            <td class="header-column">E-mail заказчика</td>
            <td class="data-column"><?=$order->customeremail?></td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Имя получателя</td>
            <td class="data-column"><?=$order->recipientname?></td>
        </tr>

        <tr>
            <td class="header-column">Телефон получателя</td>
            <td class="data-column"><?=$order->recipientphone?></td>
        </tr>

        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Тип доставки</td>
            <td class="data-column"><?=CatalogMgr::$DT_TYPES[$order->DeliveryType]?></td>
        </tr>

        <? if($order->deliverytype == CatalogMgr::DT_DELIVERY) { ?>
            <tr>
                <td class="header-column">Район доставки, стоимость</td>
                <td class="data-column"><?=$order->deliveryarea?>, <?=$order->deliveryprice?>руб.</td>
            </tr>

            <tr>
                <td class="header-column">Дата доставки</td>
                <td class="data-column"><?=date("d.m.Y", $order->deliverydate)?></td>
            </tr>

            <tr>
                <td class="header-column">Время доставки</td>
                <td class="data-column">
                    <? if($order->correctioncall == 1) { ?>
                    уточнить у получателя <?if($order->NotFlowerNotify){?><span class="label label-danger"><b>Не уведомлять, что это цветы</b></span><?}?>
                    <? } elseif($order->correctioncall == 2) { ?>
                        <?=$order->deliverytime?>
                    <? } ?>
                </td>
            </tr>

            <tr>
                <td class="header-column">Адрес доставки</td>
                <td class="data-column"><?=$order->deliveryaddress?></td>
            </tr>
        <? } else { ?>
            <tr>
                <td class="header-column">Самовывоз из</td>
                <td class="data-column"><?=$store->Name?></td>
            </tr>
        <? } ?>


        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Открытка</td>
            <td class="data-column">
                <?if($order->cardid > 0) { ?>
                    <?=$order->cardname?> (<?=$order->cardprice?>руб.)<br/>
                    Текст открытки: <?=$order->cardtext?>
                <? } else { ?>
                без открытки
                <? } ?>
            </td>
        </tr>


        <tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column">Состав заказа</td>
            <td class="data-column">
                <?php foreach($order->refs as $item) {
                    $category = $item['RealProduct'] ? $item['RealProduct']->category : null;
                    $params = unserialize($item['Params']);
                ?>
                    <?php if($item['RealProduct']) { ?>
                        <?php if($category->kind == CatalogMgr::CK_ROSE) { ?>
                            <b>[<?=$category->title?>]</b> <span class="label label-info">арт.: <?=$item['RealProduct']->article?></span> <?=$item['RealProduct']->Name?> x <?=$item['Count']?>шт. (<?=$params['length']?>см., <?=$params['roses_count']?>шт.) - <?=$item['BouquetPrice'] * $item['Count']?>руб
                        <?php } elseif($category->kind == CatalogMgr::CK_MONO) { ?>
                            <b>[<?=$category->title?>]</b> <span class="label label-info">арт.: <?=$item['RealProduct']->article?></span> <?=$item['RealProduct']->Name?> x <?=$item['Count']?>шт. (цветов в букете: <?=$params['flower_count']?>шт.) - <?=$item['BouquetPrice'] * $item['Count']?>руб
                        <?php } elseif($category->kind == CatalogMgr::CK_BOUQUET) { ?>
                            <b>[<?=$category->title?>]</b> <span class="label label-info">арт.: <?=$item['RealProduct']->article?></span> <?=$item['RealProduct']->name?> (<?=$item['BouquetType']?>) x <?=$item['Count']?>шт. - <?=$item['Price']?>руб
                        <?php } ?>

                        <?php if($item['Additions']) {
                            $additions = unserialize($item['Additions']);
                            ?>
                            <div>
                                <b>Дополнительные товары к букету:</b><br>
                                <?php foreach($additions as $addition) { ?>
                                    арт.: <?=$addition['article']?> <?=$addition['name']?> x <?=$addition['count']?>шт. - <?=$addition['price'] * $addition['count']?>руб..<br>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <?= $item['Name'] ?> x <?=$item['Count']?>шт. - <?=$item['Price']?>руб
                    <?php } ?>
                    <hr>
                <?php } ?>
            </td>
        </tr>

        <?php if($order->Comment): ?>
            <tr><td class="separator" colspan="2"></td></tr>

            <tr>
                <td class="header-column">Комментарий к заказу</td>
                <td class="data-column" style="white-space: pre-line">
                    <?= $order->Comment ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td colspan="2" align="center">
                <br/>
                <button type="submit" class="btn btn-success btn-large">Сохранить</button>
            </td>
        </tr>
    </table>
</form>

<div class="print-hidden" id="print">
    <div class="print-container">
        <style>
            .print-wrapper {
                width: 320px;
                border-bottom: 1px dashed #000;
                padding: 10px;
            }
        </style>
        <div class="print-wrapper">
            <h3 style="margin: 0; text-align: center;">Лист доставки</h3>
            <?php if($order->deliverytype == CatalogMgr::DT_DELIVERY): ?>
                <div>
                    <b>Дата и время доставки:</b>
                    <?= date("d.m.Y", $order->deliverydate) ?>,
                    <?php if($order->correctioncall == 1): ?>
                        уточнить у получателя
                    <?php elseif($order->correctioncall == 2): ?>
                        <nobr> <?= $order->deliverytime ?></nobr>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div>
                <b>№ заказа:</b>
                <?= $order->id ?>
            </div>
            <div>
                <b>Открытка:</b>
                <?php if($order->cardid > 0): ?>
                    <?= $order->cardname ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </div>
            <div>
                <b>Состав заказа:</b>
                <?php foreach($order->refs as $item): ?>
                    <?php
                        $category = $item['RealProduct']->category;
                        $params = unserialize($item['Params']);
                    ?>

                    <?php if($item['RealProduct'])  { ?>
                        <?=$item['RealProduct']->article?> –
                        <?=$item['RealProduct']->Name?> x
                        <?=$item['Count']?>шт.
                        <?php if($category->kind == CatalogMgr::CK_ROSE): ?>
                            (длина <?=$params['length']?>см.,
                            цветов <?=$params['roses_count']?>шт.);
                        <?php elseif($category->kind == CatalogMgr::CK_MONO): ?>
                            (цветов в букете: <?=$params['flower_count']?>шт.);
                        <?php elseif($category->kind == CatalogMgr::CK_BOUQUET): ?>
                            (размер <?=$item['BouquetType']?>);
                        <?php endif; ?>

                        <? if($item['Additions']): ?>
                            <?php $additions = unserialize($item['Additions']); ?>
                            <?php foreach($additions as $addition): ?>
                                <?=$addition['article'] ?> -
                                <?=$addition['name']?> x
                                <?=$addition['count']?>шт.;
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php } else { ?>
                        <?=$item['Name']?> x
                        <?=$item['Count']?>шт.
                    <?php } ?>


                <?php endforeach; ?>
            </div>
            <div>
                <b>Адрес доставки:</b>
                <?= $order->deliveryaddress ?>
                <br>
                <br>
                <br>
            </div>
            <div>
                <b style="margin-top: 30px">Тип доставки:</b> <nobr><?= ($order->deliverytype == 1) ? "Доставка курьером" : "Самовывоз" ?></nobr> </br>
                <b style="margin-top: 30px">Район доставки:</b> <nobr><?=$order->deliveryarea?></nobr></br>
                <b style="margin-top: 30px">Стоимость доставки:</b><nobr><?=$order->deliveryprice?></nobr></br>
                <b style="margin-top: 30px">Время доставки:</b> <nobr><?=$order->deliverytime?></nobr></br>
                <b style="margin-top: 30px">Получатель:</b>
                <?=$order->recipientname?>, <nobr><?=$order->recipientphone?></nobr>
            </div>
            <div style="margin-top: 10px">
                <b>Подпись получателя:</b>
                ___________________
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

var productItem = `
<div class="row product-item">
    <div class="col-md-3">
        <div class="form-group">
            <input type="text"  class="form-control product-name" name="products[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <input type="number" id="product-" class="form-control product-count" value="1" min="1" name="counts[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <input type="number" id="product-" class="form-control product-price" name="prices[]" required>
            <div class="help-block"></div>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <button class="btn btn-danger" type="button" data-remove-product-btn>
                <i class="glyphicon glyphicon-trash"></i>
            </button>
        </div>
    </div>
</div>
`

$('body').on('click', '[data-surcharg-order-btn]', function() {

    console.log('CLICK!')
    var form = $('[data-surcharge-form]');

    if(compositionIsNotEmpty() === false) {
        alert('Необходимо сформировать состав (добавить товары)');
    }

    let newSender = fetch('',{
      method: 'POST',
      body: form.serialize()
    })

    $.ajax({
        url: '',
        method: 'post',
        dataType: 'json',
        data: form.serialize(),
        success: function(data) {
            if(data.status === 'error') {
                console.log('error')
                alert(data.message);
            } else if (data.status == 'ok') {
              console.log(data.message);
                $('.order-content').find('.product-item').remove();
                    $('#collapse-surcharge').collapse('hide')

                alert(data.message);
            }
        }
    });

});


var compositionIsNotEmpty = function() {
    var products = [];

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

    return products.length > 0;
}

$('[data-btn-add-product]').click(function () {
    $('.order-content').append(productItem)
});

$('body').on('click', '[data-remove-product-btn]', function() {
    $(this).closest('.row').remove();
});

$('[data-surcharge-submit]').on('click', function(e) {
    e.preventDefault();
    var $input = $('#surcharge-input'),
        sum = $input.val();

    if(sum * 1 <= 0) {
        alert('Сумма должна быть больше 0');
        return false;
    }

    $.ajax({
        url: $(this).attr('href') + '&sum=' + sum + '&msg=' + $('#surcharge-select').val(),
        dataType: "json",
        type: "get",
        success: function(data){
            if (data.status == 'ok') {
                alert(data.message);
                $input.val('');
            }
        },
        fail: function() {
            alert('Серверная ошибка');
        }
    });
});

$('[data-print-order]').on('click', function(e) {
    e.preventDefault();
    var html = document.getElementById("print").innerHTML;
    var mywindow = window.open('', 'my div');
    mywindow.document.write('<html><head><title>Заказ</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(html);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10
    mywindow.print();
    mywindow.close();
    return true;
});
</script>

<? } ?>
