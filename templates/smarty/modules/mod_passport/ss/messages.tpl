{if $page.message == 'remind_ok'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Пароль успешно изменен!<br>
		<a href="/{$ENV.section}/{$CONFIG.files.get.login.string}">Войти</a>
	</td>
</tr>
</table>

{elseif $page.message == 'remind_link_sent'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		На указанный вами почтовый ящик отправлен секретный код для восстановления пароля.<br/><br/> 
		<a href="/{$ENV.section}/{$CONFIG.files.get.forgot2.string}">Вернуться</a>
	</td>
</tr>
</table>

{elseif $page.message == 'hidden'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Пользователь предпочел скрыть эту страницу.<br/><br/> 
		<a href="javascript:history.go(-1)">Вернуться</a>
	</td>
</tr>
</table>

{elseif $page.message == 'remind_wrong_code'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Введенный вами код не действителен.<br/><br/> 
		<a href="/{$ENV.section}/{$CONFIG.files.get.forgot2.string}?code">Вернуться</a>
	</td>
</tr>
</table>

{elseif $page.message == 'register_ok'}

		Поздравляем Вас с успешной регистрацией!<br/><br/> 
		<span class="button2"><a href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}">Перейти к своей персональной странице</a></span>
	

{elseif $page.message == 'profile_password_ok'}


		Пароль успешно изменен!<br/><br/> 
		<span class="button2"><a href="/{$ENV.section}/{$CONFIG.files.get.profile_password.string}">Вернуться</a></span>


{elseif strpos($page.message, 'profile_')===0}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Данные успешно сохранены!<br/><br/> 
		<span class="button"><a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}"><span class="symbol">«</span> Вернуться назад</a></span>
		&nbsp;&nbsp;&nbsp;<span class="button"><a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}">Моя страница<span class="symbol">»</span></a></span>
		
	</td>
</tr>
</table>

{elseif strpos($page.message, 'announce_')===0}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Данные успешно сохранены!<br/>
		<br/>
		<span class="button"><a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}"><span class="symbol">«</span> Вернуться назад</a></span>
		&nbsp;&nbsp;&nbsp;<span class="button"><a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}">Моя страница<span class="symbol">»</span></a></span>
	</td>
</tr>
</table>

{elseif strpos($page.message, 'mypage_')===0}

		Данные успешно сохранены!<br/><br/>
		<span class="button2"><a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}"><span class="symbol">«</span> Вернуться назад</a></span>
		&nbsp;&nbsp;&nbsp;<span class="button2"><a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}">Моя страница<span class="symbol">»</span></a></span>


{elseif $page.message == 'im_new_sent'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ваше сообщение отправлено!<br>
		<a href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}">Вернуться</a>
	</td>
</tr>
</table>

{elseif $page.message == 'activation_ok'}

		Активация прошла успешно!<br/><br/> 
		<span class="button2"><a href="/{$ENV.section}/{$CONFIG.files.get.login.string}">Войти</a></span>

{elseif $page.message == 'activation'}

		На E-mail, который Вы указали, отправлено письмо с дальнейшими инструкциями по активации.<br>
		Вы должны активировать свою учетную запись в течение 48 часов.
		<br/><br/> 
		<span class="button2"><a href="/{$ENV.section}/activation.php">Активация</a></span>
	

{elseif $page.message == 'delete_profile_ok'}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>&nbsp;</span></td></tr>
<tr>
	<td>
		Ваша учетная запись удалена!<br/><br/> 
		<a href="/{$ENV.section}/{$CONFIG.files.get.register.string}">Регистрация</a>
	</td>
</tr>
</table>


{/if}
