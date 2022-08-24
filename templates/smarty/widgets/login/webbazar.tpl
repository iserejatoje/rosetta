dfgjdfgj

{if $USER->IsAuth()}
<div class="login_form login_form_autorised">
	<div class="welcome">
		Здравствуйте, {$res.showname}!
	</div>
	<div class="links">
		<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
		<br>
		<div>
			<a href="{$res.url_messages}">{if $res.newmessages_count > 0}<font color="red">у вас {$res.newmessages_count} {if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if}</font>{else}мои сообщения{/if}</a>
			{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
		</div>
	</div>
</div>
{else}
<div class="login_form">
	<form method="POST" action="{$res.url_login}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$res.url}" />
<div class="login_form_title">Вход в паспорт</div>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><input class="in_email" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
		<td><input class="in_pswd" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
	<tr>
		<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label></td>
		<td><input tabindex="1003" type="submit" value="Войти" class="in_submit" /></td>
	</tr>
</table>
<div class="links"><nobr><a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;<a href="{$res.url_forgot}">Забыли пароль?</a></nobr></div>
</form>
</div>
{/if}
