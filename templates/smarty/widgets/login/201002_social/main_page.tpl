<div class="svoi">

	{if $USER->IsAuth()}
		<table cellspacing="0" cellpadding="4" class="table">
		<tr>
			<td class="panel-1">
				<a href="{$res.url_svoi}"><img border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></a><br />
				<a href="/passport/info.php?id={$USER->ID}" class="user-name">{$res.showname}</a>
			</td>
			<td>
				<a href="{$res.url_svoi}">сообщества</a><br />
				<a href="{$res.url_search}">поиск {$CURRENT_ENV.site.name_people_who|strtolower}</a><br />
				{if $res.newmessages_count > 0}
					<a href="{$res.url_messages}" class="redtext">Новых сообщений: <span class="count">{$res.newmessages_count}</span></a><br />
				{/if}
				<a href="{$res.url_mypage}">моя страница</a><br />
				<a href="{$res.url_logout}">выход</a>
			</td>
		</tr>
		</table>
	{else}
		<div class="tabs">
			<div id="tab-svoi" class="tab-svoi-active" OnClick="$('.tabs > *').removeClass('tab-mail-active');$('.tabs > *').addClass('tab-svoi-active');$('#login_url').val('{$res.url_svoi}');"><img id="svoi-btn" border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></div>
			<div id="tab-divider" class="tab-svoi-active"></div>
			<div id="tab-mail" class="tab-svoi-active" onclick="$('.tabs > *').removeClass('tab-svoi-active');$('.tabs > *').addClass('tab-mail-active');$('#login_url').val('/mail/');"><img id="mail-btn" border="0" src="/_img/design/200901_social/login_form_mail_btn.gif" alt="Почта" /></div>
		</div>
	
		<form method="POST" action="{$res.url_login}">
		<input type="hidden" name="action" value="login" />
		<input id="login_url" type="hidden" name="url" value="{$res.url|escape:"quotes"}" />
		<table cellspacing="0" cellpadding="4" class="table">
		<tr class="login">
			<td><input id="login_email" class="in_email" tabindex="900" type="text" name="email" value="E-mail" title="E-mail" OnFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" OnBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
			<td><input id="login_pswd" class="in_pswd" tabindex="901" type="password" name="password" value="Пароль" title="Пароль" OnFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" OnBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
		</tr>
		<tr>
			<td>
				<a href="{$res.url_register}" class="register">Регистрация</a><br />
				<input tabindex="902" type="checkbox" id="login_form_remember" name="remember" value="1" checked="checked" /><label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label>
			</td>
			<td>
				<input tabindex="903" type="submit" value="Войти" class="in_submit" /><br/>
				<a href="{$res.url_forgot}">Забыли пароль?</a>
			</td>
		</tr>
		</table>
		</form>
	{/if}
</div>