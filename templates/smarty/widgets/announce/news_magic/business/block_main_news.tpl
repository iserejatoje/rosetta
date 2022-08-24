<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td bgcolor="#92b3c7"><img src="/_img/x.gif" height="3" width="1"></td>
</tr>
<tr>
	<td bgcolor="#f1f6f9">
	<table border="0" cellpadding="0" cellspacing="0" class="block_main_news">
	<tr>
		<th>
		&nbsp;&nbsp;&nbsp;&nbsp;<span>{$res.title}</span>&nbsp;&nbsp;&nbsp;&nbsp;
		</th>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td valign="top"><img src="/_img/x.gif" height="5" width="1"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="3" width="100%" class="block_main_news">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr align="center">
		<td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span> <span class="anon_position">{$l.TitleArr.position}: <b>{$l.TitleArr.text}</b>{else}{$l.Title}{/if}</span></a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/>
			{if $l.TitleType!=2 && $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:160:"..."}{/if}
				{/foreach}
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if !empty($l.Comment)}
			<div class="comment_descr">
					<span class="comment_name">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> <span class="comment_time"> {$l.Comment.Created|date_format:"%H:%M"}:</span>
					{$l.Comment.Text|truncate:40:"...":false}
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_business/str.gif" alt="читать далее" align="middle" border="0" height="9" width="9"></a>
			</div>
			{/if}
		</td>
	</tr>
	<tr valign="bottom"><td>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
