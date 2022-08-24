<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td width="37">
<img width="37" height="35" src="/_img/design/200710_diplom/icostat.gif"/>
</td>
<td valign="top" background="/_img/design/200710_diplom/backnews.gif" align="right">
<font class="zag1-1">{$res.title}</font>
</td>
</tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
	{foreach from=$res.list item=l key=k}
		{if $k>0}
			<tr><td bgcolor="#666666"><img src='/_img/design/200710_diplom/rast.gif' width=1 height=1 border=0></td></tr>
		{/if}
		<tr>
			<td valign="top" style="padding-left: 10px;"><a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
				{if $l.TitleType==2}
					<a href="{$l.Link}{$l.NewsID}.html"><font  class=zag2>{$l.TitleArr.name}</font></a>,<br/><font style="font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
				{else}
					<a href="{$l.Link}{$l.NewsID}.html"><font  class=zag2>{$l.Title}</font></a>
				{/if}
				</font>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br>
				{if $l.TitleType!=2}
				<br><font class=bok>
				{foreach from=$l.Anon item=Anon key=k}
				{if $k<3 }{$Anon|truncate:100:"..."}{/if}
				{/foreach}</font>
				{/if}
			</td>
        </tr>
		</td><tr>
		{if !empty($l.Comment)}
				<tr>
				<td align="left" style="padding-bottom:2px; padding-left: 10px;" class="small">
				<font color="#CC0000"><b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> 
				<font color="#666666">{$l.Comment.Text|truncate:40:"...":false}</font>
				<a href='{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}'><small>&gt;&gt;</small></a>
				</td></tr>
		{/if}
	{/foreach}
	<tr><td align="right" style="padding-left: 10px;"><a href="{$l.Link}" title="все статьи"><img  alt="все статьи" src='/_img/design/200710_diplom/str.gif' width=11 height=11 border=0></a></td></tr>
</table>