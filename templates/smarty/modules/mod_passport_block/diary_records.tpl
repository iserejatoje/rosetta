{if count($res.count)>0}
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
<tr>
	<td class="block_title4" style="padding-left:6px;"><span>Пишет в блоге</span></td>
	<td class="block_title4" align="right">&nbsp;</td>
</tr>
</table>

{foreach from=$res.records item=l}
	{include file="`$CONFIG.templates.diary_records_element`" l=$l}
{/foreach}

{/if}