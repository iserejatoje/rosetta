{foreach from=$res.list item=l key=k}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr align="right">
		<td class="block_title_obl"><span>{$res.menu[$k]}</span></td>
	</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
{foreach from=$l item=lt}
	<tr align="right" valign="top" {if $lt.selected}class="bg_color4"{/if}>
		<td class="text11">
		{if !$lt.selected}
			<a href="http://{$ENV.site.domain}/{$ENV.section}/{$lt.last_date}/{$lt.path}/"><b>{$lt.name}</b></a>
		{else}
			<b>{$lt.name}</b>
		{/if}
		</td>	
		<td width="10px"></td>
	</tr>
{/foreach}
	<tr>
		<td><img src="/_img/x.gif" height="2" width="1" alt="" /></td><td width="10px"></td>
	</tr>
</table>
{/foreach}