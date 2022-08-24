
<table cellpadding=0 cellspacing=0 border=0 width=100% bgcolor="#e9e8e5">
<tr><td width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=5></td>
<td bgcolor="#e9e8e5" class=menu align="left"><b>{$res.title}</b></td>
<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=15></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="menu-klass">
{if $res.withtext==1 }
	{foreach from=$res.list item=l}
		<tr valign="top" bgcolor="#F5F5F5">
			<td align="left">
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html">{if $l.TitleType==2}<b>{$l.TitleArr.name}</b>, {$l.TitleArr.position}{else}<b>{$l.Title}</b>{/if}</a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
			<br />
			{foreach from=$l.Anon item=Anon key=k}
			{if $k<1 }{$Anon}{/if}
			{/foreach}
			{if !empty($l.Comment)}
				<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
				<div align="left">
					<b><font color="#FF6701">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
					{$l.Comment.Created|date_format:"%e.%m"}:</font></b>
					&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_chelmash/common/arruk.gif" width="6" height="7" border="0" align="middle" alt="читать далее" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				</div>
			{/if}
		</td></tr>
	{/foreach}
{else}
	{foreach from=$res.list item=l}
		<tr valign="top" bgcolor="#F5F5F5">
		{if $BLOCK.list.TitleType!="news"}<td width="15" align="right"></td>{/if}
			<td align="center">
			{if $BLOCK.list.TitleType=="news"}
				{$l.Date|date_format:"%e.%m"}
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{/if}
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.name|strip_tags}" /></a>
				<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html">{if $l.TitleType==2}<b>{$l.TitleArr.name}</b>,<br />{$l.TitleArr.position}{else}<b>{$l.name}</b>{/if}</a>
			{if !empty($l.Comment)}
				<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
				<div align="left">
					<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
					{$l.Comment.Created|date_format:"%e.%m"}:</font></b>
					&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_chelmash/common/arruk.gif" width="6" height="7" border="0" align="middle" alt="читать далее" /></a>
				</div>
			{/if}
		</td></tr>
	{/foreach}
{/if}
</table>
