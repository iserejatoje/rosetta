<table cellpadding="0" cellspacing="0" border="0" align="center" width="580">
    <tr>
		<td align="center">
			<form method="post">
			<input type="hidden" name="action" value="subscribe_edit_list"/>
			<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
				<tr bgcolor="#DEE7E7">
					<th>Вакансии</th>
					<th>Резюме</th>
					<th>Рубрика</th>
				</tr>
			{excycle values=" ,bg_color4"}
			{foreach from=$res.list item=l}
				<tr class="{excycle}">
		            <td align="center">
			              <input type="hidden" name="arr_rid[]" value="{$l.rid}"/>
			              <input type="checkbox" name="arr_vac[{$l.rid}]" {$l.chvac} class="in"/>
					</td>
		            <td align="center">
			              <input type="checkbox" name="arr_res[{$l.rid}]" {$l.chres} class="in"/>
					</td>
		            <td align="center">{$l.name}</td>
		        </tr>
			{/foreach}
			</table><br/>
			<input type="submit" value="Изменить" class="in">
			</form>
		</td>
	</tr>
</table>
<br/>
