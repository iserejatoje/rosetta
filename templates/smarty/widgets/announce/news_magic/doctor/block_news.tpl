{if !empty($res.list)}
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="10"><img src="/_img/design/200710_doctor/bokzag1_top.gif" width="10" height="5" alt="" /></td>
	<td bgcolor="#E3F6FF"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td width="10"><img src="/_img/design/200710_doctor/bokzag2_top.gif" width="10" height="5" alt="" /></td>
</tr>
<tr>
	<td width="10" bgcolor="#E3F6FF"><img src="/_img/x.gif" width="10" height="1" alt="" /></td>
	<td bgcolor="#E3F6FF" class="block_right">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr><th><span>{$res.title}</span></th></tr>
	</table>
	</td>
	<td width="10" bgcolor="#E3F6FF"><img src="/_img/x.gif" width="10" height="1" alt="" /></td>
</tr>
<tr>
	<td width="10"><img src="/_img/design/200710_doctor/bokzag1_bot.gif" width="10" height="5" alt="" /></td>
	<td bgcolor="#E3F6FF"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	<td width="10"><img src="/_img/design/200710_doctor/bokzag2_bot.gif" width="10" height="5" alt="" /></td>
</tr>
</table>
{/if}
<table width="100%" class="block_right_news" cellspacing="3" cellpadding="0">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y name=list}
{if date("Ymd",$date) != date("Ymd",$l.Date)}
{assign var="date" value=$l.Date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
{*
	<tr><td><span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></td></tr>
*}
{if !$smarty.foreach.list.first}
	<tr><td bgcolor="#E3F6FF"><img src="/_img/x.gif" width="1" height="1" alt="" /></td></tr>
{/if}
	<tr><td align="center" valign="top"><a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span></a><br/><span class="anon_position">{$l.TitleArr.position}:</span><span class="anon_text"> {$l.TitleArr.text}{else}{$l.Title}</a>{/if}</span>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}</td></tr>
	<tr>
		<td {if $res.withtext!=1}align="center" valign="top"{/if}>
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
	{if !empty($l.Comment)}
	<tr>
		<td>
			<div class="comment_descr">
					<span class="comment_name">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</span>
					{$l.Comment.Text|truncate:40:"...":false}
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">далее</a>
			</div>
		</td>
	</tr>
	{/if}
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>