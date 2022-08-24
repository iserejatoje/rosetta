{if count($res.list)>0}
<br/>
<table cellspacing="0" cellpadding="0" border="0" width="100%" class="text11">
{foreach from=$res.list item=l}
	<tr>
		<td class="t5">
			<a href="/{$CURRENT_ENV.section}/{$l.GroupID}.html"><b>{$l.Name}</b></a>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
{/foreach}
</table>
{/if}