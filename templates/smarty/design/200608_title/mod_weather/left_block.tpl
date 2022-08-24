<br>
{foreach from=$left.leftmenu item=l}
<table width="100%" cellpadding="0" cellspacing="3" border="0">
<tr align="right">
	<td class="block_title_obl"><span>{$l.name}</span></td>
</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
{foreach from=$l.list item=ls}
	<tr align="right" valign="top">
	<td class="text11"><a href="/{$ENV.section}/weather{$left.days}/{$ls}.html"><b>{$left.cities[$ls][0]}</b> {if $left.cities[$ls][2]!=""}({$left.cities[$ls][2]}){/if}</a></td>	
	<td width="10px"></td>
	</tr>
{/foreach}
</table>
<br>
{/foreach}