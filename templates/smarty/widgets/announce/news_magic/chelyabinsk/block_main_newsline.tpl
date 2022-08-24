{if !empty($res.list)}
<table border="0" cellpadding="3" cellspacing="0" width="100%" class="block_main">
<tr bgcolor="#dddddd"><th><span>{$res.title}</span></th></tr>
<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="4" border="0" alt="" /></td></tr>
</table>
{/if}
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="block_main">
	{foreach from=$res.list item=l key=i}
	{if $i!=0}
	<tr><td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td></tr>
	{/if}
	<tr><td>
		<table cellpadding="3" cellspacing="0" border="0">
		<tr><td class="bl_date">{$l.Date|date_format:"%H:%M"}</td>
			<td class="bl_date1">{$l.Date|date_format:"%e.%m.%Y"}</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr><td>
		<table cellpadding="0" cellspacing="0" border="0">
		<tr><td>
			<span class="title2"><a name="{$l.NewsID}"></a><a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}">{$l.Title}</a></span>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td></tr>
		</table>
	</td></tr>
	<tr><td><div>
	{if $l.ThumbnailImg.file }
		<a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
	{/if}
	{if $i>0}
	{$l.Anon|strip_tags|truncate:200:"...":false}
	{else}
	{$l.Anon|strip_tags|truncate:650:"...":false}
	{/if}
	&nbsp;<a href="{$l.Link}{$l.Date|date_format:"%Y"}/{$l.Date|date_format:"%m"}/{$l.Date|date_format:"%d"}/#{$l.NewsID}" class="ssyl">далее</a>
	</div></td><tr>
	{/foreach}
</table>