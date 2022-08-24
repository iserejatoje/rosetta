<table cellpadding=0 cellspacing=0 border=0 width=100%>
		<tr><td colspan=3>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td bgcolor="#e9e8e5" width=10><img src="/_img/x.gif" height=18 width=5></td>
					<td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=5></td>
					<td bgcolor="#e9e8e5" class=menu align=left><b>{$res.title}</b></td><td bgcolor="#e9e8e5" width=5><img src="/_img/x.gif" height=18 width=15></td></tr></table></td>
				</tr>
{foreach from=$res.list item=l}					
		<tr><td colspan=3><img src="/_img/x.gif" height=10 width=20></td></tr>
		<tr>{if $l.ThumbnailImg.file }
				<td><a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a></td>
			{/if}
		<td width=20><img src="/_img/x.gif" height=3 width=20></td>
		<td valign=top>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}
		<br>{if $l.TitleType==2}<a class="txt_blue" href="{$l.Link}{$l.NewsID}.html">{$l.TitleArr.name},<br />{$l.TitleArr.position}{else}<a class="txt_blue_b" href="{$l.Link}{$l.NewsID}.html">{$l.Title}{/if}</a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br><img src="/_img/x.gif" height=10 width=300><br>
		{foreach from=$l.Anon item=Anon key=k}
			{if $k<1 }{$Anon|truncate:300:"...":false}{/if}
		{/foreach}
		<br><br>
		{if !empty($l.Comment)}
			<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}</b>: 
			{$l.Comment.Text|truncate:40:"...":false} 
			<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_chelmash/common/arruk.gif" border=0></a>
		{/if}
		</td></tr>
{/foreach}
</table>	
