{if $USER->IsAuth()}
<table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor="#e9e8e5">
<tr><td width=5 background="/_img/x.gif" width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" class=menu align="left"><b>Здравствуйте, {$res.showname}</b></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=15></td></tr>
</table><br/>
	<div>
		<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><b><a href="{$res.url_messages}">у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count==1}новое{else}новых{/if} сообщени{if $res.newmessages_count==1}е{else}я{/if*}</b></a>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
	</div>
</div>
{else}
<div>
	<form method="POST" action="{$res.url_login}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$smarty.server.REQUEST_URI|escape:"quotes"}" />
<table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor="#e9e8e5">
<tr><td width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" class=menu align="left"><b>Вход в паспорт</b></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=15></td></tr>
</table><br/>
<table width="100%" cellpadding="1" cellspacing="0">
	<tr>
		<td>E-Mail:</td>
		<td colspan="2"><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
	</tr>
	<tr>
		<td>Пароль:</td>
		<td colspan="2"><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
	<tr>
		<td align="right">&nbsp;<input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
		<td><label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label></td>
		<td width="100%"><input tabindex="1003" type="submit" value="Войти" class="button" /></td>
	</tr>
</table>
<div align="center"><nobr>
<a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
<a href="{$res.url_forgot}">Забыли пароль?</a>
</nobr></div>
</form>
</div>
{/if}