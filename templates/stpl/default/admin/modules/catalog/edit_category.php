<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        tinymce.init({
            selector: "textarea",
            language: "ru",
            theme: "modern",
            width: 1000,
            height: 400,
            plugins: [
                "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media youtube | forecolor backcolor  | print preview code",
            image_advtab: true,
            indentOnInit: true,

            relative_urls: false,
            external_filemanager_path: "/resources/static/filemanager/",
            filemanager_title:"Файлы",
            external_plugins: {
                "filemanager" : "/resources/static/filemanager/plugin.min.js"
            }
        });
    });
</script>

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
	<input type="hidden" name="id" value="<?=$vars['form']['CategoryID']?>" />

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
			<td class="header-column important">URL<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('NameID')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="form-control" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>">
			</td>
		</tr>

		<tr>
			<td class="header-column important">Тип товаров<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Kind')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<select name="Kind" id="" class="form-control">
					<option value="0">- укажите тип каталога -</option>
					<? foreach(CatalogMgr::$CTL_KIND as $k => $v) { ?>
					<option value="<?=$k?>" <?if($vars['form']['Kind'] == $k){?> selected="selected"<?}?>><?=$v['name']?></option>
					<? } ?>
				</select>

			</td>
		</tr>

		<tr><td class="separator" colspan="2"></td></tr>
		<?/*
		<tr>
			<td class="header-column">Фото раздела<br/></td>
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

        <tr>
            <td class="header-column">SEO Текст</td>
            <td class="data-column">
                <textarea class="form-control" name="SeoText"><?=UString::ChangeQuotes($vars['form']['SeoText'])?></textarea>
            </td>
        </tr>

		<tr><td class="separator" colspan="2"><div></div></td></tr>

		<tr>
			<td colspan="2" align="center">
				<br/>
				<button type="submit" class="btn btn-success btn-large">Сохранить</button>
			</td>
		</tr>
	</table>
</form>

<? } ?>