{if $USER->IsAuth()}
<table class="block_right" width="100%" cellspacing="3" cellpadding="0">
	<tr>	
		<th><span>Здравствуйте, {$res.showname}</span></th>
	</tr>
	<tr><td align="center">
		<div class="links">
			<a class="ssyl" href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
			<a class="ssyl" href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><a href="{$res.url_messages}" style='color:red;'>у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count==1}новое{else}новых{/if} сообщени{if $res.newmessages_count==1}е{else}я{/if*}</a>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
		</div>
	</td></tr>
</table>
{else}
<table class="block_right" width="100%" cellspacing="3" cellpadding="0">
	<tr>
		<th><span>Вход в паспорт</span></th>
	</tr>
	<tr><td style="text-align:center">
		<form method="POST" action="{$res.url_login}" style="margin:0px;">
			<input type="hidden" name="action" value="login" />
			<input type="hidden" name="url" value="{$res.url_current|escape:"quotes"}" />
			<table width="80%" align="center" cellpadding="0" cellspacing="0">
				<tr><td class="menu"><b>E-Mail</b></td><td><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td></tr>
				<tr><td class="menu"><b>Пароль</b></td><td><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td></tr>
			</table>
			<div align="center">
			<table cellpadding="0" cellspacing="0"><tr>
			<td width="10px"></td>
			<td align="right"><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
			<td align="left">&nbsp;<label title="Запомнить меня на этом компьютере" for="login_form_remember" class="bl_title"><b>запомнить</b></label></td>
			<td align="left">&nbsp;<input tabindex="1003" type="submit" value="Войти" class="in_submit" /></td>
			<td width="20px"></td>
			</tr></table></div>
			<div class="bl_title"><nobr>
				<a class="ssyl" href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
				<a class="ssyl" href="{$res.url_forgot}">Забыли пароль?</a>
			</nobr></div>
		</form>
	</td></tr>
</table>
{/if}
