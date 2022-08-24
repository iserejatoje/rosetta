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
	<input type="hidden" name="id" value="<?=$vars['form']['AdditionID']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">Доп. отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

<?/*
		<tr>
			<td class="header-column">Отображать в карточке товара</td>
			<td class="data-column">
				<input type="checkbox" name="InCard" value="1"<? if ($vars['form']['InCard'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
*/?>
		<tr><td class="separator" colspan="2"></td></tr>

        <tr>
            <td class="header-column important">Артикул</td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Article')) != '' ) { ?>
                <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="Article" value="<?=UString::ChangeQuotes($vars['form']['Article'])?>">
            </td>
        </tr>

		<tr>
			<td class="header-column important">Название доп. товара<span class="required">*</span></td>
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

		<tr>
			<td class="header-column important">Описание<span class="required">*</span></td>
			<td class="data-column">
				<textarea name="Description" class="form-control"><?=$vars['form']['Description']?></textarea>
			</td>
		</tr>

		<tr>
		    <td class="header-column">Тема</td>
		    <td class="data-column">
		        <select name="Theme" class="form-control">
		            <option value="0">- Укажите тему -</option>
		            <? foreach(CatalogMgr::$THEMES as $k => $theme) { ?>
		                <option value="<?=$k?>" <?if($k == $vars['form']['Theme']){?> selected="selected"<?}?>><?=$theme['name']?></option>
		            <? } ?>
		        </select>
		    </td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>
		<tr>
			<td class="header-column">Фото для отображение в списке<br/><small><b>254x280px</b></small></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
					<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['PhotoSmall']['f'])) { ?>
					<img src="<?=$vars['form']['PhotoSmall']['f']?>"><br/>
					<input type="checkbox" name="del_PhotoSmall" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="PhotoSmall" value="" />
			</td>
		</tr>

		<tr>
			<td class="header-column">Фото для карточки<br/><small><b>768х768px</b></small></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
					<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['PhotoBig']['f'])) { ?>
					<img src="<?=$vars['form']['PhotoBig']['f']?>"><br/>
					<input type="checkbox" name="del_PhotoBig" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="PhotoBig" value="" />
			</td>
		</tr>
        <tr>
            <td class="header-column">Фото для корзины<br/><small><b>392х341px</b></small></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>

                <? if (!empty($vars['form']['PhotoCart']['f'])) { ?>
                    <img src="<?=$vars['form']['PhotoCart']['f']?>"><br/>
                    <input type="checkbox" name="del_PhotoCart" value="1"/> удалить<br/>
                <? } ?>
                <input type="file" name="PhotoCart" value="" />
            </td>
        </tr>

        <? /*
		<tr>
			<td class="header-column">Фото для корзины маленькая<br/></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
					<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['PhotoCartSmall']['f'])) { ?>
					<img src="<?=$vars['form']['PhotoCartSmall']['f']?>"><br/>
					<input type="checkbox" name="del_PhotoCartSmall" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="PhotoCartSmall" value="" />
			</td>
		</tr>
        */?>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>

<? } ?>