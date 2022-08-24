<style>
	.table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }
</style>

<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['MenuID']?>" />
	<input type="hidden" name="parent_id" value="<?=$vars['form']['ParentID']?>" />

	<table class="form">
		<tr>
			<td class="header-column">Пункт меню отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">Имя пункта меню<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Ссылка пункта меню<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Link')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="Link" value="<?=UString::ChangeQuotes($vars['form']['Link'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column important">Группировка<br/><small>Для группировки в подвале сайта</small></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('GroupID')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<select name="GroupID">
					<option value="0">- укажите групп -</option>
					<? foreach(MenuMgr::$GROUPS as $k => $group) { ?>
					<option value="<?=$k?>" <?if($vars['form']['GroupID'] == $k){?> selected="selected"<?}?>><?=$group?></option>
					<? } ?>
				</select>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"><div></div></td></tr>
		
		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить">
			</td>
		</tr>
	</table>
</form>