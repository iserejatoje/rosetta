{*изменено по требованию Россвязьнадзор*}

				<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
					<tr>
						<th colspan="6">Список размещенных резюме</th>
					</tr>
					<tr>
						<th>#</th>
						<th>Дата<br/>разм.</th>
						<th>Дата<br/>истеч.</th>
						<th>Имя{*Ф.И.О.*}</th>						
						<th>Отрасли / Должности</th>
					</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.data item=l}
					<tr class="{excycle}" valign="top">
						<td class="text11" align="center">
							<a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php">{$l.ResumeID}</a>
						</td>
						<td align="center">{$l.UpdateDate}</td>
						<td align="center">{$l.ValidDate}</td>
						<td>{$l.Name}</td>						
						<td>
							<a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php"><b>
							{if $l.Position != ""}
								{$l.Position}
							{else}
								{php} $this->_tpl_vars['aid'] =  $this->_tpl_vars['l']['ResumeID'] {/php}
								{include file="`$CONFIG.templates.ssections.simple_branches`" aid="$aid"}	
							{/if}</b>
							</a>
						</td>
					</tr>
				{/foreach}
				</table>
