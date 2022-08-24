	<br /><p align=center class='anketavopr'>Статистика проекта за последний месяц{*последние 30 дней*}<br>(по данным рейтинга Rambler's top100)</p>
	<table border="0" cellpadding="0" cellspacing="0" align="center">
	{foreach from=$page.statistic.mclients_ord key=k item=ord}
		<tr>
			<td colspan=2 class="t7" style="font-size: 11px; font-weight: bold;">
				{counter}. Сайт {foreach from=$page.statistic.rambler[$k].domain item=l2 name=f}<a href="http://{$l2}" target="_blank" class="s1"><b>{$l2}</b></a>{if !$smarty.foreach.f.last}, {/if}{/foreach}
			</td>
		</tr>
		<tr>
			<td rowspan="2" width="25">&nbsp;<br></td>
			<td class="t7" style="font-size: 11px;">
				{*span с id="u_{project}" удалять нельзя, он используется для парсинга количества посетителей для страницы http:// info74.ru/?view=rek*}
				Посетителей - <noindex><a href="http://top100.rambler.ru/cgi-bin/stats_top100.cgi?id={$page.statistic.rambler[$k].statistic.ramb_id}&page=2&subpage=2&site=1&datarange=2" target="_blank" rel="nofollow"><font color="red"><b><span id="u_{$page.statistic.names[$k][0]}">{if count($page.statistic.rambler_ord) == 1}{$page.statistic.total.month_clients|number_format:0:'':' '}{else}{$page.statistic.rambler[$k].statistic.month_clients|number_format:0:'':' '}{/if}</span></b></font></a></noindex>
			</td>
		</tr>
		<tr>
			<td class="t7" style="font-size: 11px;padding-bottom:10px;">
				{*span с id="p_{project}" удалять нельзя, они используются для парсинга количества посещенных страниц для страницы http:// info74.ru/?view=rek*}
				Просмотренных страниц - <noindex><a href="http://top100.rambler.ru/cgi-bin/stats_top100.cgi?id={$page.statistic.rambler[$k].statistic.ramb_id}&page=2&subpage=2&site=1&datarange=2" target="_blank" rel="nofollow"><font color=red><span id="p_{$page.statistic.names[$k][0]}">{if count($page.statistic.rambler_ord) == 1}{$page.statistic.total.month_pages|number_format:0:'':' '}{else}{$page.statistic.rambler[$k].statistic.month_pages|number_format:0:'':' '}{/if}</span></font></a></noindex>
			</td>
		</tr>	
	{/foreach}
		<tr>
			<td colspan=2>&nbsp;</td>
		</tr>
	{if count($page.statistic.rambler_ord) > 1}
		<tr>
			<td colspan=2 class="t7" style='font-size: 11px; font-weight: bold;'>
				Всего:
			</td>
		</tr>
		{if $CURRENT_ENV.regid==74}
		<tr>
			<td width="25">&nbsp;<br></td>
			<td class="t7" style='font-size: 13px;'>
				Аудитория - <noindex><a href="http://www.liveinternet.ru/stat/{$CURRENT_ENV.regid}/visitors.html?avgraph=yes&id=9" target="_blank" rel="nofollow"><font color=red><b>{$page.statistic_li[$CURRENT_ENV.regid].visitors31day|number_format:0:'':' '}</b></font></a></noindex>
			</td>
		</tr>
		{/if}
		<tr>
			<td width="25">&nbsp;<br></td>
			<td class="t7" style='font-size: 13px;'>
				Посетителей - <font color="red"><b>{$page.statistic.total.month_clients|number_format:0:'':' '}</b></font>
			</td>
		</tr>
		<tr>
			<td width="25">&nbsp;<br></td>
			<td class="t7" style="font-size: 13px;padding-bottom:10px;">
				Просмотренных страниц - <font color=red>{$page.statistic.total.month_pages|number_format:0:'':' '}</font>
			</td>
		</tr>
	{/if}
	</table>
	<br /><br />
{if $CURRENT_ENV.regid==74}
			<center><table border="0" cellpadding="0" cellspacing="0" width="60%">
			<tr><td class="t7" align="left" style="font-size: 11px;">
Аудитория - количество уникальных человек, посетивших проект.<br />
Посетители - общее количество посещений проекта.<br />
Просмотренные страницы - общее количество просмотренных страниц посетителями проекта.<br />
		</td></tr></table></center>
{/if}
	<br /><br />