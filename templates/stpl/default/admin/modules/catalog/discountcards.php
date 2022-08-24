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
            $("#sortingform").submit();
        });

        $('.table a.active').click(function(e){
            e.preventDefault();

            $.ajax({
                url: $(this).attr('href'),
                dataType: "json",
                type: "get",
                success: function(data){
                    if (data.status == 'error')
                        return false;

                    if (data.active == 1)
                    {
                            $('.table #discountcard_'+data.discountcardid+' a.active .glyphicon')
                            .removeClass('glyphicon-eye-close')
                            .removeClass('glyphicon-danger')
                            .addClass('glyphicon-eye-open')
                            .addClass('glyphicon-success');
                    }
                    else
                    {
                            $('.table #discountcard_'+data.discountcardid+' a.active .glyphicon')
                            .removeClass('glyphicon-eye-open')
                            .removeClass('glyphicon-success')
                            .addClass('glyphicon-eye-close')
                            .addClass('glyphicon-danger');
                    }
                }
            });
        });

	});
</script>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Загрузка номеров заблокированных карт</div>
                <div class="panel-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="load_cards">
                        <table>
                            <tr>
                                <td>
                                    <input type="file" name="update_file" />
                                </td>
                                <td>
                                    <button class="btn btn-success btn-large" type="submit">
                                        <span class="glyphicon glyphicon-save"></span>Загрузить
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<br/>

<form method="get" id="sortingform">
    <input type="hidden" name="action" value="discountcards"/>
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">

    <!-- ========================================================= -->
    <div class="field-block col-sm-12" style="">
        <div class="col-sm-3">
            Дата присвоения карты
            <div class="input-group date" id="create_from">
                <span class="input-group-addon">От</span>
                <input type="text" class="form-control" name="date_from" value="<?=$vars['date_from']?>">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
             </div>
            <div class="input-group date" id="create_to">
                <span class="input-group-addon">
                    До
                </span>
                <input type="text" class="form-control" name="date_to" value="<?=$vars['date_to']?>">
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="col-sm-3">
            Номер карты
            <div class="input-group date">
                <span class="input-group-addon">
                    От
                </span>
                <input type="text" class="form-control" name="card_from" value="<?= $vars['card_from'] ?>"/>
             </div>
            <div class="input-group date">
                <span class="input-group-addon">До</span>
                <input type="text" class="form-control" name="card_to" value="<?= $vars['card_to'] ?>"/>
            </div>
        </div>
        <div class="col-sm-3">
            Номер заказа
            <div class="input-group date">
                <span class="input-group-addon">
                    От
                </span>
                <input type="text" class="form-control" name="orderid_from" value="<?= $vars['orderid_from'] ?>"/>
             </div>
            <div class="input-group date">
                <span class="input-group-addon">До</span>
                <input type="text" class="form-control" name="orderid_to" value="<?= $vars['orderid_to'] ?>"/>
            </div>
        </div>
    </div>

    <div class="field-block col-sm-12" style="">
        <div class="col-sm-3">&nbsp;</div>
    </div>

    <div class="field-block col-sm-12" style="">
        <div class="col-sm-3">
            <input type="submit" class="btn btn-primary btn-sm" value="фильтровать"/>
        </div>
    </div>

    <div class="field-block col-sm-12" style="">
        <div class="col-sm-3">&nbsp;</div>
    </div>

    <!-- ========================================================= -->
<?/*
    <table>
        <tr>
            <td>
                <div class="form-group">
                    от&nbsp;&nbsp;&nbsp;
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" name="date_from" value="<?=$vars['date_from']?>">
                </div>
            </td>
            <td>
                <div class="form-group">
                    &nbsp;&nbsp;&nbsp;до&nbsp;&nbsp;&nbsp;
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="text" class="form-control" name="date_to" value="<?=$vars['date_to']?>">
                </div>
            </td>
            <td>
                <div class="form-group col-md-offset-1">
                    <input type="submit" class="btn btn-primary btn-sm" value="фильтровать"/>
                </div>
            </td>
        </tr>
    </table>
*/?>
</form>

<?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>

<form method="POST" name="discountcardform">
	<input type="hidden" name="action" value="save_discountcards" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
            <th width="2%">#</th>
			<th width="10%">
				<a href="javascript:;" data-field="created" data-dir="" class="sorted-link">
                    Дата создания
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
            	<a href="javascript:;" data-field="code" data-dir="" class="sorted-link">
            		Номер
                    <? if($vars['sorting']['field'] == 'code') {
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
            	<a href="javascript:;" data-field="discount" data-dir="" class="sorted-link">
            		Скидка
                    <? if($vars['sorting']['field'] == 'discount') {
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
            	<a href="javascript:;" data-field="orderid" data-dir="" class="sorted-link">
            		Номер заказа
                    <? if($vars['sorting']['field'] == 'orderid') {
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
                <a href="javascript:;" data-field="isactive" data-dir="" class="sorted-link">
                    Активация
                    <? if($vars['sorting']['field'] == 'isactive') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>

            <th></th>

			<?/*
			<th width="3%">Удалить</th>
			*/?>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['discountcards'] as $item){ ?>
		<tr id="discountcard_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

            <td align="center"><?=date("d.m.Y H:i:s", $item->Created)?></td>

            <td align="center">
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_discountcard&id=<?=$item->ID?>">
                    <?=$item->code?>
                </a>
            </td>

            <td align="center">
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_discountcard&id=<?=$item->ID?>">
                    <?= $item->discount ?>
                </a>
            </td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_discountcard&id=<?=$item->ID?>">
                    <? if($item->orderid > 0) { ?>
					   Заказ №<?=$item->orderid?>
                    <? } ?>
				</a>
			</td>

            <td align="center">
                <a href="?section_id=<?=$vars['section_id']?>&action=ajax_discountcard_toggle_active&id=<?=$item->ID?>" class="active btn btn-default btn-sm">
                    <? if ($item->isactive == 1) { ?>
                        <span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
                    <? } else { ?>
                        <span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
                    <? } ?>
                </a>
            </td>

            <td></td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>


	<? /*<br/><br/><br/>
	<div style="text-align:center">
		<button type="submit" class="btn btn-success btn-large">Сохранить</button>
	</div> */ ?>
</form>

<?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>

<? } ?>