<table width="100%" class="block_right" cellspacing="0" cellpadding="0">
<tr><td class="zag3" style="padding-left:5px; padding-top: 10px;">{$res.title}</td></tr>
</table>
<table width="100%" class="block_right" cellspacing="3" cellpadding="0">
{foreach from=$res.list item=l key=y}
	<tr><td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;" /></a>
			{/if}
		
		{if $l.TitleType==2}
			<a href="{$l.Link}{$l.NewsID}.html" class="zag2">{$l.TitleArr.name}</a>,
			<br/>{$l.TitleArr.position}: <b>{$l.TitleArr.text}</b>
		{else}
			<a href="{$l.Link}{$l.NewsID}.html" class="zag2">{$l.Title}</a>
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
	<tr>
		<td>
			<div class="otzyv">
{if !empty($l.Comment)}
				<span class="zag3">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> <span class="comment_time">{$l.Date|date_format:"%e.%m"}:</span><span class="txt">{$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><img src="/_img/design/200805_afisha/bull1.gif" width="12" height="14" border="0" /></a></span>
{else}
<br />
{/if}
			</div>
		</td>
	</tr>
	<tr valign="bottom"><td>
{/foreach}
	</td></tr>
</table>