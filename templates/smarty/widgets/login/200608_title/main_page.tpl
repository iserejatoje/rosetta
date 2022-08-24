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
	font-size:11px; font-weight:bold;
}
#b_svoi .links {
	font-size:11px;
}
{/literal}
</style>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>

<div id="b_svoi">


{if $USER->IsAuth()}

<div class="line_1" style="width: 100%; height: 20px;">
	<div class="left_block" style="width: 100%;">
		<div class="welcome" style="position: relative; padding-left: 5px; padding-top: 3px;">Здравствуйте, {$res.showname}!</div>
	</div>
	<div style="position: relative; clear:both;"></div>
</div>

{else}
	<div class="line_1" style="padding-left: 5px;">
	<div class="left_block" align="left" style="width: 90px; padding-top: 6px;"><b>Вход в паспорт</b></div>
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

	<div class="line_2" style="padding-left: 5px;">
		{if !$USER->IsAuth()}
		<div class="left_block" style="margin-right: 10px;">
			<a href="/passport/register.php" style="color: #ff0000;"><b><font style="color: #ff0000;">Регистрация</font></b></a>
		</div>
		{else}
		<div class="links" style="position: relative; float:right;">
			<a href="{$res.url_mypage}">моя страница</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="{$res.url_messages}">{if $res.newmessages_count > 0}<font color="red">у вас {$res.newmessages_count} нов{word_for_number number=$res.newmessages_count first="ое" second="ых" third="ых"} сообщен{word_for_number number=$res.newmessages_count first="ие" second="ия" third="ий"}
			{*if $res.newmessages_count%10==1 && $res.newmessages_count!=11}новое{else}новых{/if} сообщени{if $res.newmessages_count%10==1 && $res.newmessages_count!=11}е{else}я{/if*}</font>{else}мои сообщения{/if}</a>{if $res.newmessages_count > 0}<a href="{$res.url_messages}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;
			<a href="{$res.url_logout}">выход</a>&nbsp;&nbsp;&nbsp;
		</div>
		{/if}
		<div class="left_block" style="margin-right: 10px;">
			Участников: <a href="/passport/users_online.php">{$res.users_count|number_format:0:'':' '}</a>
		</div>
		<div style="position: relative; clear:both;"></div>
	</div>
</div>

</td>
</tr>
</table>