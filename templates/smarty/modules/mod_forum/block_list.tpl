<form method="POST">
<input type="hidden" name="_action" value="_blocklist.html">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="mode" value="{$mode}">
<table width="100%" cellpadding="4">
	<tr>
		{if $mode=='ip'}
		<td class="ftable_header">IP</td>
		<td class="ftable_header">Forwarded IP</td>
		{else}
		<td class="ftable_header">Cookie</td>
		{/if}
		<td class="ftable_header">До</td>
		<td class="ftable_header">Причина</td>
		<td class="ftable_header"></td>
	</tr>
{if empty($list)}
</table>                    
<center>Нет заблокированных {if $mode=='ip'}IP адресов{else}Cookie{/if}</center>
{else}
{foreach from=$list item=l}
	<tr>
		{if $mode=='ip'}
		<td>{$l.ip|regex_replace:"/\b((?:[0-9]+\.)+[0-9]+)\b/":"<a href=\"https://www.nic.ru/whois/?ip=\\1\" target=\"blank\">\\1</a>"}</td>
		<td>{$l.ip_fw|regex_replace:"/\b((?:[0-9]+\.)+[0-9]+)\b/":"<a href=\"https://www.nic.ru/whois/?ip=\\1\" target=\"blank\">\\1</a>"}</td>
		{else}
		<td>{$l.cookie}</td>
		{/if}
		<td>{if $l.eternal==1}не ограниченно{else}{$l.still|date_format:"%d.%m.%Y"}{/if}</td>
		<td>{$l.comment}</td>
		<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>
	</tr>
{/foreach}
</table>
{/if}
<div align="center"><input type="submit" value="Удалить"></div>
</form>
