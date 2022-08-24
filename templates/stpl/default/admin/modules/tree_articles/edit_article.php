<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else {
App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/synctranslit/synctranslit.js');
?>

<style>
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	.acl-field {
		padding-top: 4px;
		padding-bottom: 4px;
		border-bottom: dotted 1px #898989;
	}
</style>

<script>
	var placemark = null;
	var map  = null;

	$(function() {
		$(".input-number-field").keypress(function(e){
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				return false;
		});

		$(".input-float-field").keypress(function(e){

			if( e.which!=8 && e.which!=0 && e.which != 46 && (e.which<48 || e.which>57))
				return false;
		});

		$('#title-field').syncTranslit({
			destination: 'nameid',
			urlSeparator: '_'
		});

	});

</script>



<form name="article_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['ArticleID']?>" />
	<input type="hidden" name="ParentID" value="<?=$vars['form']['ParentID']?>" />
	<input type="hidden" name="close" id="close_hid" value="" />

	<table class="form">
		<tr>
			<td class="header-column">Страницу отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<?/*
		<tr>
			<td class="header-column">Возможность комментировать страницы</td>
			<td class="data-column">
				<input type="checkbox" name="IsComments" value="1"<? if ($vars['form']['IsComments'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<tr>
			<td class="header-column">Выводить в RSS</td>
			<td class="data-column">
				<input type="checkbox" name="IsRSS" value="1"<? if ($vars['form']['IsRSS'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<tr>
			<td class="header-column">Выводить на главную</td>
			<td class="data-column">
				<input type="checkbox" name="IsMain" value="1"<? if ($vars['form']['IsMain'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<tr>
			<td class="header-column">Важная новость</td>
			<td class="data-column">
				<input type="checkbox" name="IsImportant" value="1"<? if ($vars['form']['IsImportant'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		*/?>
		<tr>
			<td class="header-column important">Заголовок страницы <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Title')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" id="title-field" class="input-text-field" name="Title" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Имя для ссылки <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('NameID')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" id="nameid" class="input-text-field" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>"><br/>
			</td>
		</tr>
		<?/*
		<tr>
			<td class="header-column">Краткий заголовок новости <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('ShortTitle')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="ShortTitle" value="<?=UString::ChangeQuotes($vars['form']['ShortTitle'])?>"><br/>
			</td>
		</tr>
		*/?>
		<?/*
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">Краткий анонс новости <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('AnnounceText')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<textarea class="mceEditor" name="AnnounceText"><?=$vars['form']['AnnounceText']?></textarea>
			</td>
		</tr>
		*/?>
		<tr>
			<td class="header-column important">Текст страницы <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Text')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<textarea class="mceEditor" name="Text"><?=$vars['form']['Text']?></textarea><br/>
			</td>
		</tr>

		<?/*
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">Превью</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Thumb')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['Thumb']['f'])) { ?>
					<br/><img src="<?=$vars['form']['Thumb']['f']?>">
					<input type="checkbox" name="del_thumb" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="Thumb" value="" />
			</td>
		</tr>
		*/?>
		<?/*
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">SEO Title</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoTitle" value="<?=$vars['form']['SeoTitle']?>"/><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">SEO Description</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoDescription" value="<?=$vars['form']['SeoDescription']?>"/><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">SEO Keywords</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="SeoKeywords" value="<?=$vars['form']['SeoKeywords']?>"/><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column important">SEO Текст для прдвижения</td>
			<td class="data-column">

				<textarea class="ckeditor" name="SeoText"><?=$vars['form']['SeoText']?></textarea><br/>
			</td>
		</tr>
		*/?>
	<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td colspan="2" align="center">
				<script>
					function mysubmit(close)
					{
						$('#close_hid').val(close);
						document.forms.article_form.submit();
						return true;
					}
				</script>
				<br/>
				<? if ($vars['action'] == 'new_article') { ?>
				<input type="button" value="Сохранить" onclick="mysubmit(1)"/>
				<? } else { ?>
				<input type="button" value="Сохранить" onclick="mysubmit(0)"/>
				<input type="button" value="Сохранить и закрыть" onclick="mysubmit(1)"/>
				<? } ?>
			</td>
		</tr>
	</table>
</form>
<br/><br/>
<? } ?>