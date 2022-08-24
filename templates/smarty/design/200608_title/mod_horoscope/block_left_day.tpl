<br/>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr align="right">
		<td class="block_title_obl"><span>ГОРОСКОП НА ДЕНЬ</span></td>
	</tr>
	<tr>
		<td align="right"><small style="color:#CCCCCC">{$res.date|strtotime|date_format:"%d.%m.%Y"}</small></td>
	</tr>
</table>
<table width="100%" cellpadding="4" cellspacing="0" border="0">
{foreach from=$res.menu item=l key=k}
	<tr align="right" valign="top">
		<td class="text11">
		{if $k!=$res.sign || $res.page != 'day'}
			<a href="http://{$ENV.site.domain}/{$ENV.section}/day/{if $res.err}{$res.date}/{/if}{$k}.html"><b>{$l.title}</b> ({$l.diap})</a>
		{else}
			<b>{$l.title}</b> ({$l.diap})
		{/if}
		</td>	
		<td>
			<a href="http://{$ENV.site.domain}/{$ENV.section}/day/{if $res.err}{$res.date}/{/if}{$k}.html"><img src="{$res.pic_dir}{$l.img}" width="14" height="14" border="0" alt="{$l.title}"></a>
		</td>
		<td width="10px"></td>
	</tr>
{/foreach}
	<tr>
		<td class="text11" align="right"><br>
		{if $res.sign || $res.page != 'day'}
			<a href="http://{$ENV.site.domain}/{$ENV.section}/day/{if $res.err}{$res.date}/{/if}all.html"><b>Все знаки</b></a>
		{else}
			<b>Все знаки</b>
		{/if}		
		</td>
	</tr>
</table>
<br/>