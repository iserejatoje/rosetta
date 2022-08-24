<div style="padding-left:230px;">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>Помощь</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>
</div>

<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0">
<tr><td>


{if $page.message=='settings_thebat'}



<p><b>Настройка The Bat</b></p>

<p>Для добавления нового почтового ящика вибираем в меню &laquo;Ящик&raquo; пункт &laquo;Новый почтовый ящик&raquo;.</p>
<p align="center"><img src="/_img/modules/mail/help/thebat/wizard1.png" width="431" height="382" alt="Указание названия почтового ящика"></p>
<OL>
<li>Ввести название ящика,<br>
перейти далее, нажав соответствующую кнопку. </p>
<p align="center"><img src="/_img/modules/mail/help/thebat/wizard2.gif" width="431" height="382" alt="Указание адреса почтового ящика"></p>
<li>Указать адрес электронной почты,<br>
перейти далее. </p>
<p align="center"><img src="/_img/modules/mail/help/thebat/wizard3.gif" width="431" height="382" alt="Указание параметров соединения"></p>
<li>Указать протокол для доступа к почтовому серверу &laquo;POP3&raquo;<br>
<li>Указать адрес сервера входящей почты &laquo;pop3.{$CONFIG.default_mail_service}&raquo;<br>
<li>Указать адрес сервера исходящей почты &laquo;smtp.{$CONFIG.default_mail_service}&raquo;<br>
<li>Отметить пункт &laquo;Мой сервер SMTP требует аутентификацию&raquo;, <br>
перейти далее. </p>
<p align="center"><img src="/_img/modules/mail/help/thebat/wizard4.gif" width="431" height="382" alt="Указание пароля"></p>
<li>Задать имя пользователя, указанное при регистрации, вместе с @{$CONFIG.default_mail_service}<br>
<li>Задать пароль, указанный при регистрации,<br>
перейти далее.</p>
<p align="center"><img src="/_img/modules/mail/help/thebat/wizard5.png" width="431" height="382" alt="Указание дополнительных настроек"></p>
<li>Выбрать пункт &laquo;нет&raquo;,<br>
нажать кнопку &laquo;готово&raquo;. </p>
</OL>





{elseif $page.message=='settings_outlook'}



<p><b>Настройка Outlook</b></p>

<p>Для настройки почтового ящика нужно воспользоваться мастером, при первом запуске программы мастер будет показан автоматически, либо его можно запустить из меню Сервис -&gt; Учетные записи электронной почты...</p>
<p align="center"><img src="/_img/modules/mail/help/outlook/wizard1.png" width="575" height="444" alt="Указание названия почтового ящика"></p>
<OL>
<li> Выбрать &laquo;добавить новую учетную запись электронной почты&raquo;<br>
и перейти  далее.
<p align="center"><img src="/_img/modules/mail/help/outlook/wizard2.png" width="575" height="444" alt="Указание типа сервера"></p>
<li> Здесь выбрать &laquo;POP3&raquo; для типа сервера<br>
и перейти  далее.
<p align="center"><img src="/_img/modules/mail/help/outlook/wizard3.gif" width="575" height="444" alt="Указание параметров соединения"></p>
<li> Ввести свое имя для указания в поле &laquo;От&raquo;.<br>
<li> Ввести адрес электронной почты.<br>
<li> Ввести имя пользователя, указанное при регистрации вместе с @{$CONFIG.default_mail_service}.<br>
<li> Ввести пароль, указанный при регистрации.<br>
<li> Указать адрес сервера входящей почты &laquo;pop3.{$CONFIG.default_mail_service}&raquo;.<br>
<li> Указать адрес сервера исходящей почты &laquo;smtp.{$CONFIG.default_mail_service}&raquo;.<br>
<li> Нажать кнопку  &laquo;Другие настройки...&raquo; для указания дополнительных параметров<br>
и перейти  далее.
<p align="center"><img src="/_img/modules/mail/help/outlook/wizard3_a.png" width="367" height="463" alt="Указание параметров соединения"> </p>
<li> Выбрать закладку &laquo;Сервер исходящей почты&raquo;<br>
<li> Отметить пункт &laquo;SMTP-серверу требуется проверка подлинности&raquo; и нажать &laquo;OK&raquo;</p>
</OL>




{elseif $page.message=='settings_outlookexpress'}



<p><b>Настройка Outlook Express</b></p>

