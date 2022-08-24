<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td width="75%" style="padding-left:20px;">

			<p>
			Количество поисковых запросов за 30 дней: <b>{$res.count_all_month|number_format:0:".":" "}</b><br>
			Среднее число поисковых запросов в день: <b>{$res.count_all_day|number_format:0:".":" "}</b>
			</p>

			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr valign="top">
				
				{foreach from=$res.list item=col key=k}
					<td width="50%">
						<table align="center" cellpadding="4" cellspacing="0" border="0">
							<tr valign="middle" bgcolor="#E0F3F3">
								<th align="center" width="30px">№</th>
								<th align="center">Текст</th>
								<th align="center" width="140px">Кол-во запросов<br />за месяц</th>
							</tr>
						{foreach from=$col item=l key=k}

							<tr valign="top" bgcolor="#{cycle values='FFFFFF,F0F8F9'}">
								<td align="right">{$k+1}.</td>
								<td align="left"><a href="/{$ENV.section}/search.php?where=3&query={$l.query|escape|escape:'url'}">{$l.query}</a></td>
								<td align="right" style="padding-right:15px;">{$l.cnt_q|number_format:0:".":" "}</td>
							</tr>

						{/foreach}
						</table>
					</td>
				{/foreach}
				</tr>
			</table>			
		</td>
	</tr>
</table><br/><br/>