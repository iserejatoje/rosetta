{foreach from=$res.list item=l}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!--regid={$CURRENT_ENV.regid}-->
	<tr>
		<td>
<div style="width: 100%; background-image: url(/_img/design/200608_title/logo_ny/ng_bg3.gif); height: 29px;">
<div style="background-image: url(/_img/design/200608_title/logo_ny/ng_header3.gif); background-repeat: no-repeat; background-position: left top; height: 29px;">
<div style="background-image: url(/_img/design/200608_title/logo_ny/ng_header3r.gif); background-repeat: no-repeat; background-position: right top; height: 29px;"></div>
</div>
</div>
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