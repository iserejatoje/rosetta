<table class="table" cellpadding="0" cellspacing="0">
<tr>
	<td class="statistic">
		Статистика <a href="{$res.url}" {*target="statistic{$res.rambler_id}" OnClick="window.open('about:blank', 'statistic{$res.rambler_id}','width=430,height=480,resizable=1,menubar=0,scrollbars=1').focus();"*} target="_blank">проекта {$res.domain}</a><br />
		за месяц{*<span>30</span> дней*}:<br />
		{if $CURRENT_ENV.regid == 74}
			Аудитория: <span>{$res.statistic_li[$CURRENT_ENV.regid].visitors31day|number_format:0:'':' '}</span><br />
		{/if}
		Посетителей: <span>{$res.statistic.total.month_clients|number_format:0:'':' '}</span><br />
		
		{php}
			$this->_tpl_vars['month_pages'] = 0;
			foreach($this->_tpl_vars['res']['statistic']['rambler'] as $v) {
				$this->_tpl_vars['month_pages'] += $v['statistic']['month_pages'];
			}
			
		{/php}
			
		Страниц: <span>{$res.statistic.total.month_pages|number_format:0:'':' '}</span>
		{*Страниц: <span>{$month_pages|number_format:0:'':' '}</span>*}
	</td>
</tr>
</table>