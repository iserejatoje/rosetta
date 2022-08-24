{if $USER->IsAuth() === false}
<form method="POST" action="{$res.url_login}">
<input type="hidden" name="action" value="login" />
<input type="hidden" name="url" value="{$res.url}" />

<table cellpadding="4" width="100%">
	<tr style="font-size: 12px;">
		<td class="ftable_header" colspan="2">Вход в форум</td>
	</tr>
	<tr>
		<td>
			E-mail: <input type="text" name="email" title="E-mail" />&nbsp;&nbsp;&nbsp;&nbsp;
			Пароль: <input type="password" name="password" title="Пароль" />&nbsp;&nbsp;
			<input type="submit" value="Войти" class="in_submit" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" id="login_form_forum_remember" name="remember" class="remember" value="1" checked="checked" /><label title="Запомнить меня на этом компьютере" for="login_form_forum_remember" class="remember">запомнить</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="fcomment" href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
			<a class="fcomment" href="{$res.url_forgot}">Забыли пароль?</a>
		</td>
	</tr>
</table>
</form>
<br/>
{/if}