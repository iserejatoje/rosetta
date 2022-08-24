<table width="100%" border="0" cellspacing="0" cellpadding="0" class="block_left">
{if $res.withtext==1 }
{* это случай с текстом, здесь все форматировано по левому краю *}
	{foreach from=$res.list item=l}
		<tr><td align="left" style="padding-bottom:2px;">
		{if !$l.isNow}
					<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
				{elseif $l.isNow==1}
					<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
				{/if}
		<a href="{$l.Link}{$l.NameID}.html">
		{if $l.TitleType==2}
			{$l.TitleArr.name},<br/><font style="font-size:13px;font-weight:normal;text-decoration:none;">{$l.TitleArr.position}{if $l.TitleArr.text}: <b>{$l.TitleArr.text}</b>{/if}
		{else}
			{$l.Title}
		{/if}
		</a>
		</td><tr>
		<tr><td align="left" style="padding-bottom:2px">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NameID}.html"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" border="0" alt="{$l.Title|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
		{/if}
		{foreach from=$l.Anon item=Anon key=k}
		{if $k<3 }{$Anon}{/if}
		{/foreach}
		</td><tr>
		{if !empty($l.Comment)}
				<tr><td align="left" style="padding-bottom:2px" class="comment_descr">
				<span class="comment_name"><b>{if !empty($l.Comment.user.Name)}{$l.Comment.user.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span>
				{$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NameID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a>
				</td></tr>
		{/if}
	{/foreach}
{else}
{* это случай без текстом, здесь все форматировано по центру *}
	{foreach from=$res.list item=l key=k}
		<tr><td><div align="center" style="padding:0px"><span class="bl_date_news">{$l.Date|date_format:"%e"} {$l.Date|month_to_string:2}</span></div></td></tr>
		<tr><td style="padding-bottom:2px">
		<div align="center" class="bl_body">
		{if $l.ThumbnailImg.file }
			<a href="{$l.Link}{$l.NameID}.html" class="bl_title_news"><img src="{$l.ThumbnailImg.file}" width="{$l.ThumbnailImg.w}" height="{$l.ThumbnailImg.h}" align="center" border="0" alt="{$l.Title|strip_tags}" /></a>
			<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
		{/if}
		{if !$l.isNow}
						<font style="font-size:12px; color:red;"><b>{$l.DateStart|simply_date:"%f":"%e-%m"|ucfirst} c {$l.DateStart|date_format:"%H:%M"} до {$l.DateEnd|date_format:"%H:%M"}</b></font><br/>
					{elseif $l.isNow==1}
						<img src="/_img/modules/conference/is_now.gif" title="Сейчас на сайте" alt="Сейчас на сайте" width="68" height="11" /><br/>
					{/if}
			<a href="{$l.Link}{$l.NameID}.html" class="bl_title_news">
			{if $l.TitleType==2}
				<b>{$l.TitleArr.name}</b>,<br /><font style="text-decoration:none;">{$l.TitleArr.position}</font>
			{else}
				<b>{$l.Title}</b>
			{/if}</a>
		{if !empty($l.Comment)}
				<div class="small">
				<span class="comment_name"><b>{if !empty($l.Comment.user.Name)}{$l.Comment.user.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></span> 
				{$l.Comment.Text|truncate:40:"...":false}
				<a href="{$l.Link}{$l.NameID}.html?p=last#comment{$l.Comment.CommentID}"><small>&gt;&gt;</small></a>
				</div>
		{/if}
		</div>
		</td></tr>
	{/foreach}
{/if}
</table>
