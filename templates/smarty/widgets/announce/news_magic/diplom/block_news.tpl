<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td width="37">
<img width="37" height="35" src="/_img/design/200710_diplom/icostat.gif"/>
</td>
<td valign="top" style="background:url(/_img/design/200710_diplom/backnews.gif) repeat-x;" align="right">
<font class="zag1-1">{$res.title}</font>
</td>
</tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr>
		{*<td width="37">&nbsp;</td>*}
		<td align="left" style="padding-bottom:2px;">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{if $l.TitleType==2}
			<a href="{$l.Link}{$l.NewsID}.html"><font class="zag2">{$l.TitleArr.name}</font></a>,<br/>{$l.TitleArr.position}
		{else}
			<a href="{$l.Link}{$l.NewsID}.html"><font class="zag2">{$l.Title}</font></a>
		{/if}
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td></tr>
		{*<tr>
		<td width="37">&nbsp;</td>
		<td align="left" style="padding-bottom:2px">
		{foreach from=$l.Anon item=Anon key=k}
		{if $k<3 }{$Anon}{/if}
		{/foreach}
		</td></tr>*}
		<tr><td>&nbsp;</td></tr>
		{if !empty($l.Comment)}
				<tr>
		{*		<td width="37">&nbsp;</td>*}
				<td align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> 
				{$l.Comment.Text|truncate:40:"...":false}
				<a href='{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}'><small>&gt;&gt;</small></a>
				</td></tr>
		{/if}
	{/foreach}
{else}
{* это случай без текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		<tr><td><div align="center" style="padding:0px"><span class="bl_date_news">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></div></td></tr>
		<tr><td style="padding-bottom:2px"><div align="center" class="bl_body">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.Title|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
			<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news">
			{if $l.TitleType==2}
				<b>{$l.TitleArr.name}</b>,<br /><font style="text-decoration:none;">{$l.TitleArr.position}</font>
			{else}
				<b>{$l.Title}</b>
			{/if}</a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</div>
		{if !empty($l.Comment)}
				<div class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> 
				{$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a>
				</div>
		{/if}
		</td></tr>
	{/foreach}
{/if}
</table>
