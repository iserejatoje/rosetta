<br />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td class="block_title3">
			{capture name="sy"}{$res.date|date_format:"%Y"}{/capture}
			<span>Гороскоп на {$res.date|date_format:"%e"} {$res.date|date_format:"%m"|month_to_string:2} {$smarty.capture.sy} г.</span>
		</td>
	</tr>
</table>


<table cellpadding="10" cellspacing="0" border="0" width="100%">
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="padding-right:25px;">
		{if $res.prev_day}<a href="/{$ENV.section}/day/{$res.prev_day|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">{$res.prev_day|date_format:"%d"} {$res.prev_day|date_format:"%m"|month_to_string:2}</a>{/if}
		{if $res.prev_day && $res.next_day} | {/if}
		{if $res.next_day}<a href="/{$ENV.section}/day/{$res.next_day|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">{$res.next_day|date_format:"%d"} {$res.next_day|date_format:"%m"|month_to_string:2}</a>{/if}
		</td>
	</tr>
{foreach from=$res.horos item=l}
	<tr>
		<td width="35" align="center"><img src="{$l.img}" width="31" height="31" alt="{$l.title}"></td>
		<td class="t_dw" align="left" width="100%">{$l.title}</td>
	</tr>
	<tr>
		<td colspan="2" align="justify">
			{$l.text}
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" /></td>
	</tr>
{/foreach}
	<tr>
		<td colspan="2" align="right" style="padding-right:25px;">
		{if $res.prev_day}<a href="/{$ENV.section}/day/{$res.prev_day|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">{$res.prev_day|date_format:"%d"} {$res.prev_day|date_format:"%m"|month_to_string:2}</a>{/if}
		{if $res.prev_day && $res.next_day} | {/if}
		{if $res.next_day}<a href="/{$ENV.section}/day/{$res.next_day|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">{$res.next_day|date_format:"%d"} {$res.next_day|date_format:"%m"|month_to_string:2}</a>{/if}
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text11">
			<br><br><br><br><br><br><br><br><br><br><br><br>
			Информация предоставлена <a href="http://ignio.com/" target="_blank">Ignio</a></font><br/>
		</td>
	</tr>
</table>