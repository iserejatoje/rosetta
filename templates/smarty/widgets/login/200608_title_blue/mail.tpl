{if $USER->IsAuth()}
<div class="login_form login_form_autorised" style="padding:0px; margin:4px; width:100%; height:45px;">
	<div class="welcome">
		Здравствуйте, {$res.showname}!
	</div>
	{if $CURRENT_ENV.regid==2}<a href="/svoi/"><img border="0" height="11" width="92" src="/_img/design/200608_title_blue/logo_svoi/s.{$CURRENT_ENV.regid}.gif" alt="Живая Уфа" style="margin:4px" /></a>{else}<br/>{/if}
	<div class="links">
		<a href="/mail/">войти в почту</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="{$res.url_logout}">выход</a>
	</div>
</div>
{else}
			<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td><input id="login_email" class="in_email" tabindex="900" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
					<td><input id="login_pswd" class="in_pswd" tabindex="901" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
				</tr>
				<tr>
					<td><input tabindex="902" type="checkbox" id="login_form_remember" name="remember" class="remember" value="1" checked="checked"/><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="remember">запомнить</label></td>
					<td><input tabindex="903" type="submit" value="Войти" class="in_submit" /></td>
				</tr>
			</table>
			<div class="links"><nobr><a href="{$res.url_register}">Регистрация</a>&nbsp;&nbsp;<a href="{$res.url_forgot}">Забыли пароль?</a></nobr></div>
{/if}