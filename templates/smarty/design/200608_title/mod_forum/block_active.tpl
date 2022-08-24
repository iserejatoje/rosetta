{if count($res.themes) > 0}
<table>
{foreach from=$res.themes item=l}
	<tr>
		<td><a href="{$l.url}">{$l.name}</a></td>
	</tr>
{/foreach}
</table>
{/if}