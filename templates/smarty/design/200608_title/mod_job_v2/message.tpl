{include file="`$TEMPLATE.sectiontitle`" rtitle="`$page.type`"}
<br /><br />
<table align="center" width="90%" cellpadding="0" cellspacing="0" border="0" class="table2">
	<tr>
		<td align="center" class="title_normal">
			{foreach from=$page.err item=l key=k}
				{$l}<br />
			{/foreach}
		</td>
	</tr>
	{if $page.my.add_resume && in_array($CURRENT_ENV.regid, array(74, 63, 59, 72, 16, 61, 2, 34))}
	<tr>
		<td>
	{*На нашем сайте Вы можете:<br/>
	<ul>
		<li>Посмотреть с "количество"  вакансий  работодателей из раздела "Раздел"</li>
		<li> Сделать Ваше резюме более заметным для работодателей, выдели его цветом и сохраняя его на первом месте в разделе. <a href="/help/services/work/resume/">Как это сделать?</a></li>
		<li>Участвовать в обсуждениях и форумах профессионального сообщества "профессиональная  группа"</li>
		<li>Задавать и отвечать на вопросы в сервисе "Задай вопрос профессионалу". Эта возможность обмена знаниями и поиска клиентов.</li>
		<li>Обсуждать ваши увлечения и хобби  (отмеченные пользователем – разделяют х человек)</li>
		<li>Обсуждать работу организаций нашего города</li>		
	</ul>
    
    
    Также здесь Вы можете:<br/>
	<ul>
		<li>Продавать и покупать автомобили</li>
		<li>Продавать и покупать и недвижимость</li>
		<li>Размещать и просматривать частные объявления</li>
    </ul>

У Вас есть личная (персональная) страница на сайте ufa1.ru. адрес <a href="#">моя_страница</a><br/>

Здесь можно общаться со старыми друзьями и находить новых, решать профессиональные вопросы, обсуждать интересные для Вас темы, оставлять отзывы о работе организаций города, хранить фото и вести дневник, найти работу, купить или продать автомобиль или недвижимость. 

<br/> 

<a href="">Экскурсия по сайту</a>
<a href="">Моя страница</a>
		*}
		
		
		
		
			Ваше резюме может находиться на первой странице в конкретной рубрике и быть выделено красным цветом. В этом случае оно станет намного более заметным для работодателей:
			<div align="center" style="padding: 10px;"><img height="77" border="0" width="460" src="/_img/modules/job/top_row.gif" alt="" /></div>
			Для этого необходимо отправить на короткий номер <b>5120</b> SMS-сообщение с текстом
			<p style="font-family:Courier New;text-align:center;"><b>RESUME {$ENV.regid} {if $page.ResumeID > 0}{$page.ResumeID}</b>{else}номер_резюме</b><br />Пример: RESUME {$ENV.regid} 775511{/if}</p>
			Регистр букв не имеет значения, вместо слова &laquo;RESUME&raquo; также можно написать &laquo;РЕЗЮМЕ&raquo;.
			Стоимость одного SMS-сообщения: 100 руб.
			Услуга действует 72 часа.
			Повторные SMS-сообщения увеличивают время действия услуги на 72 часа.
		</td>
	</tr>
	{/if}
	{if $page.main}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/">К списку разделов</a> ]</td>
	</tr>
	{/if}
	{if $page.back}
	<tr>
		<td align="center"><br/>[ <a href="#" onclick="window.history.go(-1)">Назад</a> ]</td>
	</tr>
	{/if}
	{if $page.my.resume}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/resume.php">Мои резюме</a> ]</td>
	</tr>
	{/if}
	{if $page.my.add_resume}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/resume/add.php">Добавить еще одно резюме</a> ]</td>
	</tr>
	{/if}
	{if $page.my.vacancy}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/vacancy.php">Мои вакансии</a> ]</td>
	</tr>
	{/if}
	{if $page.my.add_vacancy}
	<tr>
		<td align="center"><br/>[ <a href="/{$ENV.section}/my/vacancy/add.php">Добавить еще одну вакансию</a> ]</td>
	</tr>
	{/if}
</table>
