<form method="POST">
<input type="hidden" name="_action" value="_subscribe.html">
<input type="hidden" name="action" value="delete">
<table width="100%">
{if !empty($sections)}
	<tr>
		<td class="ftable_header">Разделы</td>
		<td class="ftable_header" width="16">&nbsp;</td>
	<tr>
{foreach from=$sections item=l}
	<tr><td><a href="view.html?id={$l.id}" target="_blank">{$l.name}</a></td><td width="16"><input type="checkbox" name="sec_id[]" value="{$l.id}" /></td></tr>
{/foreach}
{/if}
{if !empty($themes)}
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
		<td class="ftable_header">Темы</td>
		<td class="ftable_header" width="16">&nbsp;</td>
	<tr>
{foreach from=$themes item=l}
	<tr><td>
{foreach from=$l.path item=l2}
{if $l2.data.type=='section'}<a href="view.html?id={$l2.id}">{/if}{$l2.data.title}{if $l2.data.type=='section'}</a>{/if} &gt; 
{/foreach}
    <a href="theme.html?id={$l.id}">{$l.name}</a></td><td width="16"><input type="checkbox" name="theme_id[]" value="{$l.id}" /></td></tr>
{/foreach}
{/if}
</table>
{if empty($sections) && empty($themes)}
	<center align="center">Список подписки пуст</center>
{else}
	<center align="center"><input type="submit" value="Отписаться"></center>
{/if}
</form>