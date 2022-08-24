
				<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
					<tr>
						<th colspan="6">Список размещенных вакансий</th>
					</tr>
					<tr>
						<th>#</td>
						<th>Дата<br/>разм.</th>
						<th>Дата<br/>истеч.</th>
						<th>Фирма</th>						
						<th>Отрасли / Должности</th>
					</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.data item=l}
					<tr class="{excycle}" valign="top">
						<td class="text11" align="center">
							<a href="/{$ENV.section}/my/vacancy/edit/{$l.vid}.php">{$l.vid}</a>
						</td>
						<td align="center">{$l.pdate}</td>
						<td align="center">{$l.vdate}</td>
						<td>{$l.firm}</td>						
						<td>
							<a href="/{$ENV.section}/my/vacancy/edit/{$l.vid}.php"><b>
							{if $l.dol != ""}
								{$l.dol}
							{else}
								{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['vid'] {/php}
								{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid"}
							{/if}</b>
							</a>
						</td>
					</tr>
				{/foreach}
				</table>
