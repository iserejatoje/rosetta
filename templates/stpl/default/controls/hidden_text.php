<? if ( (is_object(App::$User) && App::$User->IsAuth()) || $vars['state'] == 'text' ): ?>
	<?=nl2br($vars['text'])?>
<? elseif ( $vars['state'] == 'captcha' ) : ?>
	<form onsubmit="hidden_text.show(this,'<?=$vars['source']?>'); return false;">
		<b>Защита от роботов</b><br />
		<img src="<?=$vars['captcha_path']?>?<?=rand()?>" width="150" height="50" style="margin:4px 0 4px 0;" /><br />
		<input type="text" class="captcha_code" name="captcha_code" style="width:150px;" /><br />
		<input type="submit" value="Показать" /><br />
		<small style="color:#666666">Введите цифры, изображенные на картинке</small>
	</form>
<? else: ?>
	<span>
		<a href="javascript:;" style="text-decoration:none;border-bottom:1px dotted;" onclick="hidden_text.show(this,'<?=$vars['source']?>');">показать</a>
	</span>
<? endif; ?>
