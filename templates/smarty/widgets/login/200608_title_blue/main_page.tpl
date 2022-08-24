<style>
{literal}
#b_svoi {
	position: relative; border: 1px solid #ff0000;
}
#b_svoi * {
	font-size: 10px;
	color: #426B9B;
}
#b_svoi A, #b_svoi A:hover, #b_svoi A:visited {
	font-size: 10px;
	color: #426B9B;
}
#b_svoi .line_1 {
	position: relative; background-color: #d3dfee;
}
#b_svoi .logo {
	position: relative; float: left; background-color: #d3dfee;
}
#b_svoi .line_2 {
	position: relative; background-color: #e9eef5; font-size: 10px; padding-top: 4px; padding-bottom: 4px;
}
#b_svoi .left_block {
	position: relative; float: left;
}

#b_svoi .in_email {
	width:115px;
}
#b_svoi .in_pswd {
	width:75px;
}
#b_svoi .in_submit {
}
#b_svoi .remember {
}
#b_svoi .welcome {
	font-size:11px; font-weight:bold; float:left;
}
#b_svoi .links {
	font-size:11px; text-align:center;
}
{/literal}
</style>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>

<div id="b_svoi">


{if $USER->IsAuth()}

<div class="line_1">
	<div class="logo" style="width: 170px;">&nbsp;<a href="/svoi/"><img src="/_img/design/200608_title_blue/logo_svoi/m.{$CURRENT_ENV.regid}.gif" width="105" height="30" border="0" alt="Живая Уфа" title="Живая Уфа" /></a></div>
	<div class="left_block">
		<div class="welcome" style="position: relative;">Здравствуйте, {$res.showname}!</div>
		<div class="links" style="position: relative; clear:left;">
			<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="{$res.url_logout}">выход</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="{$res.url_messages}">{if $res.newmessages_count > 0}<font color="red">у вас {$res.newmessages_count} {if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if}</font>{else}мои сообщения{/if}</a>
			{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
		</div>
	</div>
	<div style="position: relative; clear:both;"></div>
</div>

{else}

	<div class="line_1">
	<div class="logo" style="width: 170px;">&nbsp;<a href="/svoi/"><img src="/_img/design/200608_title_blue/logo_svoi/m.{$CURRENT_ENV.regid}.gif" width="105" height="30" border="0" alt="Живая Уфа" title="Живая Уфа" /></a></div>
	<form method="POST" action="{$res.url_login}" style="margin:0px; padding-top: 5px;">
	<input type="hidden" name="action" value="login" />
	<input id="login_url" type="hidden" name="url" value="{$res.url}" />
		<div class="left_block" style="margin-right: 3px;">
		<input id="login_email" class="in_email" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" />
		</div>
		<div class="left_block" style="margin-right: 3px;">
		<input id="login_pswd" class="in_pswd" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" />
		</div>
		<div class="left_block" style="margin-right: 3px;">
		<input tabindex="1003" type="submit" value="Войти" class="in_submit" />
		</div>
		<div class="left_block">
		<input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label>
		</div>
	</form>
	<div style="position: relative; clear:both;"></div>
	</div>

{/if}

	<div class="line_2">
		<div class="left_block" style="width: 170px;">&nbsp;<a href="/help/live/"><b>Что такое "Живая У<font style="color:red">ф</font>а"?</b></a></div>
		{if !$USER->IsAuth()}
		<div class="left_block" style="margin-right: 10px;">
			<a href="/passport/register.php" style="color: #ff0000;"><b><font style="color: #ff0000;">Регистрация</font></b></a>
		</div>
		{/if}
		<div class="left_block" style="margin-right: 10px;">
			Сообществ: <a href="/svoi/">{$res.community_count|number_format:0:'':' '}</a>
		</div>
		<div class="left_block" style="margin-right: 10px;">
			Участников: <a href="/passport/users_online.php">{$res.users_count|number_format:0:'':' '}</a>
		</div>
		<div style="position: relative; clear:both;"></div>
	</div>
</div>

</td>
</tr>
</table>


{*
{if $USER->IsAuth()}
<div class="login_form login_form_autorised">
	<div class="welcome">
		Здравствуйте, {$res.showname}!
	</div>
	<a href="/svoi/"><img border="0" height="11" width="92" src="/_img/design/200608_title_blue/logo_svoi/s.{$CURRENT_ENV.regid}.gif" alt="Живая Уфа" style="padding:4px" /></a>
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
<form method="POST" action="{$res.url_login}" style="margin:0px">
	<div class="login_form">
		<input type="hidden" name="action" value="login" />
		<input id="login_url" type="hidden" name="url" value="{$res.url}" />
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td id="btn_to_passport" class="login_form_title active_button" title="Вход в паспорт" width="100%" onclick="login_form.switch_form('passport','{$res.url}'); $('#login_email').focus();"><img border="0" height="11" width="92" src="/_img/design/200608_title_blue/logo_svoi/s.{$CURRENT_ENV.regid}.gif" alt="Вход в паспорт"></td>
			<td id="btn_divider" class="login_form_title btn_divider_left"><img src="/_img/x.gif" border="0" width="10" height="16" /></td>
			<td id="btn_to_mail" class="login_form_title inactive_button" title="Вход в почту" onclick="login_form.switch_form('mail','{$res.url}'); $('#login_email').focus();"><img border="0" height="11" width="62" src="/_img/design/200608_title_blue/login_form/post-enter.gif" alt="Вход в почту"></td>
		</tr>
		</table>
		<table border="0" width="100%" cellpadding="4" cellspacing="0" class="form">
		<tr><td>
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td><input id="login_email" class="in_email" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
					<td><input id="login_pswd" class="in_pswd" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
				</tr>
				<tr>
					<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label></td>
					<td><input tabindex="1003" type="submit" value="Войти" class="in_submit" /></td>
				</tr>
			</table>
			<div class="links"><nobr><a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;<a href="{$res.url_forgot}">Забыли пароль?</a></nobr></div>
		</td></tr>
		</table>
	</div>
</form>
{/if}

*}