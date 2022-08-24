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
						<th>Раздел</th>
						<th>Должность</th>
					</tr>
				{excycle values=" ,bg_color4"}
				{foreach from=$res.data item=l}
					<tr class="{excycle}" valign="top">
						<td class="text11" align="center">
							<a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php">{$l.resid}</a>
						</td>
						<td align="center">{$l.pdate}</td>
						<td align="center">{$l.vdate}</td>
						<td>{$l.fio}</td>
						<td>{$l.name}</td>
						<td>
							<a href="/{$ENV.section}/my/resume/edit/{$l.resid}.php">{$l.dol}</a>
						</td>
					</tr>
				{/foreach}
				</table>
