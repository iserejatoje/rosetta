{if !empty($res.list)}
{*<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td width="10"><img src="/_img/design/200710_doctor/bokzag1.gif" alt="" height="24" width="10"></td>
	<td bgcolor="#E3F6FF" class="block_right">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr><th><span>{$res.title}</span></th></tr>
	</table>
	</td>
	<td width="11"><img src="/_img/design/200710_doctor/bokzag2.gif" alt="" height="24" width="11"></td>
</tr>
<tr>
	<td><img src="/_img/x.gif" alt="" height="5" width="1"></td>
	<td><img src="/_img/x.gif" alt="" height="5" width="1"></td>
	<td><img src="/_img/x.gif" alt="" height="5" width="1"></td>
</tr>
</table>*}
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr bgcolor="#d5eaf4">
		<td width="10">&nbsp;</td>
		<td colspan="5" style="padding-left: 5px;"><font class="zag2">{$res.title}</font></td>
		<td width="10">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3"><img src="/_img/x.gif" height="10" width="1"></td>
	</tr>
</tbody>
{/if}
<table border="0" cellpadding="0" cellspacing="3" width="100%" class="block_main_news">
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
{if !$smarty.foreach.list.first}
	<tr><td bgcolor="#E3F6FF"><img src="/_img/x.gif" width="1" height="1" alt="" /></td></tr>
{/if}
	<tr>
		<td style="padding-left: 15px;">
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleTitleType==2}{$l.TitleArr.name},</span></a> <span class="anon_position">{$l.TitleArr.position}:</span>
			<span class="anon_text"> {$l.TitleArr.text}{else}{$l.Title}</a>{/if}</span>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/><br/>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:200:"..."}{/if}
				{/foreach}
			</span>
			{/if}
			<div class="comment_descr">
			{if !empty($l.Comment)}
					<b><span class="comment_name">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> 
					<span class="comment_time">{$l.Comment.Created|date_format:"%e.%m"}:</span> 
					<span class="bl_otziv">{$l.Comment.Text|truncate:40:"...":false}&nbsp;
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">далее</a></span>
			{/if}
			</div>
		</td>
	</tr>
	<tr valign="bottom"><td>
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>