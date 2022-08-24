<table width="100%" class="block_right" cellspacing="0" cellpadding="0">
<tr><th><span>{$res.title}</span></th></tr>
</table>
<table width="100%" cellspacing="2" cellpadding="0">
<tr>
	<td bgcolor="#80b4d9"><img src="/_img/design/200710_afisha/rast.gif" alt="" height="3" width="1"></td>
</tr>
</table>
<table width="100%" class="block_right" cellspacing="3" cellpadding="0">
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
	<tr><td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="center" style="margin-right:3px;" /></a>
			{/if}
		</td>
	</tr>
	<tr><td>
		<a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span><br/><span class="anon_position">{$l.TitleArr.position}{else}{$l.Title}{/if}</span></a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			<div>
			{if !empty($l.Comment)}
			<span class="comment_name">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> 
			<span class="comment_time">{$l.Comment.Created|date_format:"%e.%m"}:</span> <span class="bl_otziv">{$l.Comment.Text|truncate:40:"...":false}
			<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">
			<img src="/_img/design/200710_afisha/bull-2b.gif" alt="читать далее" align="middle" border="0" height="12" width="12"></a></span>
			{/if}
			</div>
		</span>
		</td>
	</tr>
	<tr valign="bottom"><td>
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>