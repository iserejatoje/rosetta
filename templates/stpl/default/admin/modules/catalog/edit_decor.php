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
	function addDecorRange()
	{ 
		$('.items').append('<tr><td><input class="form-control" type="text" name="DecorFrom[]" value=""></td><td><input class="form-control" type="text" name="DecorTo[]" value=""></td><td><input class="form-control" type="text" name="DecorPrice[]" value=""></td><td><a class="btn btn-danger btn-sm" onclick="removeDecorRange(this)" href="javascript:;" title="Удалить параметр">Удалить</a></td></tr>');
	}
	function removeDecorRange(o)
	{
		$(o).parent().parent().remove();
	}
</script>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<input type="hidden" name="action" value="<?= $vars['action'] ?>" />
<input type="hidden" name="id" value="<?= $vars['form']['DecorID'] ?>" />

<table class="sortable table table-bordered">
	<? if (UserError::GetErrorByIndex('NodeType') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('NodeType') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Тип оформления</td>
		<td width="85%">
			<select name="NodeType" class="form-control">
				<option value="0">- Выберите тип оформления -</option>
			<? foreach ($vars['DECOR_NODE_TYPES'] as $type => $p) { ?>
				<option value="<?= $type ?>"<? if ($vars['form']['NodeType'] == $type) { ?> selected="selected"<? } ?>><?= $p['name'] ?></option>
			<? }?>
			</select>
		</td>
	</tr>
	<? if (UserError::GetErrorByIndex('Name') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Name') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Название оформления</td>
		<td width="85%"><input class="form-control" type="text" name="Name" value="<?= $vars['form']['Name'] ?>" class="input_100"></td>
	</tr>
	<? if (UserError::GetErrorByIndex('Ranges') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Ranges') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Ценовая политика</td>
		<td width="85%">
		
			<div class="form-group">
				<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="addDecorRange()" title="Добавить элемент">
					<span class="glyphicon glyphicon-plus"></span>
					Добавить&#160;
				</a>
			</div>
			<table class="items table table-striped">
				<tr>
					<th>Кол-во ОТ</th>
					<th>Кол-во ДО</th>
					<th>Цена</th>
					<th></th>
				</tr>
			<? foreach ($vars['form']['Ranges'] as $k => $l) { ?>
				<tr>
					<td><input type="text" class="form-control" name="DecorFrom[<?= $k ?>]" value="<?= $l['from'] ?>"></td>
					<td><input type="text" class="form-control" name="DecorTo[<?= $k ?>]" value="<?= $l['to'] ?>"></td>
					<td><input type="text" class="form-control" name="DecorPrice[<?= $k ?>]" value="<?= $l['price'] ?>"></td>
					<td><a class="btn btn-danger btn-sm" onclick="removeDecorRange(this)" href="javascript:;" title="Удалить параметр">Удалить</a></td>
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