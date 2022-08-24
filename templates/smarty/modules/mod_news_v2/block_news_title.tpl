{foreach from=$res.list item=l}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!--regid={$CURRENT_ENV.regid}-->
	<tr>
		<td>
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				{if !empty($l.group)}{assign var="_group" value="`$l.group`"}{else}{assign var="_group" value=""}{/if}
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/`$_group`"|escape:"url"}" target="_blank">
					{assign var="_sid" value="`$ENV.section`/`$l.group_name`"}
					{if !empty($ENV.site.title[$_sid])}{$ENV.site.title[$_sid]}{else}{$ENV.site.title[$ENV.section]}{/if}
					</a></td>{if $withdate}<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>{/if}</tr>
			</table>
		</td>
	</tr>
{*
	<tr>
		<td>
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="t13_grey2" align="left" style="padding:1px;padding-left:10px;padding-right:10px;">{$ENV.site.title[$ENV.section]}</td>{if $withdate}<td>&nbsp;{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</td>{/if}</tr>
				<tr><td align="left" height=1 bgcolor="#666666"><img src="/_img/x.gif" width="1" height="1" border="0" alt="" /></td><td></td></tr>
			</table>
		</td>
	</tr>
*}
	<tr>
		<td class="block_content">
			{if !empty($l.img1)}<a href="/service/go/?url={"`$l.url`"|escape:"url"}" target="_blank"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" align="left" border="0"></a>{/if}
			<a href="/service/go/?url={"`$l.url`"|escape:"url"}" target="_blank">
			{if $l.type==2}
				<font style='font-size:18px;'>{$l.name_arr.name}</font>,<br/>{$l.name_arr.position}{if $l.name_arr.text}: <b>{$l.name_arr.text}</b>{/if}
			{else}
				<b>{$l.name}</b>
			{/if}</a>{if $l.add_material==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.add_material==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br>
			{if $l.type!=2}  {$l.anon[0]|truncate:400:"...":true}  {/if} 
		</td>
	</tr>
	{if !empty($l.otz.list)}
	{foreach from=$l.otz.list item=o}
	<tr>
		<td class="otzyv" style="padding-top:2px">
			<em>{$o.name}</em>: {$o.otziv|truncate:30:"...":true} <a href="/service/go/?url={"`$o.url`"|escape:"url"}" target="_blank">далее</a>
		</td>
	</tr>
	{/foreach}
	{/if}
</table>
{/foreach}