<table cellpadding="0" cellspacing="0" width="100%"> 
<tr>
	<td class="title2">{$res.name}</td>
</tr>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
<tr valign="top">
{if $res.state == 'question'}
<td>{$res.questiontext}</td>
{else}
<td>{$res.resulttext}</td>
{/if}
</tr>
</table>
