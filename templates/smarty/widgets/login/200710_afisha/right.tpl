{if $USER->IsAuth()}
<div class="login_form">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="2"><img src="/_img/design/200710_afisha/x.gif" height="2" width="1" alt="" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<font class="zag3">Здравствуйте, {$res.showname}</font>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td bgcolor="#80B4D9"><img src="/_img/design/200710_afisha/rast.gif" width="1" height="3" alt="" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<div class="links">
		<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><b><a href="{$res.url_messages}">у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count==1}новое{else}новых{/if} сообщени{if $res.newmessages_count==1}е{else}я{/if*}</a></b>			
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
	</div>
	<div class="gor-padd2">&nbsp;</div>
</div>
{else}
<div class="login_form">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<td colspan="2"><img src="/_img/design/200710_afisha/x.gif" height="2" width="1" alt="" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<font class="zag3">Вход в паспорт</font>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td bgcolor="#80B4D9"><img src="/_img/design/200710_afisha/rast.gif" width="1" height="3" alt="" /></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<form method="POST" action="{$res.url_login}" style="margin:0px;">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$res.url_current|escape:"quotes"}" />
		<table width="80%" align="center">
			<tr><td><b>E-Mail</b></td><td><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td></tr>
			<tr><td><b>Пароль</b></td><td><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td></tr>
		</table>
		<div align="center"><table><tr>
		<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
		<td>&nbsp;<label title="Запомнить меня на этом компьютере" for="login_form_remember"><b>запомнить</b></label></td>
		<td>&nbsp;<input tabindex="1003" type="submit" value="Войти" class="in_submit" style="width:50px"/></td>
		</tr></table></div>
		<div align="center"><nobr>
			<a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
			<a href="{$res.url_forgot}">Забыли пароль?</a>
		</nobr></div>
	</form>
	<div class="gor-padd2">&nbsp;</div>
</div>
{/if}