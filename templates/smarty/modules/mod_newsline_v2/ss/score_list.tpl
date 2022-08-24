<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td height="10px"></td></tr>
<tr><td align="right"><a href="/{$SITE_SECTION}/{$res.group}{$res.id}.html">Вернуться назад к статье</a></td></tr>
<tr><td height="4px"></td></tr>
<tr><td class="zag2" align="center">Рейтинг статей</td></tr>
<tr><td height="4px"></td></tr>
<tr><td>

	<table width=100% cellpadding=2 cellspacing=1 border=0 bgcolor=#666666>
	<tr bgcolor=#FFFFFF align=center>
		<td width="70%"><b>Название статьи</b></td>
		<td width="10%"><b>Количество проголосовавших</b></td>
		<td width="10%"><b>Средний балл</b></td>
		<td width="10%"><b>Количество отзывов</b></td>
	</tr>
	{foreach from=$res.list item=l}
	<tr align="center" valign="middle" bgcolor="{if $l.id==$res.id}#F6F6F6{else}#FFFFFF{/if}">
		<td align="left"><a href="/{$SITE_SECTION}/{$res.group}{$l.id}.html">
		{if $l.type==2 }
			<b>{$l.name_arr.name}</b>,<br/>{$l.name_arr.position}</a>
		{else}
			{$l.name}
		{/if}
		</a></td>
		<td>{$l.rating_col}</td>
		<td>{$l.rating}</td>
		<td>{$l.otziv_col}</td>
	</tr>
	{/foreach}
	</table>

</td></tr>
<tr><td height="10px"></td></tr>
<tr><td align="right"><a href="/{$SITE_SECTION}/{$res.group}{$res.id}.html">Вернуться назад к статье</a></td></tr>
<tr><td height="10px"></td></tr>
</table>
