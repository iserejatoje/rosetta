<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
</style>

<? if (UserError::GetErrorByIndex('global') != '') { ?>
	<div style="text-align: center; color:red;"><? UserError::GetErrorByIndex('global') ?></div>
<? } else { ?>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<input type="hidden" name="action" value="<?= $vars['action'] ?>" />

<table class="sortable table table-bordered">
	<? if ($vars['form']['Created']) { ?>
	<tr>
		<td bgcolor="#F0F0F0">Дата создания / редактирования</td>
		<td width="85%"><?= $vars['form']['Created'] ?> / <?= $vars['form']['LastUpdated'] ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Показывать</td>
		<td width="85%">&nbsp;&nbsp;<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible']==1) { ?> checked<? } ?>></td>
	</tr>

	<tr>
		<td bgcolor="#F0F0F0" width="150">Артикул</td>
		<td width="85%"><input class="form-control" type="text" name="Article" value="<?=$vars['form']['Article'] ?>" class="input_100"></td>
	</tr>

	<tr>
		<td bgcolor="#F0F0F0" width="150">Название</td>
		<td width="85%"><input class="form-control" type="text" name="Name" value="<?= $vars['form']['Name'] ?>" class="input_100"></td>
	</tr>

	<? if (UserError::GetErrorByIndex('Name') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Name') ?></td>
	</tr>
	<? } ?>
	<? if (UserError::GetErrorByIndex('Price') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Price') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Цена, руб.</td>
		<td width="85%"><input class="form-control"  type="text" name="Price" value="<?=$vars['form']['Price'] ?>" class="input_100"></td>
	</tr>
</table>
<center><br><input type="submit" value="Сохранить" class="btn btn-success btn-large" />
<script type="text/javascript" language="javascript">
  <?= UserError::SetFocusToError() ?>
</script>
</form>
<? } ?>