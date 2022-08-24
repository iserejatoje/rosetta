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

	<tr>
		<td class="block_content">
			{if !empty($l.ThumbnailImg.file)}<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="left" border="0"></a>{/if}
			<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank">
			{if $l.TitleType==2}
				<font style='font-size:18px;'>{$l.TitleArr.name}</font>,<br/>{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
			{else}
				<b>{$l.Title}</b>
			{/if}</a>{if $l.add_material==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.add_material==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br>
			{if $l.TitleType!=2}  {$l.Anon|truncate:400:"...":true}  {/if} 
		</td>
	</tr>
{if !empty($l.Comment)}
	<tr>
				<td class="otzyv" style="padding-top:2px"><em>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</em> {$l.Comment.Text|truncate:30:"...":false}
				<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html?p=last#comment`$l.Comment.CommentID`"|escape:"url"}" target="_blank" title="Читать далее">далее</a>
				</td>
	</tr>
{/if}
	
	
</table>
{/foreach}