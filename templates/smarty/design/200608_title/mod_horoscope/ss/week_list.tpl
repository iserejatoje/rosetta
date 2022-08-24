<br />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td class="block_title3">
			{capture name="sy"}{$res.date_start|date_format:"%Y"}{/capture}
			{capture name="ey"}{$res.date_end|date_format:"%Y"}{/capture}
			<span>Гороскоп на неделю {$res.date_start|date_format:"%e"} {$res.date_start|date_format:"%m"|month_to_string:2} {if $smarty.capture.ey!=$smarty.capture.sy}{$smarty.capture.sy} г. {/if}- {$res.date_end|date_format:"%e"} {$res.date_end|date_format:"%m"|month_to_string:2} {$smarty.capture.ey} г.</span>
		</td>
	</tr>
</table>

<table cellpadding="10" cellspacing="0" border="0" width="100%">
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" /></td>
	</tr>
	<tr>
		<td colspan="2" align="right" style="padding-right:25px;">
		{if $res.prev_week}<a href="/{$ENV.section}/week/{$res.prev_week|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">Предыдущая неделя</a>{/if}
		{if $res.prev_week && $res.next_week} | {/if}
		{if $res.next_week}<a href="/{$ENV.section}/week/{$res.next_week|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">Следующая неделя</a>{/if}
		</td>
	</tr>
{foreach from=$res.horos item=l}
	<tr>
		<td width="35" align="center"><img src="{$l.img}" width="31" height="31" alt="{$l.title}"></td>
		<td class="t_dw" align="left" width="100%">{$l.title} ({$l.diap})</td>
	</tr>
	<tr>
		<td colspan="2" align="justify">
			{$l.descr}
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="/_img/x.gif" width="1" height="15" border="0" /></td>
	</tr>
{/foreach}
	<tr>
		<td colspan="2" align="right" style="padding-right:25px;">
		{if $res.prev_week}<a href="/{$ENV.section}/week/{$res.prev_week|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">Предыдущая неделя</a>{/if}
		{if $res.prev_week && $res.next_week} | {/if}
		{if $res.next_week}<a href="/{$ENV.section}/week/{$res.next_week|date_format:"%Y-%m-%d"}/{if $res.sign}{$res.sign}{else}all{/if}.html">Следующая неделя</a>{/if}
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text11">
			<br><br><br><br><br><br><br><br><br><br><br><br>
			Информация предоставлена <a href="http://ignio.com/" target="_blank">Ignio</a></font><br/>
		</td>
	</tr>
</table>