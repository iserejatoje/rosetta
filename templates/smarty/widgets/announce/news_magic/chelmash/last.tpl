{if $res.list }
<table width=100% border=0 cellspacing=1 cellpadding=3>
	{foreach from=$res.list item=l}
			<tr> 
				<td valign=top align=center bgcolor="#F5F5F5">
						{*$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}
						<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />*}
          {if $l.ThumbnailImg.file }
						<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.Title|strip_tags}" /></a>
						<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
					{/if}
					<a href="{$l.Link}{$l.NewsID}.html">{if $l.TitleType==2}<b>{$l.TitleArr.name}</b>,<br />{$l.TitleArr.position}{else}<b>{$l.Title}</b>{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
          {if !empty($l.Comment)}
						<br /><img src="/_img/x.gif" width="1" height="7" border="0"><br />
						<div align="left">
							<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, 
							{$l.Comment.Created|date_format:"%e.%m"}:</b>
							&nbsp;{$l.Comment.Text|truncate:40:"...":false}&nbsp;<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_chelmash/common/arruk.gif" width=6 height=7 border=0 align=absmiddle alt="читать далее" /></a>
							<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
						</div>
					{/if}

			</tr>
	{/foreach}
</table>
<br/>
{/if}