<table width="100%" class="block_main" cellspacing="0" cellpadding="0" border="0">
<tr><th><span>{$res.title}</span></th>
		<th width="97"><img src="/_img/design/200710_dom/gorod_blue.gif"></th>
</tr>
</table>
<table width="100%" class="block_main" cellspacing="3" cellpadding="0">
{foreach from=$res.list item=l key=y}
	<tr><td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;" /></a>
			{/if}
		
		{if $l.TitleType==2}
			<span class="bl_title"><a href="{$l.Link}{$l.NewsID}.html" class="zag2">{$l.TitleArr.name}</a></span>,
			<br/>{$l.TitleArr.position}: <b>{$l.TitleArr.text}</b>
		{else}
			<span class="bl_title"><a href="{$l.Link}{$l.NewsID}.html" class="zag2">{$l.Title}</a></span>
		{/if}{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:80:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
{/foreach}
</table>

<table width="100%" class="block_main" cellspacing="0" cellpadding="0" border="0">
	<tr><th><span>{$CURRENT_ENV.site.title[$ENV.section]}</span></th>
		<th width="97"><img src="/_img/design/200710_dom/gorod_blue.gif"></th>
	</tr>
</table>
<table width="100%" class="block_main" cellspacing="0" cellpadding="0" border="0">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr align="right"><td><span>{$l.date|date_format:"%e"} {$l.date|month_to_string:2} {$l.date|date_format:"%Y"}</span></td></tr>
	<tr valign="bottom"><td>
{/if}
	<div><span class="bl_date">{$l.date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}" {if $l.Order>0}style="color:red;"{/if}>{$l.name}</a></span></div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
