	{foreach from=$res.list item=l key=y}
		<table cellpadding="3" cellspacing="0" border="0" class="ltext" width=100%>
		<tr><td bgcolor="#F3F0D6" class="rantitle" align="left">{$res.title}</td><td bgcolor="#F3F0D6" align="right">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</td></tr>
		</table>
		<table cellpadding="5" cellspacing="0" border="0" class="ltext" width=100%>
		<tr> 
			<td valign=top align="left">
				{if $l.ThumbnailImg.file }
					<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
				{/if}
				<a href="{$l.Link}{$l.NewsID}.html" class="cantitle">
				{if $l.TitleType==2}
					<b>{$l.TitleArr.name}</b>, {$l.TitleArr.position}
				{else}
					<b>{$l.Title}</b>
				{/if}
				</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
				{foreach from=$l.Anon item=Anon key=k}
				{if $k<3}<br /><img src="/_img/x.gif" width="1" height="4" border="0"><br />{$Anon|truncate:120:"...":false}{/if}
				{/foreach}
		</td><tr>
		<tr> 
			<td valign=top align="left">
				{if !empty($l.Comment)}
						<b><font class="user">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
						{$l.Comment.Created|date_format:"%e.%m"}:</font></b>
						&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_vipauto/str.gif" width="10" height="10" border="0" align="middle" alt="читать далее" /></a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/if}
			</td>
		</tr>
		</table>
	{/foreach}