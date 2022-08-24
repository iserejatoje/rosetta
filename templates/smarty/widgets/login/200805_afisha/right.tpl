<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td>
{if $USER->IsAuth()}
	<table width="100%" border="0" cellspacing="3" cellpadding="0" style="background: url(/_img/design/200805_afisha/green_search_bg.gif) repeat-x;">
	<tr>
		<td><img src="/_img/x.gif" height="5" width="1" alt="" /></td>
	</tr>
	<tr>
		<td align="left">
			<font class="footer_links_reklama">Здравствуйте</font>
		</td>
	</tr>
	<tr>
		<td align="left">
		<div class="menu"><b>{$res.showname}</b></div>
		</td>
	</tr>
	<tr>
		<td align="left">
		<a href="{$res.url_mypage}" class="dop10">моя страница</a>&nbsp;&nbsp;
		<a href="{$res.url_logout}" class="dop10">выход</a>
		{if $res.newmessages_count > 0}
			<br/><b><a href="{$res.url_messages}" class="dop10">мои сообщения ({$res.newmessages_count})</a></b>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
		</td>
	</tr>
	</table>
{else}
	<table width="100%" border="0" cellspacing="3" cellpadding="0" style="background: url(/_img/design/200805_afisha/green_search_bg.gif)  repeat-x;">
	<tr>
		<td><img src="/_img/x.gif" height="5" width="1" alt="" /></td>
	</tr>
	<tr>
		<td align="left" class="footer_links_reklama">Вход в паспорт</td>
	</tr>
	<form method="POST" action="{$res.url_login}" style="margin:0px;">
	<input type="hidden" name="action" value="login" />
	<input type="hidden" name="url" value="{$smarty.server.REQUEST_URI|escape:"quotes"}" />
	<tr>
		<td align="left">
		<table width="100%" border="0" cellspacing="0" cellpadding="3">
			<tr><td class="menu" valign="middle"><b>E-Mail</b></td><td><input class="txt2" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td></tr>
			<tr><td class="menu" valign="middle"><b>Пароль</b></td><td><input class="txt2" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td></tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="left">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr align="left">
		<td width="50px"><input tabindex="1003" type="submit" value="Войти" class="txt2" style="width:50px"/></td>
		<td width="15px"><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" />&nbsp;</td>
		<td class="otzyv" valign="middle" style="padding-top: 5px;"><label title="Запомнить меня на этом компьютере" for="login_form_remember" ><b>запомнить</b></label></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="left"><nobr>
			<a href="{$res.url_register}" class="dop10">Регистрация</a>&nbsp;&nbsp;
			<a href="{$res.url_forgot}" class="dop10">Забыли пароль?</a></nobr>
		</td>
	</tr>
	</form>
	</table>
{/if}
</td></tr>
</table>