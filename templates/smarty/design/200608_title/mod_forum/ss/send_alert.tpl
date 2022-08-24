<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	{$TITLE->Head}
</head>
<body>
	<div style="text-align: center;">
	{if $USER->IsAuth()}
		{if $res.status == 'ok'}
			<br /><br />Спасибо{if $USER->IsAuth() && isset($USER->Profile.general.ShowName)}, {$USER->Profile.general.ShowName}{/if}.<br /><br />
			Сообщение будет проверено модератором.<br /><br />
			<a href="javascript:void(0);" onclick="window.close();">Закрыть</a>
		{else}
		Если вы действительно хотите обратить внимание модератора на это сообщение, то введите код, указанный на картинке и нажмите кнопку &laquo;Отправить&raquo;<br>
		{if $UERROR->GetErrorByIndex('captcha') != ''}
			<div style="color:red"><span>{$UERROR->GetErrorByIndex('captcha')}</span></div>
		{/if}
		<form method="POST" style="margin:0px;padding:0px;padding-top:8px;">
			<input type="hidden" name="action" value="send_alert" />
			<table cellpadding="0" align="center">
				<tr>
					<td><img src="{$res.captcha_path}" width="150" height="50" border="0" /></td>
					<td>
						<input type="text" name="captcha_code" id="captcha_code" value="" style="width:100px" /><br />
						<input type="submit" value="Отправить" style="width:100px" />
						<script type="text/javascript" language="javascript">document.getElementById('captcha_code').focus();</script>
					</td>
				</tr>
			</table>
		</form>
		{/if}
	{else}
		Заявка на модерирование принимается только от зарегистрированных пользователей.
	{/if}
	</div>
</body>
</html>
{*<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Форум</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>
	<br />
	<div style="font-size: 16px; text-align: center;">
	{if $USER->IsAuth()}
		Спасибо{if $USER->IsAuth() && isset($USER->Profile.general.ShowName)}, {$USER->Profile.general.ShowName}{/if}.<br /><br />
		Сообщение будет проверено модератором.
	{else}
		Заявка на модерирование принимается только от зарегистрированных пользователей.
	{/if}
	</div>
</body>
</html>
*}