<p>Для настройки почтового ящика нужно воспользоваться мастером, при первом запуске программы мастер будет показан автоматически, либо его можно запустить из меню Сервис -&gt; Учетные записи..., в этом окне надо выбрать добавить-&gt;Почта... </p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/wizard1.png" width="503" height="387" alt="Указание имени"></p>
<OL>
<li> Ввести свое имя, которое будет указано в поле &laquo;От&raquo; ваших писем,<br>
и перейти  далее. </p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/wizard2.png" width="503" height="387" alt="Указание адреса"></p>
<li> Ввести имя своего почтового ящика,<br>
и перейти  далее.</p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/wizard3.gif" width="503" height="387" alt="Указание параметров соединения"></p>
<li> В выпадающем списке   выбрать пункт &laquo;POP3&raquo;.<br>
<li> Задать адрес для сервера входящих сообщений &laquo;pop3.{$CONFIG.default_mail_service}&raquo;.<br>
<li> Задать адрес для сервера исходящих сообщений &laquo;smtp.{$CONFIG.default_mail_service}&raquo;,<br>
и перейти  далее.</p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/wizard4.gif" width="503" height="387" alt="Указание параметров соединения"></p>
<li> Задать имя пользователя, указанное при регистрации вместе с @{$CONFIG.default_mail_service}.<br>
<li> Задать пароль, указанный при регистрации<br>
и перейти  далее, затеи нажмите &laquo;Готово&raquo; в следующем окне. </p>
<p>Теперь нужно указать дополнительные настройки,  чтобы была возможность отправлять почту, используя Outlook Express. Для этого заходим в учетные записи через меню Сервис -&gt; Учетные записи...</p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/prop1.gif" width="503" height="310" alt="Указание параметров соединения"></p>
<li> Выбрать свою учетную запись (показывается имя сервера исходящих сообщений, в данном случае &laquo;pop3.{$CONFIG.default_mail_service}&raquo; и нажать кнопку &laquo;свойства&raquo;.</p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/prop2.gif" width="389" height="445" alt="Указание параметров соединения"> </p>
<li> Выбрать закладку &laquo;Серверы&raquo;.<br>
<li> Отметить пункт &laquo;Проверка подлинности пользователя&raquo;.<br>
<li> Зайти в настройки.</p>
<p align="center"><img src="/_img/modules/mail/help/outlookexpress/prop3.png" width="354" height="238" alt="Указание параметров соединения"> </p>
<li> Выбрать пункт &laquo;Как на сервер входящей почты&raquo;.</p>
</OL>




{else}



<OL>
<li><a href="#pop">Как принимать/отправлять письма почтовым клиентом(Outlook, The bat и т.п.)</a>
<li><a href="#lostpass">Я забыл свой пароль</a>
<li><a href="#lostemail">Я забыл имя своего почтового ящика</a>
<li><a href="#badses">Я захожу в свой почтовый ящик, но при попытке прочитать письма появляется ошибка "Вы не авторизованы"</a>
<li><a href="#fullmbox">У меня переполнен ящик</a>
<li><a href="#fullmbox2">Я удалил все письма и очистил корзину, а ящик все равно переполнен</a>
<li><a href="#notincom">Ко мне не приходит почта</a>
<li><a href="#cantread">Не могу прочитать пришедшие письма</a>
<li><a href="#chpass">Как сменить пароль и/или вопрос-подсказку</a>
<li><a href="#someuse">Кто-то пользуется моим почтовым ящиком</a>
<li><a href="#rmmbox">Как удалить свой почтовый ящик</a>
<li><a href="#rename">Как переименовать свой почтовый ящик</a>
{*
<li><a href="#nospam">Как защитить свой почтовый ящик от СПАМА</a>
<li><a href="#nospam">Можно-ли автоматически сортировать входящие письма</a>
<li><a href="#create">Я уже несколько раз отправлял на проверку свой IP-адрес, но все равно не могу получить доступ к регистрации почтового ящика.</a>
*}
<li><a href="#quest">Прочитал все разделы помощи, но не нашел ответ на свой вопрос</a>
</OL>

<br><br>

<OL>
<li><a name="pop"><b>Как принимать/отправлять письма почтовым клиентом(Outlook, The bat)</b></a><br>
<p>
	Для чтения/отправки писем почтовым клиентом необходимо произвести соответствующую настройку Вашей почтовой программы.<br>
	Имя пользователя: имя вашего почтового ящика (name@{$CONFIG.default_mail_service})<br>
	Пароль: Ваш пароль к почтовому ящику<br>
	Сервер входящей почты (POP3-сервер): pop3.{$CONFIG.default_mail_service}<br>
	Сервер исходящей почты (SMTP-сервер): smtp.{$CONFIG.default_mail_service}<br>
	Порт: POP3 - 110, SMTP - 25<br>
	В настройках почтовой программы необходимо указать,  что сервер исходящей почты (или сервер SMTP) требует авторизации.
	При отправке писем через наш SMTP-сервер содержимое поля From: должно совпадать с именем почтового ящика.<br>
	Более подробная настройка программ: <a href="/{$ENV.section}/help.settings_outlook.html">Outlook</a>, &nbsp;&nbsp;&nbsp;<a href="/{$ENV.section}/help.settings_outlookexpress.html">OutlookExpress</a>, &nbsp;&nbsp;&nbsp;<a href="/{$ENV.section}/help.settings_thebat.html">The bat</a>
	<br><br>
</p>

<li><a name="lostpass"><b>Я забыл свой пароль</b></a><br>
<p>

	Если Вы забыли свой пароль, то не отчаивайтесь, Вам будет предоставлена возможность его вспомнить.
	Для этого необходимо ответить на тот вопрос, который Вы сами определили при регистрации.
	Обращаем Ваше внимание на то, что ответ должен полностью совпадать с тем, который вы определили при регистрации.<br>
	Если Вы не помните точно вопрос и/или ответ то напишите нам в <a style="cursor: pointer; text-decoration: underline;" title="Открыть" target="ublock" onclick="window.open('/feedback/?from={$ENV.sectionid}', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">форму обратной связи</a>.
	Служба техподдержки{$CONFIG.default_mail_service} ответит вам в течение трех рабочих дней<br><br>
</p>

<li><a name="lostemail"><b>Я забыл имя своего почтового ящика</b></a><br>
<p>

	К сожалению, мы не можем восстановить такую информацию. Обратитесь к тем людям, с которыми Вы вели переписку.
	Возможно они найдут у себя письма от Вас и сообщат Вам точное имя Вашего почтового ящика.<br><br>
</p>

<li><a name="badses"><b>Я захожу в свой почтовый ящик, но при попытке прочитать письма появляется ошибка "Вы не авторизованы"</b></a><br>
<p>

	Скорее всего в вашем браузере выключено использование cookie. Без использования cookie Вы не сможете работать с
	почтой @{$CONFIG.default_mail_service}. За более детальной информацией обратитесь к справочной системе и настройкам вашего браузера.<br>
	Если в Вашем браузере все настроено как следует, значит для выхода в Интернет Вы используете прокси-сервер и он
	некорректно обрабатывает cookies. Если есть возможность, попробуйте выходить в Интернет без прокси-сервера и/или
	обратитесь с системному администратору используемого прокси-сервера.<br><br>
</p>

<li><a name="fullmbox"><b>У меня переполнен ящик</b></a><br>
<p>

	Объем почтового ящика, предоставляемого @{$CONFIG.default_mail_service} составлят 10 Мб. При превышении этого лимита Вы не сможете получать
	новые письма, пока не освободите место. Для этого переместите старые и ненужные письма в корзину, и после этого очистите корзину.<br><br>
</p>

<li><a name="fullmbox2"><b>Я удалил все письма и очистил корзину, а ящик все равно переполнен</b></a><br>
<p>

	В папке "ОТПРАВЛЕННЫЕ" сохраняются копии всех писем, которые Вы отправляли. При подсчете объема Вашего почтового ящика
	они тоже учитываются. Поэтому не забывайте периодически удалять письма из этой папки.<br><br>
</p>

<li><a name="notincom"><b>Ко мне не приходит почта</b></a><br>
<p>

	Если у Вас переполнен почтовый ящик, то Вы не сможете принимать письма, пока не освободите достаточно места для их приема.<br>
	Если места в Вашем ящике достаточно, значит отправитель ошибается при вводе Вашего почтового адреса. Свяжитесь с ним
	и уточните Ваш почтовый адрес, на который он отправляет письмо.<br>Так же, иногда, в сети Интернет случаются "пробки", в которых
	могут застревать письма, адресованные Вам.<br><br>
</p>

<li><a name="cantread"><b>Не могу прочитать пришедшие письма</b></a><br>
<p>

	Если вместо русских букв Вы видите непонятную абракадабру, то Вам необходимо настроить русские шрифты в используемом браузере.<br>
	Если же Вы видите русские буквы, но они представляют собой нечитаемый текст, попробуйте изменить используемую кодировку в Вашем браузере.<br>
	Если Вы не можете прочитать только одно письмо, то согласуйте используемые кодировки с отправителем.<br><br>
</p>

<li><a name="chpass"><b>Как сменить пароль и/или вопрос-подсказку</b></a><br>
<p>
Если Вы хотите сменить пароль на почтовый ящик, то необходимо сделать следующее:<br/>
зайдите в свой почтовый ящик и в верхнем навигационном меню выберите пункт "Настройки";<br/>
в окне "Пароль" в поля "Новый пароль" и "Повторите пароль" введите новый пароль, который Вы желаете установить;<br/>
введите свой действующий пароль в поле "Старый пароль";<br/>
нажмите на кнопку "Сохранить изменения".<br/><br/>

Если Вы хотите сменить вопрос-подсказку, то необходимо сделать следующее:<br/>
зайдите в свой почтовый ящик и в верхнем навигационном меню выберите пункт "Настройки";<br/>
в окне "Конфиденциальность" выберите вопрос из предлагаемого списка и в поле "Ответ" введите ответ на него;<br/>
в поле "Пароль" введите свой действующий пароль;<br/>
нажмите на кнопку "Сохранить изменения".<br/><br/>
</p>

<li><a name="someuse"><b>Кто-то пользуется моим почтовым ящиком</b></a><br>
<p>

	Если у Вас возникли подозрения, что кто-то пользуется Вашим почтовым ящиком без Вашего ведома, то немедленно
	<a href="#chpass">смените пароль и вопрос-подсказку</a>.
	{$CONFIG.default_mail_service} гарантирует конфиденциальность ваших писем и используемых паролей. Вы, со своей стороны, тоже должны
	позаботиться о сохранности и нераспространении ваших паролей.
	<br><br>
</p>

<li><a name="rmmbox"><b>Как удалить свой почтовый ящик</b></a><br>
<p>

	Почтовая система @{$CONFIG.default_mail_service} автоматически удаляет неактивные почтовые ящики. Самостоятельное удаление своего ящика не возможно.<br><br>
</p>

<li><a name="rename"><b>Как переименовать свой почтовый ящик</b></a><br>
<p>

	Переименовывать почтовые ящики невозможно.<br><br>
</p>

{*
<li><a name=nospam> Как защитить свой почтовый ящик от СПАМА</a></br>
<p>

	Для защиты Вашего почтового ящика от приема нежелательной корренспондеции(СПАМ) в службе @{$CONFIG.default_mail_service} есть сортировщик спама,
	который позволит Вам произвести сортировку всех входящих почтовых сообщений, помеченных как СПАМ, и, при необходимости,
	автоматически удалить нежелательные письма. Сортировщик спама находится на странице настроек Вашего почтового ящика.</br></br>
</p>

<li><a name=nospam> Можно-ли автоматически сортировать входящие письма</a></br>
<p>

	Для Вашего удобства на @{$CONFIG.default_mail_service} есть сортировщик писем, который позволит Вам произвести автоматическую сортировку
	всех входящих писем по следующим полям: "отправитель", "получатель", "копия", "тема". В зависимости от установленных параметров,
	входящее письмо может быть удалено, или помещено в определенную Вами папку.</br></br>
</p>

<li><a name=create>Я уже несколько раз отправлял на проверку свой IP-адрес, но все равно не могу получить доступ к регистрации почтового ящика.</a><br>
<p>
	Если Вы уже несколько раз отправляли на проверку Ваш IP-адрес и не получили доступ к регистрации почтового ящика,
	значит он не прошел проверку на принадлежность к нашему региону.<br>
	Вы можете самостоятельно узнать результат проверки в <a href=https://www.ripe.net/perl/whois target=_blank>Ripe Whois Database</a><br><br>
</p>
*}
<li><a name=quest><b>Прочитал все разделы помощи, но не нашел ответ на свой вопрос</b></a><br>
<p>
	Дополнительные вопросы по функционированию почты на @{$CONFIG.default_mail_service} Вы можете задать через <a style="cursor: pointer; text-decoration: underline;" title="Открыть" target="ublock" onclick="window.open('/feedback/?from={$ENV.sectionid}', 'ublock','width=480,height=410,resizable=1,menubar=0,scrollbars=0').focus();">форму обратной связи</a>.{* или напишите письмо на адрес info@{$CONFIG.default_mail_service}*}<br><br>
</p>

</OL>



{/if}



</td></tr>
</table>