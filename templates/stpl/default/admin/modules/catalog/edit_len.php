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
	<input type="hidden" name="id" value="<?=$vars['form']['LenID']?>" />
	<input type="hidden" name="productid" value="<?=$vars['productid']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">Доступно для заказа</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr>
			<td class="header-column">Длина по-умолчанию</td>
			<td class="data-column">
				<input type="checkbox" name="IsDefault" value="1"<? if ($vars['form']['IsDefault'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column important">Длина<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Len')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="form-control" name="Len" value="<?=UString::ChangeQuotes($vars['form']['Len'])?>">
			</td>
		</tr>

		<tr>
			<td class="header-column important">Компонент<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Cost')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<select name="MemberID"	class="form-control">
					<option value="0">- укажите компонент -</option>
					<? foreach($vars['members'] as $member) {
						$areaRefs = $member->GetAreaRefs($vars['section_id']);
						?>
					<option value="<?=$member->id?>" <?if($vars['form']['MemberID']==$member->id){?> selected="selected"<?}?>><?=$member->name?> [<?=$areaRefs['Price']?> руб.]</option>
					<? } ?>
				</select>

			</td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
		<?/*
		*/?>
	</table>
</form>

<? } ?>