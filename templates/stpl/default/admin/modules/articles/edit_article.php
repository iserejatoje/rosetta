<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else { ?>

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

		$(".datepicker").datepicker($.datepicker.regional["ru"]);

		$('.timepicker').timepicker({
			// Options
			defaultTime: '12:34',         // Used as default time when input field is empty or for inline timePicker
										  // (set to 'now' for the current time, '' for no highlighted time, default value: now)

			zIndex: null,                 // Overwrite the default zIndex used by the time picker

			// Localization
			hourText: 'Часы',             // Define the locale text for "Hours"
			minuteText: 'Минуты',         // Define the locale text for "Minute"
			amPmText: ['', ''],       // Define the locale text for periods
			rows: 6

		});

	});

</script>



<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['ArticleID']?>" />

	<table class="form">
		<tr>
			<td class="header-column">Новость отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<?/*
		<tr>
			<td class="header-column">Возможность комментировать новость</td>
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
		<?/*
		<tr>
			<td class="header-column">Дата новости</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Date')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input class="datepicker" type="text"<? if (UserError::GetErrorByIndex('Date') != '' ) { ?> class="text-error"<? } ?> name="Date" value="<?=date("d.m.Y", $vars['form']['Date'])?>" autocomplete="off">
				<input class="timepicker" type="text"<? if (UserError::GetErrorByIndex('Time') != '' ) { ?> class="text-error"<? } ?> name="Time" value="<?=date("H:i", $vars['form']['Time'])?>" autocomplete="off">
			</td>
		</tr>
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
		<tr>
			<td class="header-column important">Заголовок страницы <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Title')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="Title" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>"><br/>
			</td>
		</tr>
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<?/*
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
			<td class="header-column important">Текст новости <span class="required">*</span></td>
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
			<td class="header-column">Превью<br/><small>(94x88px)</small></td>
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
		<tr>
			<td class="header-column">Фото<br/><small></small></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Photo')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['Photo']['f'])) { ?>
					<br/><img src="<?=$vars['form']['Photo']['f']?>">
					<input type="checkbox" name="del_photo" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="Photo" value="" />
			</td>
		</tr>
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<?/*
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
		*/?>
		<tr><td class="separator" colspan="2"><div></div></td></tr>
			<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить">
			</td>
		</tr>
	</table>
</form>
<br/><br/>
<? } ?>