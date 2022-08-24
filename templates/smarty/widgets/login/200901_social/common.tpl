<div style="width:240px;text-align:left;margin:2px;padding-left:4px;padding-right:4px;background-color:#cbe2ea">	
	{if $USER->IsAuth()}
		<table border="0" width="100%" cellpadding="0" cellspacing="4">
			<tr>
				<td width="50%" style="border-right:solid 2px #b6cdd5;padding-top:2px" valign="top">
					<a href="{$res.url_svoi}"><img border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></a>
					<div style="margin-top:6px;"><a href="/passport/info.php?id={$USER->ID}" class="t12b" style="color:#487ec6">{$res.showname}</a></div>
				</td>
				<td valign="top">
					<a href="{$res.url_svoi}" class="t9" style="color:#8AA3A6">сообщества</a><br/>
					<a href="{$res.url_search}" class="t9" style="color:#8AA3A6">поиск {$CURRENT_ENV.site.name_people_who|strtolower}</a><br/>
					{if $res.newmessages_count > 0}
						<a href="{$res.url_messages}" class="t9" style="color:red">Новых сообщений: <b>{$res.newmessages_count}</b></a>
					{/if}
					<a href="{$res.url_mypage}" class="t9" style="color:#8AA3A6">моя страница</a><br/>
					<a href="{$res.url_logout}" class="t9" style="color:#8AA3A6">выход</a>
				</td>
			</tr>
		</table>
	{else}
		<form method="POST" action="{$res.url_login}" style="margin:0px">
		<input type="hidden" name="action" value="login" />
		<input id="login_url" type="hidden" name="url" value="{$res.url|escape:"quotes"}" />
		<table border="0" width="100%" cellpadding="0" cellspacing="2">
			<tr>
				<td width="50%" style="padding-top:2px">
					<a href="{$res.url_svoi}"><img border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></a>					
				</td>
				<td width="50%">
					<a href="{$res.url_register}" class="t9" style="color:#8AA3A6">Регистрация</a><br/>
					<a href="{$res.url_forgot}" class="t9" style="color:#8AA3A6">Забыли пароль?</a>
				</td>
			</td>
			<tr>
				<td><input id="login_email" class="in_email" style="width:100%" tabindex="900" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
				<td><input id="login_pswd" class="in_pswd" style="width:100%" tabindex="901" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
			</tr>
			<tr>
				<td valign="middle"><input tabindex="902" type="checkbox" id="login_form_remember" name="remember" value="1" checked="checked" /><label title="Запомнить меня на этом компьютере" for="login_form_remember" class="t9" style="color:#8AA3A6">запомнить</label></td>
				<td><input tabindex="903" type="submit" style="width:100%" value="Войти" class="in_submit" /></td>
			</tr>
		</table>
		</form>
	{/if}
</div>