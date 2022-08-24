<br/>
<!-- begin content -->
{if count($res.list)>0}
<table width="100%"  border="0" cellspacing="1" cellpadding="5">
	<tr class="block_title2">
		<th align="center" class="dopp">Дата</th>
		<th align="center" class="dopp">Название семинара (тренинга)</th>
	</tr>
	{excycle values="#FFFFFF,#f5f9fa"}
	{foreach from=$res.list item=l}
	<tr bgcolor="{excycle}">
		<td width="120" align="center" valign="top">
		{if $l.begin|date_format:"%m"==$l.end|date_format:"%m"}
		{if $l.begin|date_format:"%e"!=$l.end|date_format:"%e"}{$l.begin|date_format:"%e"|replace:" ":""}-{/if}{$l.end|date_format:"%e"|replace:" ":""} {$l.begin|month_to_string:2}
		{else}
		{$l.begin|date_format:"%e"} {$l.begin|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.begin|date_format:"%Y"} {/if} - {$l.end|date_format:"%e"|replace:" ":""} {$l.end|month_to_string:2} {if $l.begin|date_format:"%y"!=$l.end|date_format:"%y"}{$l.end|date_format:"%Y"} {/if}
		{/if}
		</td>
		<td> <a href="/{$SITE_SECTION}/{$l.id}.html">{$l.name} ({$l.company}) </a><br>
		</td>
	</tr>
	{/foreach}
</table>
{else}
	<br/>Нет ни одного семинара.
{/if}
<!-- end content -->
