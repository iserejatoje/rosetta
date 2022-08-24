{include file="`$TEMPLATE.sectiontitle`" rtitle="Подписка"}

<table cellpadding="0" cellspacing="0" border="0" align="center" width="580">
    <form name="editslist" method="post">
	<input type="hidden" name="cmd" value="editslist"/>
    <tr>
		<td>
			<table cellpadding="4" cellspacing="2" border="0" width="100%" >
				<tr bgcolor="#DEE7E7">
					<th class="t1">Вакансии</th>
					<th class="t1">Резюме</th>
					<th class="t1">Рубрика</th>
				</tr>
			{excycle values="#F3F8F8,#FFFFFF"}
			{foreach from=$data item=l}
				<tr bgcolor="{excycle}">
		            <td class="t7" align="center" valign="middle">
			              <input type="hidden" name="arr_rid[]" value="{$l.rid}"/>
			              <input type="checkbox" name="arr_vac[{$l.rid}]" {$l.chvac} class="in"/>
					</td>
		            <td class="t7" align="center" valign="middle">
			              <input type="checkbox" name="arr_res[{$l.rid}]" {$l.chres} class="in"/>
					</td>
		            <td class="t7" align='center' valign="middle">{$l.name}</td>
		        </tr>
		{/foreach}
	</table>
</td></tr>
</table>
<br/>
<center><input type="submit" value="Изменить" class="in"></center>
</form>
