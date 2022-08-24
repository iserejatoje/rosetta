{foreach from=$res.list item=l key=y}
	<table cellpadding="3" cellspacing="0" border="0" width="100%">	<tr>
			<td bgcolor="#D1E6F0" class=title style="white-space: nowrap">
				<EM><IMG src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</td>
			</td>
		</tr>
		<tr>
			<td class="block">
					{if $l.ThumbnailImg.file }
					<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:20px;" /></a>
					{/if}
					<font id='gray'>{$l.Date|date_format:"%d.%m.%Y"}</font></br>
					<font class='head14t'><a href="{$l.Link}{$l.NewsID}.html">
			{if $l.TitleType==2}
				<font style='font-size:18px;'>{$l.TitleArr.name}</font>,<br/>{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
			{else}
				<b>{$l.Title}</b>
			{/if}</a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
			</font></br>
					<img src='/_img/x.gif' width='1' height='5' border='0' /><br/>
					{if $res.withtext==1}
					{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:200:"..."}{/if}
					{/foreach}
					{/if}
	{*if $l.otz.count}
	{foreach from=$l.otz.list item=o}
			<img src='/_img/x.gif' width='1' height='10' border='0' /><br/>
			<b><font class="user">{$o.name|truncate:20:"..."},&nbsp;{$o.date|date_format:"%e.%m"}:</font></b>&nbsp;
			{$o.otziv|truncate:30:"...":true}&nbsp;<a href="{$o.url}"><img src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" align="middle" alt="читать далее"/></a>
			
			</td>
		</tr>
	{/foreach}
	{/if*}
			</td>
		</tr>
{if !empty($l.Comment)}
		<tr>
			<td class="block">
				<div class="text11"><b><font class="user">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}, {$l.Comment.Created|date_format:"%H:%M"}:</font></b> {$l.Comment.Text|truncate:80:"...":false}
				<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" title="Читать далее"><img src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" align="middle" alt="читать далее"/></a></div>
			</td>
		</tr>
{/if}
		</table>
{/foreach}