<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
		<td>
		<table border=0 cellpadding="0" cellspacing="3" width=100%>
			<tr><td align="left" class="block_title_obl" style="padding-left: 5px;"><span>{if $res.module_title}{$res.module_title}{else}{$ENV.site.title[$ENV.section]}{/if}</span></td></tr> 
		</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width="1" height="3"></td>
	</tr>
	<tr>
		<td class="block_content">
			<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank">
			        {if !empty($res.firm.io)}
				<font style='font-size:18px;'>{$res.firm.io}&nbsp;{$res.firm.name}</font>,<br/>{$res.firm.employment}<br><br>
				{else}
				<font style='font-size:18px;'>{$res.firm.name}</font>{if !empty($res.firm.employment)},<br/>{$res.firm.employment}{/if}<br><br>
				{/if}
{*<font style='font-size:18px;'>{$res.firm.io}</font>,<br/>{$res.firm.employment}<br><br><b>{$res.firm.name}</b> *}
			</a>
		</td>
	</tr>
	<tr>
		<td class="block_content">
			{if !empty($res.firm.uinfo.Photo)}<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank"><img src="{$res.firm.uinfo.Photo.Url}" width="{$res.firm.uinfo.Photo.Width}" height="{$res.firm.uinfo.Photo.Height}" border="0"></a>{/if}
		</td>
	</tr>
	{if !empty($res.firm.otz.list)}
	{foreach from=$res.firm.otz.list item=o}
	<tr>
		<td class="otzyv" style="padding-top:2px">
			<em>{$o.name}</em>: {$o.otziv|truncate:50:"...":true} <a href="/service/go/?url={"`$o.url`"|escape:"url"}" target="_blank"><small>&gt;&gt;</small></a>
		</td>
	</tr>
	{/foreach}
	{/if}
</table>