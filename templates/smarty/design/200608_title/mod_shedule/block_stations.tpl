{if $res.list}
<table style="margin-bottom: 1px;" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr align="right">
		<td class="block_title"><span>Вокзалы</span></td>
	</tr>
</table>
<table cellpadding="4" cellspacing="0" width="100%">
{foreach from=$res.list item=l}
<tr{if $l.StationID == $res.StationID} class="bg_color2"{/if}><td align="right" class="text11" style="padding-right:20px">
	<b><a href="/{$ENV.section}/station/{$l.StationID}.php">{$l.Name|lower|capitalize:true}</a></b>
</td></tr>
{/foreach}
</table>
{/if}