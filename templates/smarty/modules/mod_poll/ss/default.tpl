<!--noindex--><br>
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="text11" bgcolor="#FFFFFF">
<tr align="center" valign="middle" bgcolor="#E9EFEF">
	<td width="10%"><B>Дата</B></td>
	<td width="80%"><B>Голосование</B></td>
	<td width="10%"><B>Количество ответов</B></td>
</tr>
{foreach from=$res.list item=l}
<tr bgcolor="{cycle values="#FFFFFF,#F3F8F8"}">
	<td align="center">{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>
	<td><a href="/{$ENV.section}/{$l.id}.html" target="stat" onclick="window.open('about:blank', 'stat','width=500,height=500,resizable=1,menubar=0,scrollbars=1').focus();">{$l.name}</a></td>
	<td align="center">{$l.cnt|number_format:0:" ":" "}</td>
</tr>
{/foreach}
</table>
<!--/noindex-->
