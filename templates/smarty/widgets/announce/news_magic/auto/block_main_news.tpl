{if !empty($res.list)}
<table class="block_main" cellspacing="0" cellpadding="0" >
<tr>
	<th><span>&nbsp;&nbsp;{$res.title}&nbsp;&nbsp;</span></th>
	<th align="right" valign="bottom" width="18"><img src="/_img/design/200710_auto/bul-zag.gif" width="18" height="13"></th>
</tr>
</table>
{/if}
<table border="0" cellpadding="0" cellspacing="3" width="100%" class="block_main_news">
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
				{if $CURRENT_ENV.site.domain != $ENV.site.domain }
					<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}"> 
				{else}
					<a href="{$l.Link}{$l.NewsID}.html"> 
				{/if}
				<img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			{if $l.Title==2}
				{if $CURRENT_ENV.site.domain != $ENV.site.domain }
					<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" class="anon"> 
				{else} 
					<a href="{$l.Link}{$l.NewsID}.html" class="anon"> 
				{/if}
				<span class="anon_name">{$l.TitleArr.name}, {$l.TitleArr.position}</a>{if $l.TitleArr.text}: <br/>{$l.TitleArr.text}{/if}
			{else} 				
				{if $CURRENT_ENV.site.domain != $ENV.site.domain }
					<a href="/service/go/?url={"`$l.Link``$l.NewsID`.html"|escape:"url"}" class="anon"> 
				{else} 
					<a href="{$l.Link}{$l.NewsID}.html" class="anon">
				{/if}
					<span class="anon_name">{$l.Title}
			{/if}
				</span></a>{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br/>

			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.Anon item=Anon key=k}
					{if $k<3}{$Anon|truncate:100:"..."}{/if}
				{/foreach}
			</span>
			{/if}
			<div>
			{if !empty($l.Comment)}
					<span class="comment_name_news">{if !empty($l.Comment.User.Name)}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if},</span> 
					<span class="comment_time_news">{$l.Comment.Created|date_format:"%e.%m"}:</span>
					<span class="bl_otziv">{$l.Comment.Text|truncate:35:"...":false}&nbsp; 
					{if $CURRENT_ENV.site.domain != $ENV.site.domain }
						<noindex><a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}" rel="nofollow">
					{else}
						<a href="{$l.Link}{$l.NewsID}.html?p=last#comment{$l.Comment.CommentID}">
					{/if}
					<img src="/_img/design/200710_auto/bull-spis.gif" align="absmiddle" alt="читать далее" border="0" height="7" width="9"></a>
					{if $CURRENT_ENV.site.domain != $ENV.site.domain }
						</noindex>
					{/if}
					</span>
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