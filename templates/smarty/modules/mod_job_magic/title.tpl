{if !isset($smarty.get.print)}
<table cellspacing="0" cellpadding="0" width="100%" border="0">
	<tr>
		<td bgcolor="#F1F6F9">
		<table cellspacing="0" cellpadding="3" width="100%" border="0">
			<tr>
				<td valign="top" width="20%">
					<br/><img src="/_img/x.gif" width="9" height="9" alt="" />
					<a class="dop2" href="/{$CURRENT_ENV.section}/">Главная</a><br/>
					{if $USER->IsAuth()}
						<img src="/_img/x.gif" width="9" height="9" alt="" />
						<a class="dop2" href="http://74.ru/job/my/firm.php" target="_blank" id="gl">Настройка</a><br/>
					{/if}
					<img src="/_img/x.gif" width="9" height="9" alt="" />
					<a class="dop2" href="http://74.ru/job/my/subscribe.php" target="_blank">Подписка</a>
				</td>
				<td valign="top" width="20%" class="dopp">
					<b>Искать</b>:<br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="/{$CURRENT_ENV.section}/vacancy/search.php" >вакансии</a><br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="/{$CURRENT_ENV.section}/resume/search.php" >резюме</a><br/>
				</td>
				<td valign="top" width="20%" class="dopp">
					<b>Разместить</b>:<br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="http://74.ru/job/my/vacancy/add.php" target="_blank">вакансию</a><br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="http://74.ru/job/my/resume/add.php" target="_blank">резюме</a><br/>
				</td>
				<td valign="top" width="20%">
					<b>Редактировать</b>:<br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="http://74.ru/job/my/vacancy.php" target="_blank">вакансию</a><br/>
					&nbsp;<img src="/_img/x.gif" width="9" height="9" alt=""/> 
					<a class="dop2" href="http://74.ru/job/my/resume.php" target="_blank">резюме</a><br/>
				</td>
				<td valign="top" width="20%">
					<br/> 
					<a class="dop2" href="http://74.ru/job/howto.html" target="_blank">Как написать&nbsp;резюме</a><br/>
					<a class="dop2" href="http://74.ru/job/articles.html" target="_blank">Аналитика</a><br/>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<br/>
{*
<center><b><noindex><a href="http://www.u-b-s.ru/busines/sale/technologyphone/" style="color:red" target="_blank">
Тренинг <nobr>&laquo;Технологии телефонных продаж&raquo;</nobr> <nobr>16-17 июня!</nobr> <nobr>Тел. 264-01-69,</nobr> <nobr>265-77-42.</nobr>
</a></noindex></b></center><br/>
*}
{*<center><b><noindex><a href="http://www.u-b-s.ru/busines/logister/skladskayalogistika/" style="color:red" target="_blank">
Семинар-практикум &laquo;Складская логистика: управление товарами <nobr>на складе</nobr>&raquo; <nobr>20-21 июня</nobr>
</a></noindex></b></center><br/>*}
{*
<center><b><noindex><a href="http://www.u-b-s.ru/busines/korporativnoe/" style="color:red" target="_blank">
Отдых и обучение: тренинги &laquo;Командообразование&raquo; и &laquo;Продавайте больше&raquo;. <nobr>Тел. 264-01-69, 265-77-42.</nobr>
</a></noindex></b></center><br/>
<br/>
*}
{/if}

{if !$hide_search}
	{include file="`$TEMPLATE.search_keyword`"}
{/if}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="zag4">{$rtitle}</td>
	</tr>
</table>
<br/>
