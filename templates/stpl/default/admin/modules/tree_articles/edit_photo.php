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
	fieldset { padding:0; border:0; margin-top:25px; }
	h1 { font-size: 1.2em; margin: .6em 0; }
	
</style>


<form name="new_photo_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="articleid" value="<?=$vars['form']['ArticleID']?>" />
	<input type="hidden" name="photoid" value="<?=$vars['form']['PhotoID']?>" />
	
	<table class="form">
		<tr>
			<td class="header-column">Фотография видима на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Имя фотографии<span class="required-field">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field<? if (UserError::GetErrorByIndex('Name') != '' ) { ?> text-error<? } ?>" name="Name" value="<?=$vars['form']['Name']?>" autocomplete="off"><br/>
			</td>
		</tr>		
		
		<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column important">Фотография для списка (139х100)<span class="required-field">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('PhotoSmall')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				
				<? if (!empty($vars['form']['PhotoSmall']['f'])) { ?>
					<br/><img src="<?=$vars['form']['PhotoSmall']['f']?>">
					<input type="checkbox" name="del_photosmall" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="photosmall" value="" />				
			</td>
		</tr>
		
		<tr>
			<td class="header-column">Большая фотография (1024х768)<span class="required-field">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('PhotoLarge')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				
				<? if (!empty($vars['form']['PhotoLarge']['f'])) { ?>
					<br/><img src="<?=$vars['form']['PhotoLarge']['f']?>">
					<input type="checkbox" name="del_photolarge" value="1"/> удалить<br/>
				<? } ?>
				<input type="file" name="photolarge" value="" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить">
			</td>
		</tr>		
	</table>
</form>
<br/><br/><br/>

<? } ?>