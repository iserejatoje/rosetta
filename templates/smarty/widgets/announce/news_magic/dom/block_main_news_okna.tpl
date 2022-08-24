<table class="block_main" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><th><span>{$res.title}</span></th>
		<th width="97"><img src="/_img/design/200710_dom/gorod_green.gif"></th>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="3" width="100%" class="block_main">
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
	<tr align="center">
		<td>
			{if $l.ThumbnailImg.file }
				<a href="{$l.Link}{$l.NewsID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<span>{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2} {$l.Date|date_format:"%Y"}</span><br/><a href="{$l.Link}{$l.NewsID}.html" class="anon"><span class="anon_name">{if $l.TitleType==2}{$l.TitleArr.name},</span> <span class="anon_position">{$l.TitleArr.position}: {$l.TitleArr.text}{else}{$l.Title}{/if}</span></a>
			{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/>
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}
			</span>
			{/if}
		</td>
	</tr>
	<tr>
		<td>
			{if !empty($l.Comment)}
				{foreach from=$l.otz.list item=o}
					<b>{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b> 
					<span class="bl_otziv">{$l.Comment.Text|truncate:40:"...":false}
					<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a></span>
				{/foreach}
			{/if}
		</td>
	</tr>
	<tr valign="bottom"><td>
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
