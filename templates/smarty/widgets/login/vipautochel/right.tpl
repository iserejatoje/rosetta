{if $USER->IsAuth()}
<div>
<table width="100%" cellspacing="0" cellpadding="3" border="0" class="ltext">
<tbody><tr><td bgcolor="#f3f0d6" align="left" class="rantitle">Здравствуйте, {$res.showname}</td></tr>
</tbody></table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="ltext">
<tr><td height="1" bgcolor="#ffffff"><img height="1" src="/_img/x.gif"></td></tr></table>
	<div style="background-color:#fcf9dd;">
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
<table width="100%" cellspacing="0" cellpadding="3" border="0" class="ltext">
<tbody><tr><td bgcolor="#f3f0d6" align="left" class="rantitle">Вход в паспорт</td></tr>
</tbody></table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="ltext">
<tr><td height="1" bgcolor="#ffffff"><img height="1" src="/_img/x.gif"></td></tr></table>
<table width="100%" cellpadding="1" cellspacing="0" bgcolor="#fcf9dd">
	<tr>
		<td>E-Mail:</td>
		<td colspan="2"><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
	</tr>
	<tr>
		<td>Пароль:</td>
		<td colspan="2"><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
	<tr>
		<td colspan="3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr align="center">
				<td width="10px"></td>
				<td align="right"><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
				<td align="left">&nbsp;<label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label></td>
				<td align="left" width="50%">&nbsp;<input tabindex="1003" type="submit" value="Войти" class="button" style="width:50px" /></td>
				<td width="20px"></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<div align="center" style="background-color:#fcf9dd;"><nobr>
<a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
<a href="{$res.url_forgot}">Забыли пароль?</a>
</nobr></div>
</form>
</div>
{/if}
