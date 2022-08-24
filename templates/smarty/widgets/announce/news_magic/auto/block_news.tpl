{if !empty($res.list)}
<table width="100%" class="block_right" cellspacing="0" cellpadding="0" >
<tr>
	<th align="left" valign="bottom" width="18"><img src="/_img/design/200710_auto/bul-zag.gif" width="18" height="13"></th>
	<th><span>&nbsp;&nbsp;{$res.title}</span></th>
</tr>
</table>
{/if}
<table width="100%" class="block_right_news" cellspacing="3" cellpadding="0">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.Date)}
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
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" style="margin-right:3px;margin-bottom:3px;" /></a>
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
	<tr><td><a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">
	{if $l.Title==2}
		{$l.TitleArr.name},</span> 
		<span class="anon_position">{$l.TitleArr.position}
	{else}
		{$l.Title}
	{/if}
	</span></a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
	</td></tr>

	{if !empty($l.Comment)}
	<tr>
		<td>
			<div class="comment_descr">
					<span class="comment_name_news">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> 
					<span class="comment_time_news">{$l.Comment.Created|date_format:"%e.%m"}:</span> 
					{$l.Comment.Text|truncate:35:"...":false}
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><img src="/_img/design/200710_auto/bull-spis.gif" alt="читать далее" align="middle" border="0" height="7" width="9"></a>
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