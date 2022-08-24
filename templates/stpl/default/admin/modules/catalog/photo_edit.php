<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
</style>

<? if ($vars['form']['ProductID'] > 0) { ?>
	<?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

<? if (UserError::GetErrorByIndex('global') != '') { ?>
	<div style="text-align: center; color:red;"><?= UserError::GetErrorByIndex('global') ?></div>
<? } else { ?>

<form name="firmform" method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
<input type="hidden" name="productid" value="<?= $vars['form']['ProductID'] ?>" />
<input type="hidden" name="photoid" value="<?= $vars['form']['PhotoID'] ?>" />
<input type="hidden" name="action" value="<?= $vars['action'] ?>" />

<table class="table">
	<? if ($vars['form']['Created']) { ?>
	<tr>
		<td bgcolor="#F0F0F0">Дата создания / редактирования</td>
		<td width="85%"><?= date("Y.m.d", $vars['form']['Created']) ?> / <?= date("Y.m.d", $vars['form']['LastUpdated']) ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Показывать</td>
		<td width="85%"><input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible']==1) { ?> checked<? } ?>></td>
	</tr>

	<? /*<tr>
		<td bgcolor="#F0F0F0">Показывать лайтбокс</td>
		<td width="85%"><input type="checkbox" name="IsLightbox" value="1"<? if ($vars['form']['IsLightbox']==1) { ?> checked<? } ?>></td>
	</tr>*/ ?>

	<? if (UserError::GetErrorByIndex('Name') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('Name') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0" width="150">Название</td>
		<td width="85%"><input class="form-control" type="text" name="Name" value="<?= $vars['form']['Name'] ?>" class="input_100"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" width="150">Alt</td>
		<td width="85%"><input class="form-control" type="text" name="AltText" value="<?= $vars['form']['AltText'] ?>" class="input_100"></td>
	</tr>
	<tr>
		<td bgcolor="#F0F0F0" width="150">Title</td>
		<td width="85%"><input class="form-control" type="text" name="Title" value="<?= $vars['form']['Title'] ?>" class="input_100"></td>
	</tr>

	<? /*
	<? if (UserError::GetErrorByIndex('photo_small') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('photo_small') ?></td>
	</tr>
	<? } ?>

	<tr>
		<td bgcolor="#F0F0F0">Фото маленькое</td>
		<td width="85%">
			<? if (!empty($vars['form']['PhotoSmall']['f'])) { ?>
			<br><img src="<?= $vars['form']['PhotoSmall']['f'] ?>"><br>
			<input type="checkbox" name="del_photosmall" value="1"/> удалить
			<? } ?><br>
			<input type="file" name="photosmall" value="">
		</td>
	</tr>
	*/?>

	<? if (UserError::GetErrorByIndex('photo') != '') { ?>
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;"><?= UserError::GetErrorByIndex('photo') ?></td>
	</tr>
	<? } ?>
	<tr>
		<td bgcolor="#F0F0F0">Фото большое (для слайдера)<br/><small><b>916х676px</b></small></td>
		<td width="85%">
			<? if (!empty($vars['form']['Photo']['f'])) { ?>
			<br><img src="<?= $vars['form']['Photo']['f'] ?>"><br>
			<input type="checkbox" name="del_photo" value="1"/> удалить
			<? } ?><br>
			<input type="file" name="photo" value="">
		</td>
	</tr>
</table>
<center><br><input type="submit" value="Сохранить" class="btn btn-success btn-large"></center>
</form>
<? } ?>