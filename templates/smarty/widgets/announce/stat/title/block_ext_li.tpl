<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="t11" align="left" valign="top" style="padding-left:4px;padding-right:4px;padding-top:6px;"> 
			Статистика <a class=a11 href="{$res.url}" {*target="statistic{$res.rambler_id}" onclick="window.open('about:blank', 'statistic{$res.rambler_id}','width=430,height=480,resizable=1,menubar=0,scrollbars=1').focus();"*} target="_blank">проекта {$res.domain}</a>
			<br />за месяц{*<font color=red>30</font> дней*}:<br>
			Аудитория: <font color=red>{$res.statistic_li[$CURRENT_ENV.regid].visitors31day|number_format:0:'':' '}</font><br>
			Посетителей: <font color=red>{$res.statistic.total.month_clients|number_format:0:'':' '}</font><br>
			Страниц: <font color=red>{$res.statistic.total.month_pages|number_format:0:'':' '}</font><br>
		</td>
	</tr>
	<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td></tr>
</table>