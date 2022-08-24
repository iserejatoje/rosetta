<div align="left" class="block_title_left">
	<span><a target="_blank" href="{$res.url|escape}">{$res.title}</a></span>
</div>
<table cellspacing="0" cellpadding="3" border="0" width="100%">
<tr><td>
	<table cellspacing="0" cellpadding="1" border="0">
	{foreach from=$res.list item=ls}
	<tr><td><img src="/_img/x.gif" alt="" border="0" width="1" height="2"></td></tr>
	<tr><td><b>{$ls.name}</b></td></tr>
	{foreach from=$ls.list item=l}
		<tr><td align="left" class="s1"><a href="{$l.url}">{$l.Name}</a></td></tr>
	{/foreach}
	{/foreach}
	</table>
</td>
</tr>
<tr><td><img src="/_img/x.gif" border="0" alt="" width="1" height="2" /></td></tr>
<tr><td class="otzyv"><a href="{$res.url}" target="_blank">Все предложения</a> (<b>{$res.count}</b>)</td></tr>
</table>