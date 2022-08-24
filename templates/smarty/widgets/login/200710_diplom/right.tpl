{if $USER->IsAuth()}
<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="30"><img src="/_img/design/200710_diplom/iconews.gif" width="37" height="35"></td>
		<td align="right" valign="top" background="/_img/design/200710_diplom/backnews.gif"><font class="zag1-1">Здравствуйте, {$res.showname}</font>&nbsp;&nbsp;</td>
	</tr>
</table>
	<img width="1" height="8" src="/_img/design/200710_diplom/rast.gif"/>
	<div>
		<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><a href="{$res.url_messages}" class='zag2'>{if $res.newmessages_count > 0}<font color="red">у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if*}</font>{else}мои сообщения{/if}</a>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
	</div>
</div>
{else}
<div>
	<form method="POST" action="{$res.url_login}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$smarty.server.REQUEST_URI|escape:"quotes"}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="30"><img src="/_img/design/200710_diplom/iconews.gif" width="37" height="35"></td>
		<td align="right" valign="top" background="/_img/design/200710_diplom/backnews.gif"><font class="zag1-1">Вход в паспорт</font>&nbsp;&nbsp;</td>
	</tr>
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
		<td colspan="3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr align="center">
				<td width="10px"></td>
				<td align="right"><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
				<td align="left">&nbsp;<label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label></td>
				<td align="left"><input tabindex="1003" type="submit" value="Войти" class="button" style="width:50px" /></td>
				<td width="20px"></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
<div align="center"><nobr>
<a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
<a href="{$res.url_forgot}">Забыли пароль?</a>
</nobr></div>
</form>
</div>
{/if}