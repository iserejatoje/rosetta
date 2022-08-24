{if !empty($res.list)}
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td style="width: 20px; background: url(/_img/design/200710_auto/backleft.gif)" valign="top">
		<img src="/_img/design/200710_auto/left-anons.gif" width="20">
	</td>
	<td valign="top" width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_left">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr><td align="left" style="padding-bottom:2px;">
		<a href="{$l.Link}{$l.NewsID}.html">
		{if $l.TitleType==2}
			{$l.TitleArr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
		{else}
			{$l.Title}
		{/if}
		</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td><tr>
		<tr><td align="left" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{foreach from=$l.Anon item=Anon key=k}
		{if $k<3 }{$Anon}{/if}
		{/foreach}
		</td><tr>
		{if !empty($l.Comment) }
			{*foreach from=$l.Comment item=o}
				<tr><td align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{$o.User.Name}:</b></span> {$o.Text|truncate:40:"...":false}
				<a href='/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$o.CommentID}'><small>&gt;&gt;</small></a>
				</td></tr>
			{/foreach*}
			<tr>
			<td  align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</td>
		</tr>
		{/if}
	{/foreach}
{else}
{* это случай без текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		<tr><td><div align="center" style="padding:0px"><span class="bl_date_news">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></div></td></tr>
		<tr><td style="padding-bottom:2px"><div align="center" class="bl_body">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
			<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news">
			{if $l.TitleType==2}
				<b>{$l.TitleArr.name}</b>,<br /><font style="text-decoration:none;">{$l.TitleArr.position}</font>
			{else}
				<b>{$l.Title}</b>
			{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</div>
		{if !empty($l.Comment)}
			{*foreach from=$l.otz.list item=o}
				<div class="comment_descr">
				<span class="comment_name"><b>{$o.name|truncate:20:"...":false}:</b></span> {$o.otziv|truncate:40:"...":false}
				<a href="{$o.url}"><small>&gt;&gt;</small></a>
				</div>
			{/foreach*}
			<div class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</div>
		{/if}
		</td></tr>
	{/foreach}
{/if}
</table>
	</td>
</tr>
</table>
{/if}