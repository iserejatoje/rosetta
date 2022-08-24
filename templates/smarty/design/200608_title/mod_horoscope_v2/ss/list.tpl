{capture name="nav"}
	{if $res.prev}<a href="/{$ENV.section}/{$res.prev|date_format:"%Y-%m-%d"}/">{$res.prev|date_format:"%e"} {$res.prev|date_format:"%m"|month_to_string:2} {$res.prev|date_format:"%Y"} г.</a>{/if}
	{if $res.prev} | {/if}
	<font class="t_dw">{$res.date|date_format:"%e"} {$res.date|date_format:"%m"|month_to_string:2}</font>
	{if $res.next} | {/if}
	{if $res.next}<a href="/{$ENV.section}/{$res.next|date_format:"%Y-%m-%d"}/">{$res.next|date_format:"%e"} {$res.next|date_format:"%m"|month_to_string:2} {$res.next|date_format:"%Y"} г.</a>{/if}
{/capture}
<table cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td align="center">
{$smarty.capture.nav}
	</td>
</tr>
</table>
{foreach from=$res.list item=l key=k}
<table cellpadding="5" cellspacing="0" width="100%">
<tr>
	<td style="padding-left: 10px" class="t_dw" align="left">
		<br/>{$res.menu[$k]}
	</td>
</tr>
{foreach from=$l item=lt}
	<tr align="left" valign="top">
		<td class="text11">
			<li><a href="http://{$ENV.site.domain}/{$ENV.section}/{$lt.last_date}/{$lt.path}/"><b>{$lt.name}</b></a></li>
		</td>	
	</tr>
{/foreach}
</table>
{/foreach}