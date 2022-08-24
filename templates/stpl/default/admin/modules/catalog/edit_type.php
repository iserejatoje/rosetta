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

<? if ($vars['form']['ProductID'] > 0) { ?>
	<?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['TypeID']?>" />

	<table class="form table table-sriped">
		<tr>
			<td class="header-column">Раздел отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column important">Название раздела<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Title')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="form-control" name="Title" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>">
			</td>
		</tr>

        <tr>
            <td class="header-column important">Ссылка<span class="required">*</span></td>
            <td class="data-column">
                <? if (($err = UserError::GetErrorByIndex('NameID')) != '' ) { ?>
                    <span class="error"><?=$err?></span><br/>
                <? } ?>
                <input class="form-control" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>">
            </td>
        </tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column">Иконка раздела<br/></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Icon')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['Icon']['f'])) { ?>
					<img src="<?=$vars['form']['Icon']['f']?>"><br/>
					<label><input type="checkbox" name="del_Icon" value="1"/> удалить</label><br/>
				<? } ?>
				<input type="file" name="Icon" value="" />
			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>

		<tr>
			<td class="header-column">SEO Текст</td>
			<td width="100%" colspan="2">
				<textarea name="SeoText" class="mceEditor input_100" style="height:400px; width: 100%;"><?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoText']))?></textarea>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Title</td>
			<td class="data-column">
				<input class="form-control" name="SeoTitle" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoTitle']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Description</td>
			<td class="data-column">
				<input class="form-control" name="SeoDescription" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoDescription']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Keywords</td>
			<td class="data-column">
				<input class="form-control" name="SeoKeywords" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoKeywords']))?>"><br/>
			</td>
		</tr>

		<? /* <tr>
			<td class="header-column">SEO Title</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoTitle" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoTitle']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Description</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoDescription" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoDescription']))?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">SEO Keywords</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoKeywords" value="<?=UString::ChangeQuotes(DATA::ChangeTags($vars['form']['SeoKeywords']))?>"><br/>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"><div></div></td></tr> */ ?>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>

<? } ?>