<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Внимание</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-danger" role="alert"><?=$err?></div>
        </div>
    </div>
<? } else { ?>
<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .ord-field {
        text-align: center;
    }
    a .glyphicon-success {
        color: #5cb85c !important;
    }
    a .glyphicon-danger {
        color: #d9534f !important;
    }
    .product-name {
        font-size: 16px;
    }
    .font-23 {
        font-size: 23px;
    }
    .font-20 {
        font-size: 20px;
    }
</style>

<script>

    $(document).ready(function(){

        $('.table a.delete').click(function(e){
            e.preventDefault();
            if (!confirm("Вы действительно хотите удалить?"))
                return false;

            document.location.href = $(this).attr("href");
        });

        $('.sorted-link').click(function() {
            var sort_field = $(this).data('field');
            var sort_dir = $(this).find('.glyphicon').data('dir');

            if(sort_dir == 'desc' || sort_dir == '')
                var dir = 'asc';
            else
                var dir = 'desc'

            $("#sorting-field").val(sort_field);
            $("#sorting-dir").val(dir);
            $("#filter-form").submit();
        });


        $('#create_from, #create_to, #delivery_from, #delivery_to').datetimepicker(
            {pickTime: false, language: 'ru'}
        );
    });
</script>

<? if($vars['action'] == 'orders') { ?>
    <a href="?section_id=<?=$vars['section_id']?>&action=archived_orders">Архивные заказы</a>
<? } else { ?>
    <a href="?section_id=<?=$vars['section_id']?>&action=orders">Заказы</a>
<? } ?>

<?php /*
<form method="get" id="sortingform">
    <input type="hidden" name="action" value="<?= $vars['action'] ?>"/>
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
</form>
*/ ?>

<br>
<br>
<a href="?section_id=<?=$vars['section_id']?>&action=order_form" class="btn btn-success">Новый заказ</a>
<form id="filter-form" method="get" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $vars['action'] ?>" />

    <input type="hidden" name="action" value="<?= $vars['action'] ?>"/>
    <input type="hidden" name="field" id="sorting-field" value="<?= $vars['sorting']['field'] ?>">
    <input type="hidden" name="dir" id="sorting-dir" value="<?= $vars['sorting']['dir'] ?>">

    <div class="field-block col-sm-12" style="padding: 30px 0;">
        <div class="col-sm-3">
            Дата формирования заказа
            <div class="input-group date" id="create_from">
                <span class="input-group-addon">
                    От
                </span>
                <input type="text" class="form-control" name="create_from" value="<?= $vars['dates']['create_from'] ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
            <div class="input-group date" id="create_to">
                <span class="input-group-addon">
                    До
                </span>
                <input type="text" class="form-control" name="create_to" value="<?= $vars['dates']['create_to'] ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-sm-3">
            Дата доставки заказа
            <div class="input-group date" id="delivery_from">
                <span class="input-group-addon">
                    От
                </span>
                <input type="text" class="form-control" name="delivery_from" value="<?= $vars['dates']['delivery_from'] ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
            <div class="input-group date" id="delivery_to">
                <span class="input-group-addon">
                    До
                </span>
                <input type="text" class="form-control" name="delivery_to" value="<?= $vars['dates']['delivery_to'] ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-sm-3">
            Статус
            <select name="status" class="form-control">
                <option value="-1">- все -</option>
                <? foreach(CatalogMgr::$ORDER_STATUSES as $k => $v) { ?>
                <option value="<?=$k?>" <?if($vars['status'] == $k){?> selected="selected"<?}?>><?=$v?></option>
                <? } ?>
            </select>
        </div>
        <!-- <div class="col-sm-3">

        </div> -->
        <!-- <div class="col-sm-1"></div> -->
        <div class="col-sm-3">
            Статус оплаты
            <select name="paymentstatus" class="form-control">
                <option value="-1">- все -</option>
                <? foreach(CatalogMgr::$PAYMENT_STATUSES as $k => $v) { ?>
                <option value="<?=$k?>" <?if($vars['paymentstatus'] == $k){?> selected="selected"<?}?>><?=$v?></option>
                <? } ?>
            </select>
        </div>
<!-- 		<div class="col-sm-3">

        </div> -->
    </div>

    <input type="submit" class="btn btn-primary btn-sm" value="фильтровать"/>
</form>

<?php if($vars['pages']): ?>
    <?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
<?php endif; ?>

<form method="POST" name="productform">
    <input type="hidden" name="action" value="save_products_order" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <table class="sortable table table-bordered table-hover table-striped">
        <tr>
            <th width="2%">#</th>
            <th width="8%">
                <a href="javascript:;" data-field="created" data-dir="" class="sorted-link">
                    Дата заказа
                    <? if($vars['sorting']['field'] == 'created') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
            <th width="10%">
                <a href="javascript:;" data-field="deliverydate" data-dir="" class="sorted-link">
                    Дата доставки / самовывоза
                    <? if($vars['sorting']['field'] == 'deliverydate') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>

            <th width="50%">
                <a href="javascript:;" data-field="customername" data-dir="" class="sorted-link">
                    Заказчик
                    <? if($vars['sorting']['field'] == 'customername') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>

            <th width="7%">
                <a href="javascript:;" data-field="deliverytype" data-dir="" class="sorted-link">
                    Доставка
                    <? if($vars['sorting']['field'] == 'deliverytype') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>

            <th width="7%">
                <a href="javascript:;" data-field="totalprice" data-dir="" class="sorted-link">
                    Сумма заказа
                    <? if($vars['sorting']['field'] == 'totalprice') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
            <th width="7%">
                <a href="javascript:;" data-field="status" data-dir="" class="sorted-link">
                    Статус
                    <? if($vars['sorting']['field'] == 'status') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
            <th width="7%">
                <a href="javascript:;" data-field="paymentstatus" data-dir="" class="sorted-link">
                    Оплата
                    <? if($vars['sorting']['field'] == 'paymentstatus') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
            <?/*
            <th width="3%">Удалить</th>
            */?>
        </tr>
        <? $i = 0; ?>

        <? foreach($vars['orders'] as $item){ ?>
        <tr id="product_<?=$item->ID?>">
            <td align="center"><?=$item->ID?></td>

            <td align="center"><?=date("d.m.Y H:i:s", $item->Created)?></td>

            <td align="center">
                <?=date("d.m.Y", $item->deliverydate)?><br/>
                <? if($item->correctioncall == 1) { ?>
                    время уточнить  у получателя<br/>

                <? } elseif($item->correctioncall == 2) { ?>
                    <?=$item->deliverytime?>
                <? } ?>
            </td>

            <td>
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_order&id=<?=$item->ID?>">
                    <?=$item->customername?>, тел: <?=$item->customerphone?>
                </a>

                <?php if($item->Comment): ?>
                    (<?= $item->Comment ?>)
                <?php endif; ?>
            </td>

            <td align="center">
                <?=CatalogMgr::$DT_TYPES[$item->deliverytype]?>
            </td>

            <td align="center">
                <? $item->totalprice + $item->deliveryprice + $item->cardprice?>
                <?=$item->totalprice?>
            </td>

            <td align="center">
                <?=CatalogMgr::$ORDER_STATUSES[$item->status]?>
            </td>

            <td align="center">
                <?=CatalogMgr::$PAYMENT_STATUSES[$item->paymentstatus]?>
            </td>

        </tr>
        <? $i++; ?>
        <? } ?>

    </table>


    <? /*<br/><br/><br/>
    <div style="text-align:center">
        <button type="submit" class="btn btn-success btn-large">Сохранить</button>
    </div> */ ?>
</form>

<?php if($vars['pages']): ?>
    <?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
<?php endif; ?>


<? } ?>