<table width="100%" class="block_main" cellspacing="0" cellpadding="0" border="0">
<tr><th><span>{$res.title}</span></th><th width="97"><img src="/_img/design/200710_dom/gorod_blue.gif"></th></tr>
</table>
<table width="100%" class="block_main" cellspacing="3" cellpadding="0">
{foreach from=$res.list item=l key=y}

	<tr align="center"><td>
		{if $l.ThumbnailImg.file }
		{if $CURRENT_ENV.site.domain != $ENV.site.domain }<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}">{else}
                 <a href="{$l.Link}{$l.NewsID}.html"> {/if}
                 <img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
                <span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2} {$l.Date|date_format:"%Y"}</span><br/>
{if $CURRENT_ENV.site.domain != $ENV.site.domain }<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" class="anon"> {else}
<a href="{$l.Link}{$l.NewsID}.html" class="anon"> {/if}<span class="anon_name">
		{if $l.TitleType==2}
			{$l.TitleArr.name},</span><br/><span class="anon_position">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
		{else}
		<b>{$l.Title}</b>
		{/if}</span></a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if !empty($l.Comment)}
					<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b>
					<span class="bl_otziv">{$l.Comment.Text|truncate:40:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a>
			{/if}
		</td>
	</tr>
{/foreach}
</table>