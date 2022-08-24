{$page.header}<br>
<form method="POST">
<input type="hidden" name="action" value="delete_block_cookie">
<table width="100%" cellpadding="4">
	<tr>
		<td class="ftable_header">Cookie</td>
		<td class="ftable_header">До</td>
		<td class="ftable_header">Причина</td>
		<td class="ftable_header"></td>
	</tr>
{if empty($page.list)}
</table>                    
<center>Нет заблокированных Cookie</center>
{else}
{foreach from=$page.list item=l}
	<tr>
		<td>{$l.cookie}</td>
		<td>{if $l.eternal==1}не ограниченно{else}{$l.still|date_format:"%d.%m.%Y"}{/if}</td>
		<td>{$l.comment}</td>
		<td><input type="checkbox" name="ids[]" value="{$l.id}"></td>
	</tr>
{/foreach}
</table><br>
<div align="center"><input type="submit" value="Удалить"></div>
{/if}
</form>
