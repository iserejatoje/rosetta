<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="zag2" style="padding-left:5px; padding-top: 10px;  padding-bottom: 5px;">
	<a href="/afisha/" title="Сегодня вечером">
		<font class="zag2" style="text-decoration:none;">Сегодня вечером</font>
	</a></td>
</tr>
<tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="4">
	{foreach from=$res.list item=l}
	<tr>
		<td width="17"><img src="/_img/design/200710_afisha/bull1.gif" width="12" height="14"></td>
		<td><a href="/afisha/event/{$l.eid}.php">{$l.event}</a></td>
	</tr>
	{/foreach}
</table>
</td></tr>
</table>