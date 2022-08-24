<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
</style>

<? if (($err = UserError::GetErrorByIndex('global')) != '' )
{?>
	<h3><?=$err?></h3><br/>
<? }
else
{ ?>

<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['CardID']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">Открытка доступна для заказа</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column important">Размер<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="form-control" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
			</td>
		</tr>

		<tr>
			<td class="header-column important">Цена<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Price')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="form-control" name="Price" value="<?=UString::ChangeQuotes($vars['form']['Price'])?>">
			</td>
		</tr>


		<tr><td class="separator" colspan="2"></td></tr>
<?/*
		<tr>
			<td class="header-column">Фото<br/></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Icon')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['Icon']['f'])) { ?>
					<img src="<?=$vars['form']['Icon']['f']?>"><br/>
					<input type="checkbox" name="del_Icon" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="Icon" value="" />
			</td>
		</tr>
*/?>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>

<? } ?>