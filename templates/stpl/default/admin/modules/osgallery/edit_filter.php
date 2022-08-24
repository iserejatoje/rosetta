<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
</style>

<? if (UserError::GetErrorByIndex('global') != '') { ?>
	<div style="text-align: center; color:red;"><?= UserError::GetErrorByIndex('global') ?></div>
<? } else { ?>
<script>
	function addFilter()
	{
		$('.items').append('<tr> \
                <td></td> \
                <td><input class="form-control" type="text" name="param_name[]" value=""></td> \
                <td><input class="form-control" type="text" name="param_value[]" value=""></td> \
                <td><input type="checkbox" class="form-control" name="param_availability[]" value="1"></td> \
                <td><input type="text" class="form-control" name="param_ord[]" value=""></td> \
                <td><a class="btn btn-danger btn-sm" onclick="remove_param(this)" href="javascript:;" title="Удалить параметр"> \
                        <span class="glyphicon glyphicon-trash"></span> \
                    </a> \
                </td> \
            </tr>');
	}
	function remove_param(o)
	{
		$(o).parent().parent().remove();
	}
</script>
<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
	<input type="hidden" name="action" value="<?= $vars['action'] ?>" />
	<input type="hidden" name="id" value="<?= $vars['form']['FilterID'] ?>" />

<table class="sortable table table-bordered">
	<? if (UserError::GetErrorByIndex('NameID') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('NameID') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Ключ фильтра</td>
		<td width="85%"><input class="form-control" type="text" name="NameID" value="<?= $vars['form']['NameID'] ?>" class="input_100"></td>
	</tr>
	<? if (UserError::GetErrorByIndex('Name') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Name') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Название фильтра</td>
		<td width="85%"><input class="form-control" type="text" name="Name" value="<?= $vars['form']['Name'] ?>" class="input_100"></td>
	</tr>
	<?/*
	<tr>
		<td bgcolor="#F0F0F0">Вес относительно состава</td>
		<td width="85%"><input class="form-control" type="text" name="Weight" value="<?= $vars['form']['Weight'] ?>" class="input_100"></td>
	</tr>
	*/?>
	<? if (UserError::GetErrorByIndex('params') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('params') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Параметры фильтра</td>
		<td width="85%">

			<div class="form-group">
				<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="addFilter()" title="Добавить элемент">
					<span class="glyphicon glyphicon-plus"></span>
					Добавить&#160;
				</a>
			</div>
			<table class="items table table-striped">
				<tr>
					<th style="width: 3%">id</th>
					<th style="width: 20%">Название</th>
					<th style="width: 20%">Значение <small>(необязательно)</small></th>
					<th style="width: 3%">Видимость</th>
					<th style="width: 3%">Порядок</th>
					<th style="width: 3%"></th>
				</tr>
			<? foreach ($vars['params'] as $k => $l) {
				?>
				<tr>
					<td><? if ($vars['action'] == 'edit_filter') { ?><input  type="hidden" name="param_id[<?= $k ?>]" value="<?= $k ?>"/><?= $k ?><? } ?></td>
					<td><input class="form-control" type="text" name="param_name[<?= $k ?>]" value="<?= $l['Name'] ?>"></td>
					<td><input class="form-control" type="text" name="param_value[<?= $k ?>]" value="<?= $l['Value'] ?>"></td>
					<td><input type="checkbox" class="form-control" name="param_availability[<?=$k?>]" <?if($l['IsAvailable'] == 1){?>checked="checked"<?}?> value="1"></td>
					<td><input type="text" class="form-control" name="param_ord[<?=$k?>]" value="<?=$l['Ord']?>"></td>
					<td><a class="btn btn-danger btn-sm" onclick="remove_param(this)" href="javascript:;" title="Удалить параметр"><span class="glyphicon glyphicon-trash"></span></a></td>
				</tr>
			<? } ?>
			</table>
		</td>
	</tr>
</table>
<center><br><input type="submit" class="btn btn-success btn-large" value="Сохранить" />
<script type="text/javascript" language="javascript">
  <?= UserError::SetFocusToError() ?>
</script>
</form>
<? } ?>