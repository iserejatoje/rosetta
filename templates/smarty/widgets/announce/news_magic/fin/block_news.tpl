{if !empty($res.list)}
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td valign="top" width="13"><img src="/_img/design/200710_fin/zag2.gif" height="23" width="13"></td>
	<td bgcolor="#b3c9d7">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr bgcolor="#85a0b2">
			<th align="left" class="block_right"><span>
			{$res.title}</span></th>
			<td align="right" valign="bottom" width="10"><img src="/_img/design/200710_fin/zag2ugol.gif" height="23" width="10"></td>
		</tr>
		</table>
	</td>
</tr>
</table>
{/if}
<table width="100%" class="block_right_news" cellspacing="3" cellpadding="0" bgcolor="#E3ECF2">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{*if date("Ymd",$date) != date("Ymd",$l.Date)*}
{assign var="date" value=$l.Date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr><td><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
	<tr>
		<td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr><td><a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span> 
	<span class="anon_position">{$l.TitleArr.position}{else}{$l.Title}{/if}</span></a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</td></tr>
			{if !empty($l.Comment)}
	<tr>
		<td>
			<div class="comment_descr">
					<span class="comment_name">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</span> 
					{$l.Comment.Text|truncate:40:"...":false}
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">
					<img src="/_img/design/200710_fin/bullspis.gif" alt="читать далее" align="middle" border="0" height="9" width="9"></a>
			</div>
		</td>
	</tr>
	{/if}
{*/if*}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>