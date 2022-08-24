<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!--regid={$CURRENT_ENV.regid}-->
	<tr>
		<td>
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank">{$ENV.site.title[$ENV.section]}</a></td>{if $withdate}{/if}</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="block_content">
			{if !empty($res.firm.uinfo.Photo)}<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank"><img src="{$res.firm.uinfo.Photo.Url}" width="{$res.firm.uinfo.Photo.Width}" height="{$res.firm.uinfo.Photo.Height}" align="left" border="0"></a>{/if}
			<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank">
				<font style='font-size:18px;'>{$res.firm.uinfo.LastName}{if !empty($res.firm.uinfo.FirstName)} {$res.firm.uinfo.FirstName}{/if}{if !empty($res.firm.uinfo.MidName)} {$res.firm.uinfo.MidName}{/if}</font>,<br/>{$res.firm.uinfo.Position}<br><br><b>{$res.firm.name}</b>
			</a>
		</td>
	</tr>
	{if !empty($res.firm.otz.list)}
	{foreach from=$res.firm.otz.list item=o}
	<tr>
		<td class="otzyv" style="padding-top:2px">
			<em>{$o.name}</em>: {$o.otziv|truncate:50:"...":true} <a href="/service/go/?url={"`$o.url`"|escape:"url"}" target="_blank">далее</a>
		</td>
	</tr>
	{/foreach}
	{/if}
</table>