{foreach from=$res.list item=l}
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<!--regid={$CURRENT_ENV.regid}-->
	<tr>
		<td>
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"`$l.Link`"|escape:"url"}" target="_blank" class="spec3">
					{$res.title}
					</a></td>{if $withdate}<td>&nbsp;{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</td>{/if}</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td class="block_content">
			{if !empty($l.ThumbnailImg.file)}<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="left" border="0"></a>{/if}
			<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" target="_blank" class="spec4">
			{if $l.TitleType==2}
				<font style='font-size:18px;'>{$l.TitleArr.name}</font>,<br/>{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
			{else}
				<b>{$l.Title}</b>
			{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br>
			{if $l.TitleType!=2}  {$l.Anon|truncate:400:"...":true}  {/if} 
		</td>
	</tr>
{if !empty($l.Comment)}
	<tr>
				<td class="otzyv" style="padding-top:2px"><em>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</em> <font class="spec5">{$l.Comment.Text|truncate:30:"...":false}</font>
				<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html?p=last#comment`$l.Comment.CommentID`"|escape:"url"}" target="_blank" title="Читать далее">далее</a>
				</td>
	</tr>
{/if}
	
	
</table>
{/foreach}