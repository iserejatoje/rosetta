{if count($BLOCK.res.list)>0}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr align="right">
		<td class="block_title_obl"><span>{$GLOBAL.title[$BLOCK.section]}</span></td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
{foreach from=$BLOCK.res.list item=l}
	<tr>
		<td valign="top" style="padding-left: 8px;" class="gl">
			<b>
			{if $l.begin|date_format:"%m"==$l.end|date_format:"%m"}
			{if $l.begin|date_format:"%e"!=$l.end|date_format:"%e"}{$l.begin|date_format:"%e"|replace:" ":""}-{/if}{$l.end|date_format:"%e"|replace:" ":""} {$l.begin|month_to_string:2}
			{else}
			{$l.begin|date_format:"%e"} {$l.begin|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.begin|date_format:"%Y"} {/if} - {$l.end|date_format:"%e"|replace:" ":""} {$l.end|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.end|date_format:"%Y"} {/if}
			{/if}
			</b>
		</td>
	</tr>
	<tr>
		<td style="padding-left: 8px;"><a href="/{$BLOCK.section}/{$l.id}.html"><b>{$l.name}</b></a> ({$l.company})</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" height="8"></td>
	</tr>
{/foreach}
	<tr>
		<td align="right"><a href="/{$BLOCK.section}/" class="text11">Все семинары</a></td>
	</tr>
</table>
{/if}