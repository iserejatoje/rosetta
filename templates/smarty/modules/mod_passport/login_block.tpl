{if $USER->IsAuth()}
<div class="login_form">
	<div class="welcome">
	{assign var="profile_general" value=$USER->Profile.general}
		Здравствуйте, {if $profile_general.firstname!=''}{$profile_general.firstname}{if $profile_general.midname!=''} {$profile_general.midname}{elseif $profile_general.lastname!=''} {$profile_general.lastname}{/if}{else}{$USER->NickName}{/if}!
	</div>
	<div class="links">
		<a href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}">моя страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		{*<a href="/{$ENV.section}/{$CONFIG.files.get.profile.string}">моя страница</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*}
		<a href="/{$ENV.section}/{$CONFIG.files.get.logout.string}?url={if isset($CURRENT_ENV.passport.redirect_logout)}{$CURRENT_ENV.passport.redirect_logout|escape:"url"}{else}{$smarty.server.REQUEST_URI|escape:"url"}{/if}">выход</a>
		<br>
		<div>
			<a href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}">{if $res.im.incoming_new > 0}<font color="red">у вас {$res.im.incoming_new} нов{word_for_number number=$res.im.incoming_new first="ое" second="ых" third="ых"} сообщен{word_for_number number=`$res.im.incoming_new first="ие" second="ия" third="ий"}{*if $res.im.incoming_new==1}новое{else}новых{/if} сообщени{if $res.im.incoming_new==1}е{else}я{/if*}</font>{else}мои сообщения{/if}</a>
			{if $res.im.incoming_new > 0}<a href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}"><img src="/_img/modules/passport/new.gif" width="20" height="10" border="0" style="vertical-align:middle" /></a>{/if}
		</div>
	</div>
</div>
{else}
<div class="login_form">
	{*<form method="POST" action="{if isset($page.form.ssl_url)}{$page.form.ssl_url}{else}/{$ENV.section}/{$CONFIG.files.get.login.string}{/if}">*}
	<form method="POST" action="/{$ENV.section}/{$CONFIG.files.get.login.string}">
		<input type="hidden" name="action" value="login" />
		<input type="hidden" name="url" value="{if isset($CURRENT_ENV.passport.redirect_login)}{$CURRENT_ENV.passport.redirect_login|escape:"url"}{else}{$smarty.server.REQUEST_URI|escape:"url"}{/if}" />
<div class="login_form_title">Вход в паспорт</div>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><input class="in_email" tabindex="1000" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
		<td><input class="in_pswd" tabindex="1001" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
	</tr>
	<tr>
		<td><input tabindex="1002" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label></td>
		<td><input tabindex="1003" type="submit" value="Войти" class="in_submit" /></td>
	</tr>
</table>
<div class="links"><nobr>	
<a href="/{$ENV.section}/{$CONFIG.files.get.register.string}?url={if isset($smarty.get.url)}{$smarty.get.url|escape:"url"}{else}{if isset($CURRENT_ENV.passport.redirect_login)}{$CURRENT_ENV.passport.redirect_login|escape:"url"}{else}{$smarty.server.REQUEST_URI|escape:"url"}{/if}{/if}">Регистрация</a>&nbsp;&nbsp;
<a href="/{$ENV.section}/{$CONFIG.files.get.forgot.string}?url={if isset($CURRENT_ENV.passport.redirect_login)}{$CURRENT_ENV.passport.redirect_login|escape:"url"}{else}{$smarty.server.REQUEST_URI|escape:"url"}{/if}">Забыли пароль?</a>
</nobr></div>
</form>
</div>
{/if}