{if $res.page=="putres"}
	{capture name="rname"}
		Вы разместили новое резюме {$res.id} 
	{/capture}
{else}
	{capture name="rname"}
		Просмотр данных по резюме {$res.id}
	{/capture}
{/if}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}<br/>
<table cellpadding="2" cellspacing="0" border="0" bgcolor='#FFFFFF' width="100%">
	<tr>
		{if !empty($res.photo.file)}<td valign="top"><img src="{$res.photo.file}" width="{$res.photo.w}" height="{$res.photo.h}" alt="{$res.fio}"/></td>{/if}
		<td width="100%">
			<table cellpadding="4" cellspacing="1" border="0" width="100%">
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Ф.И.О.</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.fio}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Город</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.city}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Должность</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.dol}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Зарплата</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.pay}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">График работы</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.grafik}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Тип работы</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.type}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Образование</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.educ}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Уч. заведение</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.vuz}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Стаж</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.stage}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Предыдущие места<br>работы</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.pred}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Знание языков</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.lang}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Знание компьютера</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.comp}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Бизнес-образование</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.baeduc}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Дополнительные<br>сведения</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.dop}</td>
				</tr>
				{if $res.imp_type}
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Важность</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>
					{if $res.imp_type == 1}Срочно
					{elseif $res.imp_type == 2}Не очень срочно
					{else}Сейчас работаю, но интересный вариант готов рассмотреть{/if}
					</td>
				</tr>
				{/if}
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Пол</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.pol}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Степень ограничения трудоспособности</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.ability}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Возраст</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.age}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">http://</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{if $res.http!=""}<a href="http://{$res.http}" target="_blank">{$res.http|trim:" / "}</a>{/if}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">E-mail</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{if $res.email!=""}{$res.email}{/if}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Домашний тел.</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.phoneh}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Рабочий тел.</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.phoner}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Факс</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.fax}</td>
				</tr>
				<tr>
					<td class='t1' align='right' bgcolor='#DEE7E7' width="130">Адрес</td>
					<td class='t7' align='left' bgcolor='#F6FBFB'>{$res.addr}</td>
				</tr>
				{if $CURRENT_ENV.regid ==74 && $res.page=="putres" && ($res.rid==1 || $res.rid==11 || $res.rid==21 || $res.rid==22)}
				<tr>
					<td colspan='2'>
						<p align=center> Вы добавили резюме в рубрику
				&quot;{$res.jrname}&quot;. Оно будет размещено на сайте <a href=http://chel.ru>www.chel.ru</a>.
				Посмотреть резюме можно <a href="http://chel.ru/job/index.php?rid={$res.rid}&cmd=showres&id={$res.id}" target="_blank">здесь</a>.</p>
					</td>
				</tr>
				{/if}
				{if $res.page != "putres"}
				<tr>
					<td align="center" colspan="2"><a class="s1" href="/{$CURRENT_ENV.section}/?cmd=rprint&id={$res.id}&rid={$res.rid}" target="rprint" onclick="window.open('about:blank', 'rprint','width=550,height=500,resizable=1,menubar=0,scrollbars=1').focus();">версия для печати</a></td>
				</tr>
				{/if}
			</table>
		</td>
	</tr>
</table><br/>
{include file="`$TEMPLATE.midbanner`"}