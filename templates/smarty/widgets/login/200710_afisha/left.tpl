{if $USER->IsAuth()}
<div class="login_form" style="background-image: url('/_img/design/200710_afisha/backleft.gif');background-color:#1e669d">
	<br/>
	<div class="menu">
		<div class="zag1">Здравствуйте, {$res.showname}</div>
	</div>
	<div class="links">
		<a class="menu" href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;
		<a class="menu" href="{$res.url_logout}">выход</a>
		{if $res.newmessages_count > 0}
			<br/><b><a class="menu" href="{$res.url_messages}">у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count==1}новое{else}новых{/if} сообщени{if $res.newmessages_count==1}е{else}я{/if*}</a></b>
		{/if}
		{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
	</div>
	<div class="gor-padd2">&nbsp;</div>
	<div><img src="/_img/design/200710_afisha/left-niz.gif" width="224" height="12" alt="" /></div>
</div>
{else}
<div class="login_form" style="background-image: url('/_img/design/200710_afisha/backleft.gif');background-color:#1e669d">
	<br>
	<form method="POST" action="{$res.url_login}" style="margin:0px;">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{$res.url_current|escape:"quotes"}" />
		<div class="zag1">Вход в паспорт</div>
		<table width="80%" align="center">
			<tr><td class="menu"><b>E-Mail</b></td><td><input class="txt" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td></tr>
			<tr><td class="menu"><b>Пароль</b></td><td><input class="txt" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td></tr>
		</table>
		<div><table><tr>
				<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked" /></td>
				<td><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="menu"><b>запомнить</b></label></td>
				<td align="left"><input tabindex="1003" type="submit" value="Войти" class="in_submit" style="width:50px" /></td>
				</tr>
			  </table></div>
		<div><nobr>
			<a class="menu" href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;
			<a class="menu" href="{$res.url_forgot}">Забыли пароль?</a>
		</nobr></div>
	</form>
	<div class="gor-padd2">&nbsp;</div>
	<div><img src="/_img/design/200710_afisha/left-niz.gif" width="224" height="12" alt="" /></div>
</div>
{/if}