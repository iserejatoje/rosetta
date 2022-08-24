{if count($res.sections) > 0}
<table>
{foreach from=$res.sections item=l}
	<tr>
		<td><a href="{$l.url}">{$l.name}</a></td>
	</tr>
{/foreach}
</table>
{/if}