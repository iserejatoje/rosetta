<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!--regid={$CURRENT_ENV.regid}-->
	<tr>
		<td>
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank">{if $res.module_title}{$res.module_title}{else}{$ENV.site.title[$ENV.section]}{/if}</a></td>{if $withdate}{/if}</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="block_content">
			{if !empty($res.firm.uinfo.Photo)}<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank"><img src="{$res.firm.uinfo.Photo.Url}" width="{$res.firm.uinfo.Photo.Width}" height="{$res.firm.uinfo.Photo.Height}" align="left" border="0"></a>{/if}
			<a href="/service/go/?url={"`$res.firm.url`"|escape:"url"}" target="_blank">
			        {if !empty($res.firm.io) || !empty($res.firm.employment)}
				<font style='font-size:18px;'>{$res.firm.io}&nbsp;{$res.firm.name}</font>,<br/>{$res.firm.employment}<br />
				{else}
				<font class="block_content"><b>{$res.firm.name}</b></font><br />
				{/if}
				<b>{$res.firm.rub_name}</b><br />
			</a>
			{if empty($res.firm.io) && empty($res.firm.employment)}
				{if !empty($res.firm.anonce)}<br/>{$res.firm.anonce|strip_tags|truncate:250:"...":true}{/if}
			{/if}
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