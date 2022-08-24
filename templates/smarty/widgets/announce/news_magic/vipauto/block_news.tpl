<table cellpadding="3" cellspacing="0" border="0" class="ltext" width=100%>
<tr><td bgcolor="#F3F0D6" class="rantitle" align="left">{$res.title}</td></tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="ltext" width=100%>
<tr><td bgcolor="#FFFFFF" height="1"><img height="1" src="/_img/x.gif"></td></tr>
</table>
<table cellpadding="5" cellspacing="0" border="0" class="ltext" width=100%>
{if $reslist.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr> 
			<td valign=top align=center {if $SITE_SECTION!='forum'}bgcolor="#FCF9DD"{else} class="ltext"{/if}>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html">
			{if $l.TitleType==2}
				<b>{$l.TitleArr.name}</b>, {$l.TitleArr.position}
			{else}
				<b>{$l.Title}</b>
			{/if}
			</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br />
			{foreach from=$l.Anon item=Anon key=k}
			{if $k<3 }<img src="/_img/design/200710_vipauto/bull_main.gif" width="12" height="12" align="absmiddle" border="0" alt="-" />&nbsp;{$Anon}{/if}
			{/foreach}

			{if !empty($l.Comment)}
				<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
				<div align="left" {if $SITE_SECTION=='forum'}class="ltext"{/if} >
					<b><font class="user">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
					{$l.Comment.Created|date_format:"%e.%m"}:</font></b>
					&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_vipauto/str.gif" width="10" height="10" border="0" align="middle" alt="читать далее" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				</div>
			{/if}
			</td>
		</tr>
	{/foreach}
{else}
{* это случай бес текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=y}
		<tr> 
			<td valign="top" align="center" bgcolor="#FCF9DD">
				{if $l.TitleType==1 }
				{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
				{if $l.ThumbnailImg.file }
					<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
				<a href="{$l.Link}{$l.NewsID}.html">
				{if $l.TitleType==2}
					<b>{$l.TitleArr.name}</b>,<br />{$l.TitleArr.position}
				{else}
					<b>{$l.Title}</b>
				{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
				{if !empty($l.Comment)}
					<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
					<div align="left">
						<b><font class="user">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
						{$l.Comment.Created|date_format:"%e.%m"}:</font></b>
						&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_vipauto/str.gif" width="10" height="10" border="0" align="middle" alt="читать далее" /></a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
					</div>
				{/if}
			</td>
		</tr>
	{/foreach}
{/if}
<tr><td bgcolor="#FCF9DD" height="3"><img height="5" width="1" src="/_img/x.gif"></td></tr>
</table>