{if is_array($res.list) && sizeof($res.list)}
<table width="100%"  border="0" cellspacing="0" cellpadding="2">
<tr>
	<td bgcolor="#C3E6EA"><font class="zag1">{$ENV.site.title[$ENV.section]}</font></td>
</tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><img src="/_img/x.gif" width="1" height="5" /></td>
	</tr>
	{foreach from=$res.list item=p}
	<tr bgcolor="#EEF9DF"><td align="left" style="padding-bottom:5px;">
		<a href="/{$ENV.section}/{$p.link}" class="zag1">{$p.name}</a>
	</td></tr>
	{if is_array($p.img1) && isset($p.img1.url)}
	<tr><td class="ssyl" align="center">
		<a href="/{$ENV.section}/{$p.link}" class="zag2"><img src="{$p.img1.url}" alt="{$p.name|escape:"quotes"}" style="margin-top:3px;margin-bottom:3px;" border="0" /></a>
	</td></tr>
	{/if}
	<tr><td class="ssyl">
		{$p.anon}
	</td></tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="10" /></td>
	</tr>
	{/foreach}
</table>
{/if}
