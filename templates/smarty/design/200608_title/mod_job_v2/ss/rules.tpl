{include file="`$TEMPLATE.sectiontitle`" rtitle="Правила"}

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table2">
	<tr>
		<td class="text11" style="padding-right: 8px;" valign="bottom" width="100%"><br/>
			<p>Для получения возможности размещать, редактировать вакансию/резюме вам необходимо <u><a href="/passport/register.php?url=%2F{$ENV.section}%2Fredirect%2Flogin.php" target="_blank">зарегистрироваться</a></u></p>
			<ol>
				<li style="padding:4px 0 4px 0">Запрещается размещать объявления, содержащие в графах &laquo;Вакансия&raquo;, &laquo;ФИО&raquo;, &laquo;Должность&raquo;, &laquo;Фирма&raquo; (если это не аббревиатура) ТОЛЬКО БОЛЬШИЕ БУКВЫ, рекламу фирм, предложения услуг, названия сайтов в поле &laquo;Фирма&raquo;, спецсимволы и другие знаки, затрудняющие поиск нужной информации;
				<li style="padding:4px 0 4px 0">запрещается размещать объявления, не соответствующие разделу: к примеру, если вы ищете кандидата на должность слесаря, не стоит вакансию размещать в разделе «Топ-менеджеры», если вы претендуете на должность банковского служащего, то раздел «Спорт» не даст вам нужного эффекта;
				<li style="padding:4px 0 4px 0">запрещается размещать одинаковые и часто повторяющиеся объявления о поиске/предложении работы;
				<li style="padding:4px 0 4px 0">запрещается размещать объявления о быстром заработке без вложений, предложения телеработы, интернет-пирамиды, интернет-трейдинге, интиме;
				<li style="padding:4px 0 4px 0">запрещается размещать объявления о сетевом маркетинге, размещенные в других рубриках;
				<li style="padding:4px 0 4px 0">указанные контактные телефоны должны соответствовать региону, в котором Вы размещаете объявление;
				<li style="padding:4px 0 4px 0;color: red">работодателям/соискателям, размещающим вакансии/резюме на некоммерческой основе, разрешается размещение не более 5 вакансий/резюме в сутки с одной учетной записи с указанием одной и той же контактной информации (наименование предприятия, телефоны, адреса, названия сайтов и.т.д.);
				<li style="padding:4px 0 4px 0;color: red">в случае размещения вакансий одной компанией (отделом кадров), зарегистрировавшейся несколько раз, все данные будут блокироваться, а пользователей будут лишать прав доступа к сайту;
				<li style="padding:4px 0 4px 0">запрещается размещение не существующих вакансий и резюме;
				<li style="padding:4px 0 4px 0">запрещается размещать информацию о тренингах, семинарах, курсах и.т.д. Компании, которые будут нарушать данные условия, автоматически попадут в черный список и в дальнейшем не смогут размещать свои объявления на всех проектах {$ENV.site.domain};
				<li style="padding:4px 0 4px 0">для компаний и частных лиц, оплативших коммерческий доступ, данные правила действуют в полном объеме, за исключением пункта 7.
				<li style="padding:4px 0 4px 0">Кадровые и рекрутинговые компании обязаны указывать действительное корректное название компании, размещающей объявление.
			</ol>
			
			<p style="color: red;">Все сообщения отражают мнения их авторов, и администрация никакой ответственности за них не несет. Личные данные Пользователей (ip-адрес), разместивших cсообщения, предоставляются только по запросам из официальных органов (Прокуратура, отдел &laquo;К&raquo; и др).</p>
			<p>Администрация {$ENV.site.domain} оставляет за собой право без объяснения причины блокировать доступ пользователям к ресурсу <u><a href="http://www.{$ENV.site.domain}/{$ENV.section}/">www.{$ENV.site.domain}/{$ENV.section}</a>.</u></p>

			<p>После размещения Резюме соискателей попадают на бессрочное хранение в архив сайта <a href="http://www.{$ENV.site.domain}/{$ENV.section}/">www.{$ENV.site.domain}/{$ENV.section}</a> и могут быть использованы сайтом по своему усмотрению.</p>

			{if $CONFIG.forum_id}<p>Также нам будет приятно, если вы поделитесь своим опытом поиска работы с помощью нашего сайта <a href="/forum/view.php?id={$CONFIG.forum_id}" target="_blank">на форуме</a> в разделе «Работа и образование».</p>{/if}

			{* sms-блок *}
			{if in_array($CURRENT_ENV.regid, array(74, 63, 59, 72, 16, 61, 2, 34))}
			<p>&nbsp;</p>
			<p><a name="sms"></a><b>Как сделать ваше резюме более заметным:</b></p>
			<p>Ваше резюме может находиться на первой странице в конкретной рубрике и быть выделено красным цветом. В этом случае оно станет намного более заметным для работодателей:</p>
			<div align="center" style="padding: 10px;"><img height="79" border="0" width="490" src="/_img/modules/job/money/top_row.jpg" alt="" /></div>
			<p>Для этого необходимо отправить на короткий номер <b>5120</b> SMS-сообщение с текстом</p>
			<p style="font-family: Courier New; text-align: center;"><b>RESUME {$CURRENT_ENV.regid} номер резюме</b><br />Пример: RESUME {$CURRENT_ENV.regid} 775511</p>
			<p>Регистр букв не имеет значения, вместо слова &laquo;RESUME&raquo; также можно написать &laquo;РЕЗЮМЕ&raquo;; <b>{$CURRENT_ENV.regid} номер резюме</b> состоят только из цифр.<br />
			Стоимость одного SMS-сообщения: 100 руб.
			Услуга действует 72 часа.
			Повторные SMS-сообщения увеличивают время действия услуги на 72 часа.
			</p>
			{/if}
		</td>
	</tr>
</table>