{if !empty($res.list)}
<table cellpadding="3" cellspacing="0" border="0" width="100%">
	<tr>
		<td bgcolor="#D1E6F0" class=title style="white-space: nowrap">
			<EM><IMG src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</EM>
		</td>
	</tr>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="3">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
	<tr> 
		<td valign="top" class="menu-klass" align="center" bgcolor="#FFFFFF">
			<a href="{$l.Link}{$l.NewsID}.html">
			{if $l.TitleType==2}
				{$l.TitleArr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
			{else}
				{$l.Title}
			{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td>
	<tr>
	<tr>
		<td align="left" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{$l.Anon}
		</td>
	<tr>
	{if !empty($l.Comment) }
		<tr>
			<td style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.User.Name)}{*<a href="{$l.Comment.User.InfoUrl}">*}{$l.Comment.User.Name|truncate:20:"...":false}{*</a>*}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> {$l.Comment.Text|truncate:80:"...":false}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><small>&gt;&gt;</small></a>
			</td>
		</tr>
	{/if}
	{/foreach}
{else}
{* это случай без текста, здесь все форматировано по центру *}
{foreach from=$res.list item=l key=k}
	<tr> 
		<td valign="top" class="menu-klass" align="center" bgcolor="#FFFFFF">
			{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html" class="bl_title_news">{
			if $l.TitleType==2}<b>{$l.TitleArr.name}</b>,<br />{$l.TitleArr.position}{
			else}<b>{$l.Title}</b>{/if}</a>
			
			{if !empty($l.Comment) }
			<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
			<div align="left">
				<div class="text11"><b><font class="user">{if !empty($l.Comment.User.Name)}{*<a href="{$l.Comment.User.InfoUrl}">*}{$l.Comment.User.Name|truncate:20:"...":false}{*</a>*}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
				{$l.Comment.Created|date_format:"%e.%m"}:</font></b> {$l.Comment.Text|truncate:40:"...":false}
				<a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><img src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" align="middle" alt="Читать далее" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"></div>
			</div>
			{/if}
		</td>
	</tr>
	<tr>
		<td bgcolor="#F3F3F3" style="padding: 1px"><img src="/_img/x.gif" width="1" height="1" alt="" /></td>
	</tr>
{/foreach}
{/if}
</table>
{/if}
