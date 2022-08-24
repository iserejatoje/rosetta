<style>
{literal}
#b_svoi {
	position: relative;
	width: 240px;
	text-align: left;
	margin: 2px;
	background-color: #cbe2ea;
}
#b_svoi #panel-1 {
	border-right: solid 2px #b6cdd5;
	padding-top:2px;
	width: 50%;
}
#b_svoi div#panel-1 {
	margin-top: 6px;
}
#b_svoi A, label {
	color: #8aa3a6;
	font-family: helvetica,Arial Cyr,Verdana,Tahoma;
	font-size: 11px;
	font-weight: normal;
}
#b_svoi A.user-name {
	color:#487ec6;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:12px;
	font-weight:bold;
}
#b_svoi A.hot {
	color: red;
}
#b_svoi #tabs {
	width: 100%;
	height: 21px;
}
#b_svoi #tab-svoi {
	position: absolute;
	width: 155px;				
	height: 21px;
	cursor: pointer;
}
#b_svoi #tab-mail {
	position: absolute;
	left: 176px;
	width: 64px;
	height: 21px;
	text-align: right;
	cursor: pointer;
}
#b_svoi #svoi-btn {
	margin-top: 2px;
	margin-left: 2px;
}
#b_svoi #mail-btn {
	margin-top:5px;
	margin-right:5px;
}
#b_svoi #tab-divider {
	position: absolute;
	left: 155px;
	width: 21px;
	height: 21px;
	background-image: url(/_img/design/200901_social/login_form_divider.gif);
}
#b_svoi #tab-mail.tab-svoi-active,
#b_svoi #tab-svoi.tab-mail-active {
	background-image: url(/_img/design/200901_social/login_form_background_active.gif);
}
#b_svoi #tab-divider.tab-mail-active {
	background-position: -21px 0;
}
{/literal}
</style>

<div id="b_svoi">	

	{if $USER->IsAuth()}
		<table border="0" width="100%" cellpadding="0" cellspacing="4">
			<tr>
				<td id="panel-1" valign="top">
					<a href="{$res.url_svoi}"><img border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></a>
					<div><a href="/passport/info.php?id={$USER->ID}" class="user-name">{$res.showname}</a></div>
				</td>
				<td valign="top">
					<a href="{$res.url_svoi}">сообщества</a><br/>
					<a href="{$res.url_search}">поиск {$CURRENT_ENV.site.name_people_who|strtolower}</a><br/>
					{if $res.newmessages_count > 0}
						<a href="{$res.url_messages}" class="hot">Новых сообщений: <b>{$res.newmessages_count}</b></a>
					{/if}
					<a href="{$res.url_mypage}">моя страница</a><br/>
					<a href="{$res.url_logout}">выход</a>
				</td>
			</tr>
		</table>
	{else}
		<div id="tabs">
			<div id="tab-svoi" class="tab-svoi-active" onclick="$('#tabs > *').removeClass('tab-mail-active');$('#tabs > *').addClass('tab-svoi-active');$('#login_url').val('{$res.url_svoi}');"><img id="svoi-btn" border="0" src="/_img/design/200901_social/logo_title/small.{$CURRENT_ENV.site.domain}.gif" /></div>
			<div id="tab-divider" class="tab-svoi-active"></div>
			<div id="tab-mail" class="tab-svoi-active" onclick="$('#tabs > *').removeClass('tab-svoi-active');$('#tabs > *').addClass('tab-mail-active');$('#login_url').val('/mail/');"><img id="mail-btn" border="0" src="/_img/design/200901_social/login_form_mail_btn.gif" alt="Почта" /></div>
		</div>
	
		<form method="POST" action="{$res.url_login}" style="margin:0px">
		<input type="hidden" name="action" value="login" />
		<input id="login_url" type="hidden" name="url" value="{$res.url|escape:"quotes"}" />
		<table border="0" width="100%" cellpadding="0" cellspacing="2">
			<tr>
				<td style="padding:2px"><input id="login_email" class="in_email" style="width:100%" tabindex="900" type="text" name="email" value="E-mail" title="E-mail" onFocus="{literal}if (this.value=='E-mail'){this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='E-mail'}{/literal}" /></td>
				<td style="padding:2px"><input id="login_pswd" class="in_pswd" style="width:100%" tabindex="901" type="password" name="password" value="Пароль" title="Пароль" onFocus="{literal}if (this.value=='Пароль'){ this.value='';}{/literal}" onBlur="{literal}if (this.value==''){this.value='Пароль';}{/literal}" /></td>
			</tr>
			<tr>
				<td valign="middle">
					<a href="{$res.url_register}" class="t9" style="margin-left:4px;color:#8AA3A6"><b>Регистрация</b></a><br/>
					<input tabindex="902" type="checkbox" id="login_form_remember" name="remember" value="1" checked="checked" /><label title="Запомнить меня на этом компьютере" for="login_form_remember">запомнить</label>
				</td>
				<td>
					<input tabindex="903" type="submit" style="width:100%" value="Войти" class="in_submit" /><br/>
					<a href="{$res.url_forgot}">Забыли пароль?</a>
				</td>
			</tr>
		</table>
		</form>
	{/if}
</div>