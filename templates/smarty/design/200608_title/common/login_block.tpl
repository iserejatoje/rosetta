{if $USER->IsAuth()}
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
	<TD width=10 bgColor=#fff6e6>&nbsp;</TD>
    <TD width=210 bgColor=#fff6e6><FONT class=zag1>Здравствуйте</FONT></td>
<tr>
<tr>
	<td colspan="2">
	<div>
	{assign var="profile_general" value=$USER->Profile.general}
		{if $profile_general.firstname!=''}{$profile_general.firstname}{if $profile_general.midname!=''} {$profile_general.midname}{elseif $profile_general.lastname!=''} {$profile_general.lastname}{/if}{else}{$USER->NickName}{/if}!
	</div>
	<div>
		{*<a href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}">моя страница</a>&nbsp;&nbsp;*}
		<a href="/{$ENV.section}/{$CONFIG.files.get.profile.string}">настройки</a>&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.logout.string}?url={$smarty.server.REQUEST_URI|escape:"url"}">выход</a>
	</div>
</div>
	</td>
<tr>
</table>
{else}
<div>
	<form method="POST" action="/{$ENV.section}/{$CONFIG.files.get.login.string}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$smarty.server.REQUEST_URI|escape:"quotes"}" />
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
	<TD width=10 bgColor=#fff6e6>&nbsp;</TD>
    <TD width=210 bgColor=#fff6e6><FONT class=zag1>Вход в паспорт</FONT></td>
<tr>
<tr>
	<td colspan="2">
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><input style="font-size:11px;height:13px;margin-right:5px;width:95px;" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
		<td><input style="font-size:11px;height:13px;margin-left:5px;width:95px;" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
	<tr>
		<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" style="margin:0px;padding:0px;" /> <label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label></td>
		<td><input tabindex="1003" type="submit" value="Войти" class="in_submit" style="width:95px;font-size:11px;margin-left:5px;" /></td>
	</tr>
</table>
<div align="center"><nobr>	
<a href="/{$ENV.section}/{$CONFIG.files.get.register.string}?url={if isset($smarty.get.url)}{$smarty.get.url|escape:"url"}{else}{$smarty.server.REQUEST_URI|escape:"url"}{/if}">Регистрация</a>&nbsp;&nbsp;
<a href="/{$ENV.section}/{$CONFIG.files.get.forgot.string}">Забыли пароль?</a>
</nobr></div>
	</td>
<tr>
</table>
</form>
</div>
{/if}
