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
	<input type="hidden" name="id" value="<?=$vars['form']['ShareID']?>" />

	<table class="form">
		<tr>
			<td class="header-column">Акция отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr><td class="separator" colspan="2"><div></div></td></tr>

		<tr>
			<td class="header-column">Заголовок акции</td>
			<td class="data-column">
				<input type="text" name="Title" value="<?=UString::ChangeQuotes($vars['form']['Title'])?>" class="input-text-field"/>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Текст акции<span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Text')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<textarea class="ckeditor" name="Text"><?=$vars['form']['Text']?></textarea><br/>
			</td>
		</tr>
		<?php /*<tr>
			<td class="header-column">Примечание к акции</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Note')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field" name="Note" value="<?=UString::ChangeQuotes($vars['form']['Note'])?>"><br/>
			</td>
		</tr> */?>
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">Фото<br/><small>(283x283px)</small></td>
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
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">Рекламный слоган</td>
			<td class="data-column">
				<textarea name="TitleText" class="textarea"><?=$vars['form']['TitleText']?></textarea><br/>
			</td>
		</tr>
		<?php /*<tr>
			<td class="header-column">Фото для мобильных устройств<br/><small>(90x90px)</small></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('SmallThumb')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['SmallThumb']['f'])) { ?>
					<br/><img src="<?=$vars['form']['SmallThumb']['f']?>">
					<input type="checkbox" name="del_smallthumb" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="SmallThumb" value="" />
			</td>
		</tr> */?>
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<? /*<tr>
			<td class="header-column">Ссылка акции</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Link" value="<?=UString::ChangeQuotes($vars['form']['Link'])?>"><br/>
			</td>
		</tr> */ ?>
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