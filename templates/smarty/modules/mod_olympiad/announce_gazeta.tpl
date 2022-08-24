<table border=0 cellpadding=3 cellspacing=0 width=100%>
  <tr><td align="left" class="dop2" bgcolor="#999999">Командный зачет</td></tr>
</table>
<table border="0" cellspacing="0" cellpadding="4" width="100%">
	<tr>
		<td colspan="2"></td>
		<td>Всего</td>
		<td style="color:#BA7701" width="30" align="center" title="Золото"><b>З</b></td>
		<td style="color:#A0A0A0" width="30" align="center" title="Серебро"><b>С</b></td>
		<td style="color:#BA2747" width="30" align="center" title="Бронза"><b>Б</b></td>
	</tr>
	{foreach from=$res.list item=l key=k}
	<tr {if $k%2==0} class='bg_color4'{/if}>
		<td>{if $l.FlagSmall}<img border="0" src="/_img/themes/flags/small/{$l.FlagSmall}">{/if}</td>
		<td class="text11"{if $l.Name=="Россия"} style="color:red;"{/if}>{$l.Name}</td>
		<td class="text11" align="center">{$l.Gold+$l.Silver+$l.Bronze}</td>
		<td class="text11" style="color:#BA7701" align="center">{$l.Gold}</td>
		<td class="text11" style="color:#A0A0A0" align="center">{$l.Silver}</td>
		<td class="text11" style="color:#BA2747" align="center">{$l.Bronze}</td>
	</tr>
	{/foreach}
</table>