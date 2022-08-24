{if $page.message == 'remind_ok'}

	<div class = "content_margings">
		<p>Пароль успешно изменен!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.login.string}" class = "orange_link">Войти</a>
	</div>

{elseif $page.message == 'remind_link_sent'}

	<div class = "content_margings">
		<p>На указанный вами почтовый ящик отправлен секретный код для восстановления пароля.</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.forgot2.string}" class = "orange_link">Вернуться</a>
	</div>

{elseif $page.message == 'hidden'}

	<div class = "content_margings">
		<p>Пользователь предпочел скрыть эту страницу.</p>
		<a href="javascript:history.go(-1)" class = "orange_link">Вернуться</a>
	</div>

{elseif $page.message == 'remind_wrong_code'}

	<div class = "content_margings">
		<p>Введенный вами код не действителен.</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.forgot2.string}?code" class = "orange_link">Вернуться</a>
	</div>

{elseif $page.message == 'register_ok'}

	<div class = "content_margings">
		<p>Поздравляем Вас с успешной регистрацией!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.mypage.string}" class = "orange_link">Перейти к своей персональной странице</a>
	</div>

{elseif $page.message == 'profile_password_ok'}

	<div class = "content_margings">
		<p>Пароль успешно изменен!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.profile_password.string}" class = "orange_link">Вернуться</a>
	</div>

{elseif strpos($page.message, 'profile_')===0}

	<div class = "content_margings">
		<p>Данные успешно сохранены!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}" class = "orange_link orange">«&nbsp;Вернуться назад</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}" class = "orange_link orange">Моя страница>&nbsp;»</a
	</div>

{elseif strpos($page.message, 'announce_')===0}

	<div class = "content_margings">
		<p>Данные успешно сохранены!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}" class = "orange_link">«&nbsp;Вернуться назад</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}" class = "orange_link">Моя страница&nbsp;»</a>
	</div>

{elseif strpos($page.message, 'mypage_')===0}

	<div class = "content_margings">
		<p>Данные успешно сохранены!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get[$page.message].string}" class = "orange_link">«&nbsp;Вернуться назад</a>
		&nbsp;&nbsp;&nbsp;
		<a href="/{$ENV.section}/{$CONFIG.files.get.mypage_person.string}" class = "orange_link">Моя страница&nbsp;»</a>
	</div>

{elseif $page.message == 'im_new_sent'}

	<div class = "content_margings">
		<p>Ваше сообщение отправлено!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.im_messages.string}" class = "orange_link">Вернуться</a>
	</div>

{elseif $page.message == 'activation_ok'}

	<div class = "content_margings">
		<p>Активация прошла успешно!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.login.string}" class = "orange_link">Войти</a>
	</div>

{elseif $page.message == 'activation'}

	<div class = "content_margings">
		<p>На E-mail, который Вы указали, отправлено письмо с дальнейшими инструкциями по активации.<br>
		Вы должны активировать свою учетную запись в течение 48 часов.</p>
		<a href="/{$ENV.section}/activation.php" class = "orange_link">Активация</a>
	</div>

{elseif $page.message == 'delete_profile_ok'}
	
	<div class = "content_margings">
		<p>Ваша учетная запись удалена!</p>
		<a href="/{$ENV.section}/{$CONFIG.files.get.register.string}" class = "orange_link">Регистрация</a>
	</div>

{/if}
